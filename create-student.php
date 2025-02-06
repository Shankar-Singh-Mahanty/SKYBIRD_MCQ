<?php

include 'authenticate.php';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
checkUser($role);

// Include database connection script
include 'db_connect.php';

// Fetch course
$query = "SELECT * FROM course";
$result = $conn->query($query);
$course = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $course[] = $row;
    }
}

// Add CUG Form ------------------------------------

$studname = "";
$roll_no = "";
$course = "default";
$email = "";
$password = "";
$contact = "";
$address = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studname = trim($_POST['NAME']);
    $roll_no = trim($_POST['ROLL_NO']);
    $course = trim($_POST['COURSE']);
    $email = trim($_POST['EMAIL']);
    $password = trim($_POST['PASSWORD']);
    $contact = trim($_POST['CONTACT_NO']);
    $address = trim($_POST['ADDRESS']);
    $status = "Active";

    $errors = [];
    if (empty($studname))
        $errors[] = "Name is required.";
    if (empty($roll_no))
        $errors[] = "Roll No is required.";
    if ($course == "default")
        $errors[] = "course is required.";
    if (empty($email))
        $errors[] = "Email ID is required.";
    if (empty($password))
        $errors[] = "Password is required.";
    if (empty($contact)) {
        $errors[] = "Contact No is required.";
    } elseif (!is_numeric($contact) || (strlen($contact) != 10) || $contact <= 0) {
        $errors[] = "Contact No must be a positive numeric value and 10 digits long.";
    }
    if (empty($address))
        $errors[] = "Address is required.";

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
    } else {
        // Prepare and execute insertion into studentdetails
        $stmt_stud = $conn->prepare("INSERT INTO studentdetails (roll_number, studname, course, email, password, contact, address, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt_stud === false) {
            $_SESSION['errors'] = ["Error preparing studdetails statement: " . $conn->error];
        } else {
            $stmt_stud->bind_param("ssssiss", $roll_no, $studname, $course, $email, $contact, $address, $status);
            if ($stmt_stud->execute()) {
                $_SESSION['success'] = "$studname is successfully allotted for MCQ test.";

                // Insert into studdetails_transaction after successful insertion into studdetails
                $stmt_transaction = $conn->prepare("INSERT INTO users (username, email, password, contact, address, role) VALUES (?, ?, ?, ?, ?, 'student')");
                if ($stmt_transaction === false) {
                    $_SESSION['errors'] = ["Error preparing transaction statement: " . $conn->error];
                } else {
                    $stmt_transaction->bind_param("ssssss", $username, $email, $password, $contact, $address, $role);
                    if ($stmt_transaction->execute()) {
                        $_SESSION['success'] .= " & Student recorded.";
                    } else {
                        $_SESSION['errors'] = ["Error inserting student: " . $stmt_transaction->error];
                    }
                    $stmt_transaction->close();
                }
            } else {
                $_SESSION['errors'] = ["Error inserting into student details: " . $stmt_stud->error];
            }
            $stmt_stud->close();
        }
    }

    header("Location: create-student.php");
    exit();
}

if (isset($_SESSION['form_data'])) {
    $studname = $_SESSION['form_data']['NAME'];
    $roll_no = $_SESSION['form_data']['ROLL_NO'];
    $course = $_SESSION['form_data']['COURSE'];
    $email = $_SESSION['form_data']['EMAIL'];
    $password = $_SESSION['form_data']['PASSWORD'];
    $contact = $_SESSION['form_data']['CONTACT_NO'];
    $address = $_SESSION['form_data']['ADDRESS'];
    unset($_SESSION['form_data']);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta studname="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Student</title>
    <link rel="icon" type="image/webp" href="logo.webp" />
    <link rel="stylesheet" href="base.css" />
    <link rel="stylesheet" href="create-student.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: "#eef2ff",
                            100: "#e0e7ff",
                            200: "#c7d2fe",
                            300: "#a5b4fc",
                            400: "#818cf8",
                            500: "#6366f1",
                            600: "#4f46e5",
                            700: "#4338ca",
                            800: "#3730a3",
                            900: "#312e81",
                            950: "#1e1b4b",
                        },
                        "accent-color": "var(--accent-color)",
                        "accent-color-hover": "var(--accent-color-hover)",
                    },
                },
                fontFamily: {
                    body: [
                        "Ncourseo Sans",
                        "ui-sans-serif",
                        "system-ui",
                        "-apple-system",
                        "system-ui",
                        "Segoe UI",
                        "Roboto",
                        "Helvetica Neue",
                        "Arial",
                        "Noto Sans",
                        "sans-serif",
                        "Apple Color Emoji",
                        "Segoe UI Emoji",
                        "Segoe UI Symbol",
                        "Noto Color Emoji",
                    ],
                    sans: [
                        "Ncourseo Sans",
                        "ui-sans-serif",
                        "system-ui",
                        "-apple-system",
                        "system-ui",
                        "Segoe UI",
                        "Roboto",
                        "Helvetica Neue",
                        "Arial",
                        "Noto Sans",
                        "sans-serif",
                        "Apple Color Emoji",
                        "Segoe UI Emoji",
                        "Segoe UI Symbol",
                        "Noto Color Emoji",
                    ],
                },
            },
        };
    </script>
