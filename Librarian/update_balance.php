<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_librarian.php";
?>

<html>
	<head>
		<title>Update balance</title>
		<link rel="stylesheet" type="text/css" href="../CSS/global_styles.css" />
		<link rel="stylesheet" type="text/css" href="../CSS/form_styles.css" />
		<link rel="stylesheet" href="CSS/update_balance_style.css">
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
		<form class="cd-form" method="POST" action="#">
			<legend>Enter the details</legend>
			
				<div class="error-message" id="error-message">
					<p id="error"></p>
				</div>
				
				<div class="icon">
					<input class="b-isbn" type='text' name='b_isbn' id="b_isbn" placeholder="Book ISBN" required />
				</div>
					
				<div class="icon">
					<input class="b-copies" type="number" name="b_copies" placeholder="Price" required />
				</div>
						
				<input type="submit" name="b_add" value="Update Price" />
		</form>
	</body>
	</body>
	
	<?php

		if(isset($_POST['b_add']))
		{
			$query = $con->prepare("SELECT isbn FROM book WHERE isbn = ?;");
			$query->bind_param("s", $_POST['b_isbn']);
			$query->execute();
			if(mysqli_num_rows($query->get_result()) != 1)
				echo error_with_field("Invalid ISBN", "b_isbn");
			else
			{
				$query = $con->prepare("UPDATE book SET price = ? WHERE isbn = ?;");
				$query->bind_param("ds", $_POST['b_copies'], $_POST['b_isbn']);
				if(!$query->execute())
					die(error_without_field("ERROR: Couldn\'t Update price"));
				echo success("Price successfully updated");
			}
		}
	?>
</html>