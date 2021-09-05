<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_member.php";
	
?>
<html>
	<head>
		<title>Welcome</title>
		<link rel="stylesheet" type="text/css" href="../CSS/global_styles.css">
		<link rel="stylesheet" type="text/css" href="CSS/home_style.css">
		<link rel="stylesheet" type="text/css" href="../CSS/">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,700">
		<link rel="stylesheet" type="text/css" href="CSS/header_member_style.css" />
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
					<a href="my_books.php">My books</a>
					<a href="../logout.php">Logout</a>
				</div>
			</div>
		</header>
		<?php
			$query = $con->prepare("SELECT * FROM book ORDER BY title");
			$query->execute();
			$result = $query->get_result();
			if(!$result)
				die("ERROR: Couldn't fetch books");
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>No books available</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<legend>Available books</legend>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>";
				echo "<tr>
						<th></th>
						<th>ISBN<hr></th>
						<th>Title<hr></th>
						<th>Author<hr></th>
						<th>Category<hr></th>
						<th>Price<hr></th>
						<th>Copies available<hr></th>
					</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$row = mysqli_fetch_array($result);
					echo "<tr>
							<td>
								<label class='control control--radio'>
									<input type='radio' name='rd_book' value=".$row[0]." />
								<div class='control__indicator'></div>
							</td>";
					for($j=0; $j<6; $j++)
						if($j == 4)
							echo "<td>$".$row[$j]."</td>";
						else
							echo "<td>".$row[$j]."</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "<br /><br /><input type='submit' name='m_request' value='Issue book' />";
				echo "</form>";
			}
			
			if(isset($_POST['m_request']))
			{
                if(empty($_POST['rd_book']))
					echo error_without_field("Please select a book to issue");
                 else
				{
										
					$query = $con->prepare("INSERT INTO pending_book_requests(member, book_isbn) VALUES(?, ?);");
										$query->bind_param("ss", $_SESSION['username'], $_POST['rd_book']);
										if(!$query->execute())
											echo error_without_field("ERROR: Couldn\'t request book");
										else
											echo success("Book successfully Issued");
                }
          }
    
		?>
			
			
			
	</body>
</html>