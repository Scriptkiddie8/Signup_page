<?php
session_start();
if (!isset($_SESSION['name'])) { 
    header("Location: signup.php");
    exit();
}
echo $_SESSION['name'];

include "config.php";

$sql = "SELECT sno, username, email FROM user";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .hello {
            text-align: center;
        }

        button {
            margin: 0 5px;
        }
    </style>
</head>

<body>
    <h2>User Details</h2>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th> <!-- Updated column name -->
            </tr>
        </thead>
        <tbody>
            <?php
            if($result && mysqli_num_rows($result) > 0) {
                $sno = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $sno . "</td>";
                    echo "<td>" . ($row['username']) . "</td>";
                    echo "<td>" . ($row['email']) . "</td>";
                    echo "<td>
                    <button><a href='edit.php?id=" . $row['sno'] . "'>Edit</a></button>
                    <button><a href='delete.php?id=" . $row['sno'] . "'>Delete</a></button>
                  </td>";
            
                    echo "</tr>";
                    $sno++;
                }
            } else {
                echo "<tr><td colspan='4' class='hello'>No records found.</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
    <button><a href="logout.php">Logout</a></button>
</body>

</html>