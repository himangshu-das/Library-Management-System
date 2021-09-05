<?php
	require "../db_connect.php";
	require "verify_librarian.php";
?>
<html>
	<head>
		<title>Welcome</title>
		<link rel="stylesheet" type="text/css" href="CSS/home_style.css" />
        
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
		<div id="allTheThings">
			
		<a href="book_index.php">
				<input type="button" value="Book Index" />
			</a><br />
		
			<a href="pending_book_requests.php">
				<input type="button" value="Books Issued" />
			</a><br />
			<a href="insert_book.php">
				<input type="button" value="Add a new book" />
			</a><br />
			<a href="update_copies.php">
				<input type="button" value="Update copies of a book" />
			</a><br />
			<a href="update_balance.php">
				<input type="button" value="Update Book Price" />
			</a><br />
		
		</div>
	</body>
</html>