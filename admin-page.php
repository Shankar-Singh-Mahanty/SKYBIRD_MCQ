<?php
include 'authenticate.php';
checkUser("admin");
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>SKYBIRD Admin Page</title>
	<link rel="icon" type="image/webp" href="logo.webp" />
	<link rel="stylesheet" href="base.css" />
	<link rel="stylesheet" href="admin-page.css" />

</head>

<body>
	<header>
		<div class="header-top">
			<a href="./">
				<h1>SKYBIRD's</h1>
				<h1>MCQ Tests</h1>
			</a>
			<!-- Add this button -->
			<a class="logout-button" href="logout.php">
				Logout
			</a>
		</div>
	</header>

	<section id="admin-services">
		<h2>Admin Services</h2>
		<div class="services-container">
			<div class="service">
				<a href="./create-student.php">
					<img src="icons/create_student.webp" alt="Create Student" />
					<h3>Create Student</h3>
					<p>Create new student accounts to appear tests.</p>
				</a>
			</div>
			<div class="service">
				<a href="student-details.php">
					<img src="icons/student_details.webp" alt="Student Details" />
					<h3>Student Details</h3>
					<p>
						View and manage student details, activate or deactivate
						students.
					</p>
				</a>
			</div>
			<div class="service">
				<a href="test-management.php">
					<img src="icon/cug_details.webp" alt="CUG Details" />
					<h3>Test Management</h3>
					<p>
						Create, edit and delete tests.
                        Define test parameters.
                        Schedule tests and organize them into categories or subjects.
					</p>
				</a>
			</div>
			<div class="service">
				<a href="./qbank-management.php">
					<img src="icon/add_cug1.webp" alt="Add New CUG" />
					<h3>Question Bank Management</h3>
					<p>
                        Create, edit and delete questions.
                        Categorize questions by topic and difficulty level.
                        Import and export questions in bulk.
                    </p>
				</a>
			</div>
			<div class="service">
				<a href="./result-management.php">
					<img src="icon/upload_cug.webp" alt="Add New CUG" />
					<h3>Result Management</h3>
					<p>
                        View and analyze student test results.
                        Generate reports on student performance.
                        Export result data for further analysis.
                    </p>
				</a>
			</div>
			
	</section>

	<footer>
		<p>&copy; 2025 SKYBIR. All rights reserved.</p>
		<div class="footer-links">
			<a href="#">Privacy Policy</a>
			<a href="#">Terms of Service</a>
		</div>
	</footer>
	<script>
		document.addEventListener("DOMContentLoaded", () =>
		{
			const card = document.querySelector(".service");

			card.addEventListener("mousemove", (e) =>
			{
				const rect = card.getBoundingClientRect();
				const x = e.clientX - rect.left;
				const y = e.clientY - rect.top;
				const centerX = rect.width / 2;
				const centerY = rect.height / 2;

				const shadowX = (x - centerX) / 10;
				const shadowY = (y - centerY) / 10;

				document.documentElement.style.setProperty(
					"--card-shadow-x",
					`${ shadowX }rem`
				);
				document.documentElement.style.setProperty(
					"--card-shadow-y",
					`-${ shadowY }rem`
				);
			});

			card.addEventListener("mouseleave", () =>
			{
				document.documentElement.style.setProperty(
					"--card-shadow-x",
					"0px"
				);
				document.documentElement.style.setProperty(
					"--card-shadow-y",
					"0px"
				);
			});
		});
	</script>
</body>

</html>