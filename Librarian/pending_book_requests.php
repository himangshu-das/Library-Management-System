<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_librarian.php";
	
?>

<html>
	<head>
		<title>Pending Book Requests</title>
		<link rel="stylesheet" type="text/css" href="../CSS/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../CSS/custom_checkbox_style.css">
		<link rel="stylesheet" type="text/css" href="CSS/pending_book_requests_style.css">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,700">
		<link rel="stylesheet" type="text/css" href="CSS/header_librarian_style.css" />
	
	
	</head>
	<body>
	<header>
			<div id="cd-logo">
				<a href="../">
					<img src="../img/books.png" alt="Logo" />
					<p>LIBRARY</p>
				</a>
			</div>
			
			<div class="dropdown">
				<button class="dropbtn">
					<p id="librarian-name"><?php echo $_SESSION['username'] ?></p>
				</button>
				<div class="dropdown-content">
					<a href="../logout.php">Logout</a>
				</div>
			</div>
		</header>
		<?php
			$query = $con->prepare("SELECT member,book_isbn,time FROM pending_book_requests;");
			$query->execute();
			$result = $query->get_result();;
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>No Books Issued</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<legend>Books Issued</legend>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>
						<tr>
							
							<th>Username<hr></th>
							<th>Book ISBN<hr></th>
							<th>Time<hr></th>
						</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$row = mysqli_fetch_array($result);
					echo "<tr>";
					for($j=0; $j<3; $j++)
						echo "<td>".$row[$j]."</td>";
					echo "</tr>";
				}
				
			}
			
				
			?>
			</body>
		</html>