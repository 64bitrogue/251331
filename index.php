<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>251331</title>
</head>
<body>
    <header>
        <div>
            <h1>Name</h1>
            <h2>Group #</h2>
            <p>Feel free to remove this header.</p>
        </div>
    </header>
    <main>
        <section>
            <a href="add-resident.php">+ New Resident</a>
            <a href="transaction.php">Transaction</a>
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
                    <tr>
                        <td>Test</td>
                        <td>Test</td>
                        <td>Test</td>
                        <td>Test</td>
                        <td>
                            <a href="edit.php">Edit</a>
                            <form onsubmit="confirm('Sure?')" action="delete.php" method="post">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>