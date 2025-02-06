<?php
include 'authenticate.php';
checkUser("dealer");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>SKYBIRD Student Page</title>
	<link rel="icon" type="image/webp" href="logo.webp" />
	<link rel="stylesheet" href="base.css" />
	<link rel="stylesheet" href="admin-page.css" />
</head>

<body>
	<div class="content">
		<header>
			<div class="header-top">
				<a href="./">
					<h1>SKYBIRD’s</h1>
					<h1>MCQ Tests</h1>
				</a>
				<a class="logout-button" href="logout.php">
					Logout
				</a>
			</div>
		</header>

		<section id="admin-services">
			<h2>Student Services</h2>
			<div class="services-container">
				<div class="service">
					<a href="profile-management.php">
						<img src="icon/add_cug1.webp" alt="Add New CUG" />
						<h3>Profile Management</h3>
						<p>
                            View and Update personal profile information.
                            Change password.
                        </p>
					</a>
				</div>
				<div class="service">
					<a href="./test-taking.php">
						<img src="icon/upload_cug.webp" alt="Add New CUG" />
						<h3>Test Taking</h3>
						<p>
                            View available tests and respective timeframes.
                            Receive feedback on incorrect answer and Scorecard.
                        </p>
					</a>
				</div>
				<div class="service">
					<a href="result-viewing.php">
						<img src="icon/de-activate_cug.webp" alt="De-Active CUG" />
						<h3>Result Viewing</h3>
						<p>
                            View past results and performance history.
                            Access feedback and explanations for questions.
                        </p>
					</a>
				</div>
				<div class="service">
					<a href="communication.php">
						<img src="icon/allocation_report.webp" alt="Allocation-Wise Report" />
						<h3>Communication</h3>
						<p>Feedback and communication with teacher.</p>
					</a>
				</div>
				
		</section>
	</div>

	<footer>
		<p>&copy; 2025 SKYBIRD. All rights reserved.</p>
		<div class="footer-links">
			<a href="#">Privacy Policy</a>
			<a href="#">Terms of Service</a>
		</div>
	</footer>
</body>

</html>