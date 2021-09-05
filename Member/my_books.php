<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_member.php";

?>

<html>
	<head>
		<title>My books</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/custom_checkbox_style.css">
		<link rel="stylesheet" type="text/css" href="CSS/my_books_style.css">
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
			$query = $con->prepare("SELECT book_isbn FROM pending_book_requests WHERE member = ?;");
			$query->bind_param("s", $_SESSION['username']);
			$query->execute();
			$result = $query->get_result();
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>No books currently issued</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<legend>My books</legend>";
				echo "<div class='success-message' id='success-message'>
						<p id='success'></p>
					</div>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo"<table width='100%' cellpadding='10' cellspacing='10'>
						<tr>
							<th></th>
							<th>ISBN<hr></th>
							<th>Title<hr></th>
							<th>Author<hr></th>
							<th>Category<hr></th>
							
						</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$isbn = mysqli_fetch_array($result)[0];
					if($isbn != NULL)
					{
						$query = $con->prepare("SELECT title, author, category FROM book WHERE isbn = ?;");
						$query->bind_param("s", $isbn);
						$query->execute();
						$innerRow = mysqli_fetch_array($query->get_result());
						echo "<tr>
								<td>
									<label class='control control--checkbox'>
										<input type='checkbox' name='cb_book".$i."' value='".$isbn."'>
										<div class='control__indicator'></div>
									</label>
								</td>";
						echo "<td>".$isbn."</td>";
						for($j=0; $j<3; $j++)
							echo "<td>".$innerRow[$j]."</td>";
						$query = $con->prepare("SELECT request_id FROM pending_book_requests WHERE member = ? AND book_isbn = ?;");
						$query->bind_param("ss", $_SESSION['username'], $isbn);
						$query->execute();
						echo "".mysqli_fetch_array($query->get_result())[0]."</td>";
						echo "</tr>";
					}
				}
				echo "</table><br />";
				echo "<input type='submit' name='b_return' value='Return selected books' />";
				echo "</form>";
			}
			
			if(isset($_POST['b_return']))
			{
				$books = 0;
				for($i=0; $i<$rows; $i++)
					if(isset($_POST['cb_book'.$i]))
					{
						
						$query = $con->prepare("DELETE FROM pending_book_requests WHERE member = ? AND book_isbn = ?;");
						$query->bind_param("ss", $_SESSION['username'], $_POST['cb_book'.$i]);
						if(!$query->execute())
							die(error_without_field("ERROR: Couldn\'t return the books"));
					
						else
						echo error_without_field("Please select a book to return");
			}
		}
		?>
		
	</body>
</html>