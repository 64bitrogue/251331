<?php

include "connect.php";

$id = null;
$year = null;
$application_age = null;

$total_grant = null;
$errors = [];

if (isset($_POST['submit'])) {
    $id = trim(htmlspecialchars(strip_tags($_POST['id'])));
    $application_year = intval(trim(htmlspecialchars(strip_tags($_POST['year']))));

    if (empty($id)) {
        $errors['id'] = "Please enter a resident code."; 
    }

    if (empty($application_year)) {
        $errors['year'] = "Please enter the year of application.";
    }

    $query = "SELECT * FROM residents WHERE resident_code = '$id'";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $birthdate = new DateTime($row['date_of_birth']);
        $birthyear = intval($birthdate->format('Y'));

        if ($application_year < $birthyear) {
            $errors['year'] = "Application year cannot be before the year of birth.";
        } else {
            $monthly_salary = $row['avg_monthly_salary'];
            if ($monthly_salary > 14000) {
                $errors['disqualified'] = "Applicant is not entitled for cash grant as their average family monthly salary exceeds Php 14,000.00."; 
            } else {
                $age = $application_year - $birthyear;
                $application_age = $age;
    
                if ($age >= 4) {
                    if ($age <= 17) {
                        $total_grant = 0;
                        while ($age <= 17) {
                            if ($age >= 4 && $age <= 11) {
                                $total_grant += 300 * 12;
                            } else if ($age >= 12 && $age <= 15) {
                                $total_grant += 500 * 12;
                            } else if ($age >= 16 && $age <= 17) {
                                $total_grant += 700 * 12;
                            }
                            $age++;
                        }
                    } else {
                        $errors['disqualified'] = "Applicant is no longer entitled for cash grant as they are already older than 17 years old.";
                    }
                } else {
                    $errors['disqualified'] = "Applicant is not yet entitled for cash grant as they are still younger than 4 years old.";
                }
            }
        }

    } else {
        $errors['id'] = "Resident code not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Module</title>
</head>
<body>
    <header>
        <a href="index.php">Go Back</a>
    </header>
    <main>
        <h1>Transaction Module</h1>
        <form action="transact.php" method="POST">
            <div>
                <label for="id">Resident Code</label>
                <select name="id" id="id">
                    <option value="">Select Resident Code</option>
                    <?php
                    $list_query = "SELECT * FROM residents";
                    $residents = mysqli_query($connection, $list_query);

                    if (mysqli_num_rows($residents) > 0) {
                        while ($row = mysqli_fetch_assoc($residents)) {
                            ?>
                            <option value="<?= $row['resident_code'] ?>" <?= $id == $row['resident_code'] ? 'selected' : '' ?>><?= $row['resident_code'] ?> - <?= $row['given_name'] ?> <?= $row['family_name'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <?php
                if (isset($errors['id'])) {
                    ?>
                    <p><?= $errors['id'] ?></p>
                    <?php
                }
                ?>
            </div>
            <div>
                <label for="id">Year of Application</label>
                <input type="number" min="1000" max="9999" name="year" id="year" value="<?= $application_year ?>">
                <?php
                if (isset($errors['year'])) {
                    ?>
                    <p><?= $errors['year'] ?></p>
                    <?php
                }
                ?>
            </div>
            <button type="submit" name="submit">Submit</button>
        </form>

        <?php
        if (isset($errors['disqualified'])) {
            ?>
            <p><?= $errors['disqualified'] ?></p>
            <?php
        } else if (isset($total_grant)) {
            ?>
            <p>Total Cash Grant: Php <?= number_format($total_grant, 2) ?></p>
            <p>Resident is entitled of cash grant from <?= $application_age ?> years old to 17 years old.</p>
            <?php
        }
        ?>
    </main>
</body>
</html>