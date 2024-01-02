<?php

include "connect.php";

$given_name = null;
$middle_name = null;
$family_name = null;
$civil_status = null;
$birthdate = null;
$salary = null;

$resident_code = trim(htmlspecialchars(strip_tags($_GET['id'])));

$errors = [];

if (isset($_POST['submit'])) {
    $given_name = trim(htmlspecialchars(strip_tags($_POST["given-name"])));
    $middle_name = trim(htmlspecialchars(strip_tags($_POST["middle-name"])));
    $family_name = trim(htmlspecialchars(strip_tags($_POST["family-name"])));
    $civil_status = trim(htmlspecialchars(strip_tags($_POST["civil-status"])));
    $birthdate = $_POST["birthdate"];
    $salary = $_POST["salary"];


    if (empty($given_name)) {
        $errors['given-name'] = "Please enter the given name.";
    }

    if (empty($middle_name)) {
        $errors['middle-name'] = "Please enter the middle name.";
    }

    if (empty($family_name)) {
        $errors['family-name'] = "Please enter the family name.";
    }

    if (empty($civil_status)) {
        $errors['civil-status'] = "Please indicate the civil status.";
    }

    $birthdate_timestamp = strtotime($birthdate);

    if (!$birthdate_timestamp) {
        $errors['birthdate'] = "Please enter a valid date of birth.";
    } else if ($birthdate_timestamp > time()) {
        $errors['birthdate'] = "Date of birth cannot be a future date.";
    }

    if (empty($salary)) {
        $errors['salary'] = "Please indicate the average monthly salary.";
    } else if ($salary < 0) {
        $errors['$salary'] = "The average monthly salary value cannot be negative.";
    }

    if (count($errors) == 0) {
        $birthdate = date("Y-m-d", $birthdate_timestamp);
        $query = "UPDATE residents SET given_name = '$given_name',
                                       middle_name = '$middle_name',
                                       family_name = '$family_name',
                                       civil_status = '$civil_status',
                                       date_of_birth = '$birthdate',
                                       avg_monthly_salary = '$salary'     
                                   WHERE resident_code = '$resident_code'";

        if ($connection->query($query)) {
            $connection->close();
            header("Location: index.php");
        } else {
            echo "Error: " . $connection->error;
        }

    }
} else {
    $query = "SELECT * FROM residents WHERE resident_code = '$resident_code'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $given_name = $row["given_name"];
        $middle_name = $row['middle_name'];
        $family_name = $row['family_name'];
        $civil_status = $row['civil_status'];
        $birthdate = $row['date_of_birth'];
        $salary = $row['avg_monthly_salary'];
    } else {
        die("Resident code not found.");
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resident</title>
    <style>
        form > div p {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <a href="index.php">Go Back</a>
    </header>
    <main>
        <h1>Edit Resident Information</h1>
        <form action="edit.php?id=<?= $resident_code ?>" method="POST">
            <div>
                <div>
                    <label for="name">Given Name</label>
                    <input type="text" name="given-name" id="given-name" value="<?= $given_name ?>">
                    <?php
                    if (isset($errors['given-name'])) {
                        ?>
                        <p><?= $errors['given-name'] ?></p>
                        <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="name">Middle Name</label>
                    <input type="text" name="middle-name" id="middle-name" value="<?= $middle_name ?>">
                    <?php
                    if (isset($errors['middle-name'])) {
                        ?>
                        <p><?= $errors['middle-name'] ?></p>
                        <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="name">Family Name</label>
                    <input type="text" name="family-name" id="family-name" value="<?= $family_name ?>">
                    <?php
                    if (isset($errors['family-name'])) {
                        ?>
                        <p><?= $errors['family-name'] ?></p>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div>
                <label for="name">Civil Status</label>
                <input type="text" name="civil-status" id="civil-status" value="<?= $civil_status ?>">
                <?php
                if (isset($errors['civil-status'])) {
                    ?>
                    <p><?= $errors['civil-status'] ?></p>
                    <?php
                }
                ?>
            </div>
            <div>
                <label for="name">Date of Birth</label>
                <input type="date" name="birthdate" id="birthdate" value="<?= $birthdate ?>">
                    <?php
                    if (isset($errors['birthdate'])) {
                        ?>
                        <p><?= $errors['birthdate'] ?></p>
                        <?php
                    }
                    ?>
            </div>
            <div>
                <label for="name">Average Family Monthly Salary</label>
                <input type="number" min="1" step="any" name="salary" id="salary" value="<?= $salary ?>">
                    <?php
                    if (isset($errors['salary'])) {
                        ?>
                        <p><?= $errors['salary'] ?></p>
                        <?php
                    }
                    ?>
            </div>
            <button type="submit" name="submit">Add Resident</button>
        </form>
    </main>
</body>

</html>