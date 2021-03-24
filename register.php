<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nickname'a
		$name = $_POST['name'];
		
		//Sprawdzenie długości nicka
		if ((strlen($name)<3) || (strlen($name)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_name']="Login musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($name)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_name']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = $_POST['password'];
		$haslo2 = $_POST['passwordConfirm'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		//Czy zaakceptowano regulamin?
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
		
		//Bot or not? Oto jest pytanie!
		$sekret = "6LdE60YaAAAAAJ4sK34TanwC1_AEpwhGeV2DRg7T";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_name'] = $name;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$rezultat = $polaczenie->query("SELECT id FROM users WHERE username='$name'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_name']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
					
					if ($polaczenie->query("INSERT INTO users VALUES ('', '$name', '$haslo_hash', '$email')"))
					{
						$_SESSION['udanarejestracja']=true;
						
						header('Location: login.php');
						
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Rejestracja</title>
	<meta name="description" content="Utwórz nowe konto">
	<meta name="keywords" content="personalny, budżet, bilans, przychody, wydatki, saldo">
	<meta name="author" content="Dariusz Krygier">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	 <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	<script src="https://kit.fontawesome.com/9855606672.js" crossorigin="anonymous"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
	
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
	
		<h1 class="text-uppercase text-dark naglowek ml-0">Rejestracja</h1>

	</header>
	
	<main class="flex-fill">
	
		<article>
		
			<div class="container">
				
				<div class="row" id="logowanie">
		
					<form method="post" class="login-form needs-validation" novalidate style="width:350px; margin-auto">	
						
						<div class="form-group">
							 <div class="input-group">
								<div class="input-group-prepend">
									<i class="fa fa-user"></i> 
							    </div>
								<input type="text" name="name" id="registerName" class="form-control" placeholder="Imię lub email" onfocus="this.placeholder=''" onblur="this.placeholder='Imię lub mail'" required value="<?php
			if (isset($_SESSION['fr_name']))
			{
				echo $_SESSION['fr_name'];
				unset($_SESSION['fr_name']);
			}
		?>">
		<?php
			if (isset($_SESSION['e_name']))
			{
				echo '<div class="error">'.$_SESSION['e_name'].'</div>';
				unset($_SESSION['e_name']);
			}
		?>
								<div class="invalid-feedback">Podaj imię!</div>
							 </div>
						</div>
						
						<div class="form-group">
							 <div class="input-group">
								<div class="input-group-prepend">
									<i class="fa fa-key"></i> 
							    </div>
								<input type="password" name="password" id="registerPassword" class="form-control" placeholder="Hasło" onfocus="this.placeholder=''" onblur="this.placeholder='Hasło'" required value="<?php
			if (isset($_SESSION['fr_haslo1']))
			{
				echo $_SESSION['fr_haslo1'];
				unset($_SESSION['fr_haslo1']);
			}
		?>">
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>	
		
								<div class="invalid-feedback">Podaj hasło!</div>
							 </div>
						</div>
							
						<div class="form-group">
							 <div class="input-group">
								<div class="input-group-prepend">
									<i class="fa fa-key"></i> 
							    </div>
								<input type="password" name="passwordConfirm" id="registerPasswordRepeat" class="form-control" placeholder="Powtórz hasło" onfocus="this.placeholder=''" onblur="this.placeholder='Powtórz hasło'" required value="<?php
			if (isset($_SESSION['fr_haslo2']))
			{
				echo $_SESSION['fr_haslo2'];
				unset($_SESSION['fr_haslo2']);
			}
		?>">
		
		
		
								<div class="invalid-feedback">Podaj hasło!</div>
							 </div>
						</div>
						
						<div class="form-group">
							 <div class="input-group">
								<div class="input-group-prepend">
									<i class="fa fa-envelope"></i> 
							    </div>
								<input type="email" name="email" id="registerEmail" class="form-control" placeholder="Email" onfocus="this.placeholder=''" onblur="this.placeholder='Email'" required value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>">
		<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		
								<div class="invalid-feedback">Podaj email!</div>
							 </div>
						</div>
						
						<div class="form-group text-light">
							
								<input type="checkbox" name="regulamin" <?php
								if (isset($_SESSION['fr_regulamin']))
								{
									echo "checked";
									unset($_SESSION['fr_regulamin']);
								}
									?>/> Akceptuję regulamin
							
						</div>
						
				<div class="g-recaptcha" data-sitekey="6LdE60YaAAAAAOiA8HQiyLQfrBuE5s6B3vL09eSO"></div>
		
		<?php
			if (isset($_SESSION['e_bot']))
			{
				echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
				unset($_SESSION['e_bot']);
			}
		?>
							
		
		<input type="submit" class="btn btn-success " value="Zarejestruj"/>

						<div class="col-xs-6 offset-xs-3">
								<a href = "login.html" class = "registerLink">
								
									<div class ="loginToRegister">
								
										Masz już konto? Zaloguj się!
								
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