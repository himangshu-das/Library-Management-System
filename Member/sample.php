if(isset($_POST['m_request']))
			{
                if(empty($_POST['rd_book']))
					echo error_without_field("Please select a book to issue");
                 else
				{
					$query = $con->prepare("INSERT INTO book_issue_log(member, book_isbn) VALUES(?, ?);");
										$query->bind_param("ss", $_SESSION['username'], $_POST['rd_book']);
										if(!$query->execute())
											echo error_without_field("ERROR: Couldn\'t request book");
										else
											echo success("Book successfully requested. You will be notified by email when the book is issued to your account");
                }
          }
    