<?php
include 'authenticate.php';
checkUser("admin");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link rel="icon" type="image/webp" href="logo.webp" />
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="student-details.css">
    </head>

<body>
    <header>
        <div class="header-top">
            <a href="">
                <h1>SKYBIRD's</h1>
                <h1>MCQ Test</h1>
            </a>
        </div>
    </header>
    <main>
        <section id="student-details">
            <div class="heading-container">
                <button class="back-btn" onclick="window.location.href = 'admin-page.php'"><img
                        src="icon/back-button.webp" alt="back button"></button>
                <h2 class="heading">Student Details</h2>
                <div class="search-bar-container">
                    <input type="text" id="search-bar" placeholder="Search here" onkeyup="filterTable()">
                </div>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include database connection script
                        include 'db_connect.php';

                        $sql = "SELECT * FROM users";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["contact"] . "</td>";
                                echo "<td>" . $row["address"] . "</td>";
                                echo "<td>" . $row["status"] . "</td>";

                                $created_at = new DateTime($row["created_at"]);
                                $updated_at = new DateTime($row["updated_at"]);

                                echo "<td>" . $created_at->format('g:i A \o\n jS M, y') . "</td>";
                                echo "<td>" . $updated_at->format('g:i A \o\n jS M, y') . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12'>No records found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 SKYBIRD. All rights reserved.</p>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
        </div>
    </footer>
    <script>
    function filterTable() {
        const input = document.getElementById('search-bar');
        const filter = input.value.toUpperCase();
        const table = document.querySelector('#users table');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            let tdArray = tr[i].getElementsByTagName('td');
            let match = false;
            for (let j = 0; j < tdArray.length; j++) {
                let td = tdArray[j];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }
            tr[i].style.display = match ? "" : "none";
        }
    }
    </script>
</body>

</html>
