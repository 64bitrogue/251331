<?php

include "connect.php";

$search = null;
$query = null;

if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
    $search = trim(htmlspecialchars(strip_tags($_GET['search'])));
    $query = "SELECT * FROM residents WHERE resident_code LIKE '%$search%' OR resident_name LIKE '%$search%'";
} else {
    $query = "SELECT * FROM residents";
}

$result = mysqli_query($connection, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>251331</title>
</head>
<body>
    <main>
        <section>
            <a href="create.php">New Resident</a>
            <a href="transact.php">Transaction</a>
            <div>
                <form action="index.php" method="get">
                    <input type="text" name="search" id="search" value="<?= $search ?>">
                    <button type="submit">Search</button>
                </form>
            </div>
        </section>
        <section>
            <table>
                <thead>
                    <th>Resident ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Average Family Monthly Salary</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?= $row['resident_code'] ?></td>
                        <td><?= $row['given_name'] ?> <?= $row['middle_name'] ?> <?= $row['family_name'] ?></td>
                        <td><?= date_format(date_create($row['date_of_birth']), "F j, Y") ?></td>
                        <td>Php <?= number_format($row['avg_monthly_salary'], 2) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['resident_code'] ?>">Edit</a>
                            <form onsubmit="confirm('Do you confirm deleting this record?')" action="delete.php" method="post">
                                <input type="hidden" name="id" value="<?= $row['resident_code'] ?>">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>