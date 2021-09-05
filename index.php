<?php
	require "db_connect.php";
	session_start();
	
	if(empty($_SESSION['type']));
	else if(strcmp($_SESSION['type'], "librarian") == 0)
		header("Location: librarian/home.php");
	else if(strcmp($_SESSION['type'], "member") == 0)
		header("Location: member/home.php");
?>
<html>
	<head>
		<title>Library</title>
		<link rel="stylesheet" type="text/css" href="CSS/index_style.css" />
    <link rel="stylesheet" type="text/css" href="CSS/header_style.css" />
  </head>
	<body>
    <header>
			<a href="./">
				<div id="cd-logo">
					<img src="img/books.png" alt="Logo" />
					<p>LIBRARY</p>
				</div>
			</a>
		</header>
		<div id="allTheThings">
			<div id="member">
				<a href="Member/index.php">
					<img src="img/ic_member.svg" width="250px" height="auto" style="background-color: #343642"/><br />
					&nbsp;<h1 style="color:#343642;">Member</h1></a>
				
			</div>
			<div id="verticalLine">
				<div id="librarian">
					<a id="librarian-link" href="Librarian/index.php">
						<img src="img/ic_librarian.svg" width="250px" height="auto" style="background-color: #343642"/><br />
						&nbsp;&nbsp;&nbsp;<h1 style="color:#343642;">Librarian</h1>
					</a>
				</div>
			</div>
		</div>
	</body>
</html>