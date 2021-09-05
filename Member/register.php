<?php
	require "../db_connect.php";
	require "../message_display.php";
/*	$username = $password = $name = $email = $password = "";
	$username_err = $password_err = $email_err = $password_err = "";
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(empty(trim($_POST["username"])))
		{
			$username_err = "Username cannot be blank";
		}
		else
		{
			$sql = "SELECT id FROM users WHERE username = ?";
			$stmt = mysqli_prepare($link, $sql); 
			if($stmt)
			{
				mysqli_stmt_bind_param($stmt, "s", $param_username);

				$param_username = trim($_POST['username']);

				if(mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_store_result($stmt);
				}
			}
		}
	}*/




?>
<html>
	<head>
		<title>Register</title>
		<link rel="stylesheet" type="text/css" href="../CSS/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../CSS/form_styles.css">
		<link rel="stylesheet" href="CSS/register_style.css">
        <link rel="stylesheet" type="text/css" href="../CSS/header_style.css" />
		<script type="text/javascript">   
			function validateform(){   
			var m_pass=document.getElementById("m_pass");  
			console.log(document.FORM_NAME);
			if(m_pass.value.length<4){  
				alert("Password must be at least 4 characters long."); 
				return false;
			}
		}  
		</script>
	</head>
	<body>
        <header>
			<a href="../">
				<div id="cd-logo">
					<img src="../img/books.png" alt="Logo" />
					<p>LIBRARY</p>
				</div>
			</a>
		</header>
		<form name="FORM_NAME" class="cd-form" onsubmit="return validateform()" method="POST" action="#">
			<legend>Enter your details</legend>
			
				<div class="error-message" id="error-message">
					<p id="error"></p>
				</div>
				
				<div class="icon">
					<input class="m-user" type="text" name="m_user" id="m_user" placeholder="Username" required />
				</div>
				
				<div class="icon">
					<input class="m-pass" type="password" name="m_pass" id="m_passr" placeholder="Password" required />
				</div>
				
				<div class="icon">
					<input class="m-name" type="text" name="m_name" placeholder="Full Name" required />
				</div>
				
				<div class="icon">
					<input class="m-email" type="email" name="m_email" id="m_email" placeholder="Email" required />
				</div>
				
				
				<br />
				<a href="home.html"><input type="submit" name="m_register" value="Register" /></a>
		</form>
	
	</body>
	<?php
		if(isset($_POST['m_register']))
		{
				$query = $con->prepare("(SELECT username FROM member WHERE username = ?) UNION (SELECT username FROM pending_registrations WHERE username = ?);");
				$query->bind_param("ss", $_POST['m_user'], $_POST['m_user']);
				$query->execute();
				if(mysqli_num_rows($query->get_result()) != 0)
					echo error_with_field("The username you entered is already taken", "m_user");
				else
				{
					$query = $con->prepare("(SELECT email FROM member WHERE email = ?) UNION (SELECT email FROM pending_registrations WHERE email = ?);");
					$query->bind_param("ss", $_POST['m_email'], $_POST['m_email']);
					$query->execute();
					if(mysqli_num_rows($query->get_result()) != 0)
						echo error_with_field("An account is already registered with that email", "m_email");
					else
					{
						$query = $con->prepare("INSERT INTO member(username, password, name, email) VALUES(?, ?, ?, ?);");
						$query->bind_param("ssss", $_POST['m_user'], ($_POST['m_pass']), $_POST['m_name'], $_POST['m_email']);
						if($query->execute())
							echo success("Your membership has been accepted by the library. You can now issue books using your account.");
						else
							echo error_without_field("Couldn\'t record details. Please try again later");
					}
				}
			
		}
	?>
	
</html>