</head>

<body>
    <header>
        <div class="header-top">
            <a href="./">
                <h1>SKYBIRD's</h1>
                <h1>MCQ Test</h1>
            </a>
        </div>
    </header>
    <main id="main">
        <div class="heading-container">
            <button class="back-btn" id="roleRedirectButton" data-role="<?php echo $role; ?>">
                <img src="icons/back-button.webp" alt="back button">
            </button>
            <h2 class="heading">Allotment Of New Student</h2>
        </div>
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="session-message error">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="session-message success">
                <p><?php echo $_SESSION['success']; ?></p>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form class="form_container" action="create-student.php" method="post">
            <div class="input_box long-input">
                <label for="rollno">Roll No</label>
                <input class="py-2 px-3" type="text" placeholder="Enter roll no." name="ROLL_NO"
                    value="<?php echo htmlspecialchars($roll_no); ?>" required />
            </div>
            <div class="input_box">
                <label for="studname">Name</label>
                <input class="py-2 px-3" type="text" placeholder="Enter Student Name" name="NAME"
                    value="<?php echo htmlspecialchars($studname); ?>" required />
            </div>
            <div class="input_box">
                <label for="course">Course</label>
                <select class="py-2 px-2" id="course" name="COURSE" required>
                    <option value="default" <?php if ($course == 'default')
                        echo 'selected'; ?>>Select Course</option>
                    <?php foreach ($course as $course_option): ?>
                        <option value="<?php echo $course_option['name']; ?>" <?php echo ($course == $course_option['name']) ? 'selected' : ''; ?>><?php echo $course_option['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input_box">
                <label for="email">Email ID</label>
                <input class="py-2 px-3" type="email" placeholder="Enter email id" name="EMAIL"
                    value="<?php echo htmlspecialchars($email); ?>" required />
            </div>
            <div class="input_box">
                <label for="password">Password</label>
                <input class="py-2 px-3" type="password" placeholder="Enter Your Password" name="PASSWORD"
                    value="<?php echo htmlspecialchars($password); ?>" required />
            </div>
            <div class="input_box">
                <label for="contact">Contact No</label>
                <input class="py-2 px-3" type="number" placeholder="Enter mobile no." name="CONTACT_NO"
                    value="<?php echo htmlspecialchars($contact_no); ?>" required />
            </div>
            <div class="input_box">
                <label for="address">Address</label>
                <input class="py-2 px-3" type="text" placeholder="Enter Your Address" name="ADDRESS"
                    value="<?php echo htmlspecialchars($address); ?>" required />
            </div>

            <button type="submit" class="submit-button">Submit</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2025 SKYBIRD. All rights reserved.</p>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
        </div>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function ()
        {
            // Role based Redirection -------------------------
            const redirectButton = document.getElementById("roleRedirectButton");
            const userRole = redirectButton.getAttribute("data-role");

            redirectButton.addEventListener("click", function ()
            {
                if (userRole === 'admin')
                {
                    window.location.href = 'admin-page.php';
                } else if (userRole === 'student')
                {
                    window.location.href = 'student-page.php';
                } else
                {
                    alert("Error: Unexpected role. Please login again.");
                }
            });

        });
    </script>

</body>

</html>