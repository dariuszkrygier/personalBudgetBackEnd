<?php

	session_start();
	
	if (!isset($_SESSION['udanarejestracja']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}
	
	// Delete variables that remember values ​​entered into the form
	if (isset($_SESSION['fr_name'])) unset($_SESSION['fr_name']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
	if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
	
	// Delete registration errors
	if (isset($_SESSION['e_name'])) unset($_SESSION['e_name']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
	
?>

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Logowanie</title>
	<meta name="description" content="Zaloguj się">
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


<body>
	
<wrapper class="d-flex flex-column">

		<header>
		
		
		<span class = "logo text-uppercase">
			
					<i class="fa fa-coins "></i> Budżet personalny
					
		</span>
	
			<h1 class="text-uppercase text-dark naglowek ml-0"> 
	
			
					Logowanie
				
			
			</h1>

		</header>
		
<main class="flex-fill">
		
	<article>
			
		<div class="container">

			<div class="row" id="logowanie">
			
				<h1 class="text-dark naglowek ml-0"> 
	
			
					Rejestracja zakończona sukcesem! Zaloguj się na swoje konto.
				
			
				</h1>
			
			</div>
				
			<div class="row" id="logowanie">
		
				<form action="logUser.php" class="login-form needs-validation" novalidate style="width:350px; margin-auto" method="post">	
					
					<div class="form-group">
							 <div class="input-group">
								<div class="input-group-prepend">
									<i class="fa fa-user"></i> 
							    </div>
								<input type="text" name="login" class="form-control" id="loginName" placeholder="Login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'" required>
								<div class="invalid-feedback">Podaj login!</div>
							 </div>
						</div>
					
						<div class="form-group">
							 <div class="input-group">
								<div class="input-group-prepend">
									<i class="fa fa-key"></i> 
							    </div>
								<input type="password" name="haslo" id="passwordInput"class="form-control" placeholder="Hasło" onfocus="this.placeholder=''" onblur="this.placeholder='Hasło'" required>
								<div class="invalid-feedback">Podaj hasło!</div>
							 </div>
						</div>

						
					
						<input type="submit" class="btn btn-success " value="Zaloguj">
					
						
						<div class="col-xs-6 offset-xs-3">
						
							<a href = "register.php" class = "registerLink">
							
								<div class ="loginToRegister">
							
									Nie posiadasz konta? Zarejestruj się!
							
								</div>
							
							</a>
							
						</div>
						

					
				</form>	

				
			
			</div>
				
				
		</div>
				
				
	</article>
			
</main>


	
		<footer>
		
			
			<div class="info">
			
			Wszelkie prawa zastrzeżone &copy; 2021 Oszczędzaj pieniądze, nie bierz kredytów!
			
			</div>
		
		</footer>
	
</wrapper>	
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>

</body>
</html>