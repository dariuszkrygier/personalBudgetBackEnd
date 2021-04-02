<?php

	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header ('Location: index.php');
		exit();
	}
	
	if(isset($_POST['amount']))
	{
		//Successful validation
		$allGood = true;
		
		//Validate amount
		$amount = $_POST['amount'];
		$amount = htmlentities($amount,ENT_QUOTES, "UTF-8");
		
		//Is the variable a number?
		if(is_numeric($amount))
		{
			$amount = round($amount,2);
		}
		else
		{
			$allGood = false;
			$_SESSION['errorAmountExpense']="Kwota musi być liczbą. Format:1234.45";
		}
		
		//if the number format is appropriate
		if($amount >= 1000000000)
		{
			$allGood = false;
			$_SESSION['errorAmountExpense']="Kwota musi być liczbą mniejszą od 1 000 000 000.";
		}
		
		//validate date
		$date = $_POST['date'];
		$date = htmlentities($date,ENT_QUOTES, "UTF-8");
		
		if($date == NULL)
		{
			$allGod = false;
			$_SESSION['errorDateExpense'] = "Wybierz datę dla wydatku.";
		}
		
		$currentDate = date('Y-m-d');
		
		if($date > $currentDate)
		{
			$allGood = false;
			$_SESSION['errorDateExpense'] = "Data musi być aktualna lub wcześniejsza.";	
		}
		
		
		//if paymentmethod  are selected
		if(isset($_POST['paymentMethod'])) 
		{
			$paymentMethod = $_POST['paymentMethod'];
			$_SESSION['formPaymentMethod'] = $paymentMethod;
		}
		else
		{
			$allGood = false;
			$_SESSION['errorPaymentMethod'] = "Wybierz kategorię dla płatności.";
		}
		
		//if categories expense are selected
		if(isset($_POST['categoryOfExpense'])) 
		{
			$category = $_POST['categoryOfExpense'];
			$_SESSION['formCategoryExpense'] = $category;
		}
		else
		{
			$allGood = false;
			$_SESSION['errorCategoryExpense'] = "Wybierz kategorię dla wydatku.";
		}
		
		//Validate comment
		$comment = $_POST['comment'];
		$comment = htmlentities($comment,ENT_QUOTES, "UTF-8");
		
		if((strlen($comment) > 100))
		{
			$allGood = false;
			$_SESSION['errorCommentExpense'] = "Komentarz może mieć maksymalnie 100 znaków.";
		}
		
		//Remember entered data
		$_SESSION['formAmountExpense'] = $amount;
		$_SESSION['formDateExpense'] = $date;
		$_SESSION['formCommentExpense'] = $comment;
		
		//Connect database
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			$connection->set_charset("utf8");
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$userId = $_SESSION['id'];
				//All Good
				if ($allGood==true)
				{
					$sql="INSERT INTO expenses VALUES (NULL, '$userId',(SELECT id FROM expenses_category_assigned_to_users WHERE user_id ='$userId' AND name ='$category'),(SELECT id FROM payment_methods_assigned_to_users WHERE user_id ='$userId' AND name='$paymentMethod'),'$amount','$date','$comment')";
					//Adding a user to the database
					if ($connection->query($sql))
					{
						$_SESSION['successfulAddExpense'] = true;
					    header('Location:successExpense.php');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
			}
			$connection->close();
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
?>

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<title>Dodaj wydatek</title>
	<meta name="description" content="Add Expense">
	<meta name="keywords" content="personalny, budżet, bilans, przychody, wydatki, saldo">
	<meta name="author" content="Dariusz Krygier">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	
	<link rel="stylesheet" href="style.css">
	
	 <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	<script src="https://kit.fontawesome.com/9855606672.js" crossorigin="anonymous"></script>
	
	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body class="d-flex flex-column min-vh-10">

	<header>
	
			
	
		<span class = "logo text-uppercase">
			
					<i class="fa fa-coins "></i> Budżet personalny
					
		</span>
	
			<h1 class="text-uppercase text-dark naglowek ml-0"> Dodaj wydatek </h1>
			
		<nav class="navbar navbar-dark bg-dark navbar-expand-lg justify-content-center text-light py-1">
			 
		
					
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="collapse navbar-collapse justify-content-center " id="mainmenu">
			
				<ul class="navbar-nav">
				
					<li class="nav-item px-3">
						<a class="nav-link" href="mainMenu.php"><i class="fas fa-home"></i> Start </a>
					</li>
					
					<li class="nav-item px-3 ">
						<a class="nav-link " href="addIncome.php"><i class="fas fa-hand-holding-usd"></i> Przychody </a>
					</li>
					
					<li class="nav-item px-3 active">
						<a class="nav-link" href="addExpense.php"><i class="fas fa-shopping-cart"></i> Wydatki </a>
					</li>
					
					<li class="nav-item px-3">
						<a class="nav-link" href="showBalance.php"><i class="fas fa-balance-scale-right"></i> Bilans </a>
					</li>
					
					<li class="nav-item px-3">
						<a class="nav-link" href="settings.php"><i class="fas fa-cogs"></i> Ustawienia </a>
					</li>
					
					<li class="nav-item px-3">
						<a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Wyloguj </a>
					</li>
				
				</ul>
			
			</div>
		
		</nav>	
		

	</header>
	
	<main>
	
		
		
		<article>
		
		
			<div class="container">
				
				<div class="row" id="logowanie">
		
					<form method="post" class="main-form needs-validation" novalidate style="width:350px; margin-auto">	
					
						
						
						<div class="form-group">
							 <div class="input-group">
								<div class="input-group-prepend">
									<i class="fas fa-coins"></i> 
							    </div>
								<input type="number" name="amount" step="0.01" class="form-control" id="wplata" placeholder="Podaj kwotę" onfocus="this.placeholder=''" onblur="this.placeholder='Podaj kwotę'" required value="<?php 
											if (isset($_SESSION['formAmountExpense']))
											{
												echo $_SESSION['formAmountExpense'];
												unset($_SESSION['formAmountExpense']);
											}
										?>">
										
											<?php
											if (isset($_SESSION['errorAmountExpense']))
											{
												echo '<div class="error">'.$_SESSION['errorAmountExpense'].'</div>';
												unset($_SESSION['errorAmountExpense']);
											}
											?> 
								<div class="invalid-feedback">Podaj kwotę!</div>
							 </div>
							 
						</div>
						
						
						<div class="form-group">	
							<div class="input-group">
								<div class="input-group-prepend">
									<i class="fas fa-calendar-week"></i> 
							    </div>
								<input type="date" name="date" id="theDate" class="form-control" required value="<?php 
											if (isset($_SESSION['formDateExpense']))
											{
												echo $_SESSION['formDateExpense'];
												unset($_SESSION['formDateExpense']);
											}
											else
											{
												echo date('Y-m-d'); 
											}
										?>">
											<?php
											if (isset($_SESSION['errorDateExpense']))
											{
												echo '<div class="error">'.$_SESSION['errorDateExpense'].'</div>';
												unset($_SESSION['errorDateExpense']);
											}
											?>
								<div class="invalid-feedback">Podaj datę!</div>
								<script type="text/javascript" src="budget.js"></script>
							</div>
						</div>
						
						<div class="form-group incomeCategory">
						
							
							<label ><span><i class="fas fa-cash-register" aria-hidden="true"></i> Metoda płatności:</span></label>
						<!--		
							<div class="form-check">				
							  <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCategory" value="option1" checked>
							  <label class="form-check-label" for="paymentMethod">
								Gotówka
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCategory2" value="option2">
							  <label class="form-check-label" for="paymentMethod2">
								Karta debetowa
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCategory3" value="option3" >
							  <label class="form-check-label" for="paymentMethod3">
								Karta kredytowa
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCategory4" value="option4" >
							  <label class="form-check-label" for="paymentMethod4">
								Przelew
							  </label>
							</div>
						-->
						
						<?php

							//Connect database
							require_once "connect.php";
							mysqli_report(MYSQLI_REPORT_STRICT);
								
							try
							{
								$connection = new mysqli($host, $db_user, $db_password, $db_name);
								$connection->set_charset("utf8");
								
								if ($connection->connect_errno!=0)
								{
									throw new Exception(mysqli_connect_errno());
								}
								
								else
								{
									//Check number of income categories
									$userId = $_SESSION['id'];
							
									$resultOfQuery=$connection->query("SELECT name FROM payment_methods_assigned_to_users WHERE user_id ='$userId'");
									
									if(!$resultOfQuery) throw new Exception($connection->error);
										
									$howNames=$resultOfQuery->num_rows;
									
									
									if($howNames>0)
									{
										while ($row = $resultOfQuery->fetch_assoc())
										{
											
											echo '<div class="form-check">';
											echo '<label class="form-check-label">';
											echo '<input type="radio" name="paymentMethod" value="'.$row['name'];
											
											if(isset($_SESSION['formPaymentMethod']))
											{
												if($row['name'] == $_SESSION['formPaymentMethod']) 
												{
													echo '"checked ="checked"';
												}
											}
											
											echo '">'.$row['name'].'</label>';
											echo '</div>';
											
								
										}
										
										$resultOfQuery->free_result();
									}
									else
									{
										
									}
								}
								$connection->close();
							}
							catch(Exception $e)
							{
								echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
								echo '<br />Informacja developerska: '.$e;
							}
						?>	
						<?php
							if (isset($_SESSION['errorPaymentMethod']))
							{
								echo '<div class="error">'.$_SESSION['errorPaymentMethod'].'</div>';
								unset($_SESSION['errorPaymentMethod']);
							}
						?>		
						
						</div>
						
						 <div class="form-group incomeCategory">
										  <label for="sel1"><span><i class="fas fa-tasks" aria-hidden="true"></i> Kategoria:</span></label>
										  
						<!--
										  <select class="form-control" id="sel1" name="categoryOfExpense">
											<option>Jedzenie</option>
											<option>Mieszkanie</option>
											<option>Transport</option>
											<option>Telekomunikacja</option>
											<option>Opieka zdrowotna</option>
											<option>Ubranie</option>
											<option>Higiena</option>
											<option>Dzieci</option>
											<option>Rozrywka</option>
											<option>Wycieczka</option>
											<option>Szkolenia</option>
											<option>Książki</option>
											<option>Oszczędności</option>
											<option>Na złotą jesień, czyli emeryturę</option>
											<option>Spłata długów</option>
											<option>Darowizna</option>
											<option>Inne wydatki</option>
										  </select>
										  
								<div class="form-group my-2">
									<label for="comment">Komentarz (opcjonalnie):</label>
									<textarea class="form-control" rows="2"   id="comment"></textarea>
								</div> 
						 </div>
						
						-->

									<?php

	//Connect database
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
		
	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		$connection->set_charset("utf8");
		if ($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		
		else
		{
			//Check number of paymentMethod
			$userId = $_SESSION['id'];
			
			$resultOfQuery=$connection->query("SELECT name FROM expenses_category_assigned_to_users WHERE user_id ='$userId'");
			
			if(!$resultOfQuery) throw new Exception($connection->error);
				
			$howNames=$resultOfQuery->num_rows;
			
			if($howNames>0)
			{
				echo '<select class="form-control" id="sel1" name="categoryOfExpense">';
				while ($row = $resultOfQuery->fetch_assoc())
				{
					
					
					
					echo '<option value=' . $row['name'] . '>' . $row['name'] . '</option>';
					
					if(isset($_SESSION['formCategoryExpense']))
					{
						if($row['name'] == $_SESSION['formCategoryExpense']) 
						{
							echo '"selected ="selected"';
						}
					}
					
					
			
			    }
				$resultOfQuery->free_result();
				echo '</select>';

					
			}
			else
			{
				
			}
		}
		$connection->close();
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		echo '<br />Informacja developerska: '.$e;
	}
?>
<?php
	if (isset($_SESSION['errorCategoryExpense']))
	{
		echo '<div class="error">'.$_SESSION['errorCategoryExpense'].'</div>';
		unset($_SESSION['errorCategoryExpense']);
	}
?>			
									
									<div class="form-group rowExpense">
										<label for="comment">Komentarz (opcjonalnie):</label>
										<textarea class="form-control" rows="3" name = "comment" ><?php 
											if (isset($_SESSION['formCommentExpense']))
											{
												echo $_SESSION['formCommentExpense'];
												unset($_SESSION['formCommentExpense']);
											}
										?></textarea>
									<?php
	if (isset($_SESSION['errorCommentExpense']))
	{
		echo '<div class="error">'.$_SESSION['errorCommentExpense'].'</div>';
		unset($_SESSION['errorCommentExpense']);
	}
?>	
									</div>
</div>
						
							<div>
								<input type="submit" class="btn btn-success " value="Dodaj">
								
								
								<input type="reset" class="btn btn-danger" value="Anuluj"  data-toggle="modal" data-target="#myModal">
								
								
								<!-- The Modal 
								<div class="modal fade" id="myModal">
								  <div class="modal-dialog">
									<div class="modal-content">

									  <!-- Modal Header 
									  <div class="modal-header">
										<h4 class="modal-title">Anuluj dodawanie wydatku</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									  </div>

									  <!-- Modal body 
									  <div class="modal-body">
										Wprowadzone dane zostaną utracone.<br>
										Czy jesteś pewien, że chcesz je usunąć?
									  </div>

									  <!-- Modal footer 
									  <div class="modal-footer">
									  
										<button type="button" class="resetbtn btn-info btn-outline-danger" value="Usuń dane" data-dismiss="modal">Usuń dane</button>
										<button type="button" class="cancelbtn btn-info btn-outline-success" value="zostawDane" >Zostaw dane</button>
										
									  </div>

									</div>
								  </div>
								</div>
								-->
							</div>
							
						
					
					</form>	

				</div>
				
			</div>
		
			
		
		
		</article>
		
	</main>
	
	<footer class="mt-auto">
	
		
		<div class="info">
		
		Wszelkie prawa zastrzeżone &copy; 2021 Oszczędzaj pieniądze, nie bierz kredytów!
		
		</div>
	
	</footer>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="budget.js"></script>

</body>
</html>