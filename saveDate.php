<?php

	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header ('Location: index.php');
		exit();
	}
	
	if(isset($_POST['periodOfTime']))
	{
		$allGood = true;
		$periodOfTime = $_POST['periodOfTime'];
		$_SESSION['formPeriodOfTime'] = $periodOfTime;
	}
	
	if(isset($_POST['startDate'])) 
	{
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];
		$now = date('Y-m-d');
		$startDate = htmlentities($startDate,ENT_QUOTES, "UTF-8");
		$endDate = htmlentities($endDate,ENT_QUOTES, "UTF-8");
		$allGood = true;
		
		if($startDate == NULL)
		{
			$allGood = false;
			$_SESSION['errorStartDate'] = "Wybierz datę dla początku okresu.";
		}
				
		if($endDate == NULL)
		{
			$allGood = false;
			$_SESSION['errorEndDate'] = "Wybierz datę dla końca wykresu.";
		}				
					
		if($startDate > $now)
		{
			$allGood = false;
			$_SESSION['errorStartDate'] = "Data początku okresu nie może być większa od dzisiejszej daty.";
		}
					
		if($endDate > $now)
		{
			$allGood = false;
			$_SESSION['errorEndDate'] = "Data końca okresu nie może być większa od dzisiejszej daty.";
		}
			
		if($endDate!=NULL && $startDate!=NULL)
		{
			if($endDate < $startDate)
			{
				$allGood = false;
				$_SESSION['errorEndDate'] = "Data końca okresu nie może być mniejsza od daty początku okresu.";
			}
		}
		
		$_SESSION['formStartDate'] = $startDate;
		$_SESSION['formEndDate'] = $endDate;
		
		$_SESSION['periodStartDate'] = $startDate  ;
		$_SESSION['periodEndDate'] = $endDate;
		
	
		if ((isset($_SESSION['periodStartDate'])) && isset($_SESSION['periodEndDate']) && $allGood == true)
		{
			header ('Location: balance.php');
		}
		
		
	}
?>

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<title>Bilans</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Show Balance">
	<meta name="keywords" content="personalny, budżet, bilans, przychody, wydatki, saldo">
	<meta name="author" content="Dariusz Krygier">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
		<link rel="stylesheet" href="css/bootstrap.min.css">
	
	<link rel="stylesheet" href="style.css">
	
	 <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	<script src="https://kit.fontawesome.com/9855606672.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="RGraph.common.core.js"></script>
<script src="RGraph.common.dynamic.js"></script>
<script src="RGraph.common.tooltips.js"></script>
<script src="RGraph.pie.js"></script>

	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body class="d-flex flex-column min-vh-10">

	<header>
	
			
	
		<span class = "logo text-uppercase">
			
					<i class="fa fa-coins "></i> Budżet personalny
					
		</span>
	
			<h1 class="text-uppercase text-dark naglowek ml-0"> Bilans </h1>
			
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
					
					<li class="nav-item px-3 ">
						<a class="nav-link" href="addExpense.php"><i class="fas fa-shopping-cart"></i> Wydatki </a>
					</li>
					
					<li class="nav-item px-3 active">
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
				
					<div class="row text-justify">
				
						<?php
				if(isset($_SESSION['formPeriodOfTime'])&& $_SESSION['formPeriodOfTime'] == "selectedPeriod")
				{
		
				echo '<div class="col-md-5 col-md-offset-2 bg3">';
					echo '<form method = "POST" >';
							echo '<div class="row">';
								echo '<h3 class="articleHeader">Wybierz okres czasu dla bilansu.</h3>';
							echo '</div>';
							echo '<div class="row rowExpense">';
										echo '<div class="form-group">';
										echo '<label class="control-label col-sm-4 text-right" for="startDate">Początek okresu:</label>';
										echo '<div class="col-sm-6">';
											echo '<input type="date" name="startDate" value="';
											if (isset($_SESSION['formStartDate']))
											{
												echo $_SESSION['formStartDate'];
												unset($_SESSION['formStartDate']);
											}
											echo '"class="form-control" placeholder="dd-mm-rrrr">';
											
											if (isset($_SESSION['errorStartDate']))
											{
												echo '<div class="error">'.$_SESSION['errorStartDate'].'</div>';
												unset($_SESSION['errorStartDate']);
											}
											
										echo '</div>';
										echo '<div class="col-sm-2"></div>';  
										echo '</div>';
							echo '</div>';
							echo '<div class="row">';
								echo '<div class="form-group">';
									echo '<label class="control-label col-sm-4 text-right" for="endDate">Koniec okresu:</label>';
									echo '<div class="col-sm-6">';
										echo '<input type="date" name="endDate" value="';
											if (isset($_SESSION['formEndDate']))
											{
												echo $_SESSION['formEndDate'];
												unset($_SESSION['formEndDate']);
											}
											echo '" class="form-control" placeholder="dd-mm-rrrr">';
										if (isset($_SESSION['errorEndDate']))
											{
												echo '<div class="error">'.$_SESSION['errorEndDate'].'</div>';
												unset($_SESSION['errorEndDate']);
											}
									echo '</div>';
								echo '<div class="col-sm-2"></div>';  
								echo '</div>';
							echo '</div>';
							echo '<div class="row ">';
								echo '<div class="col-sm-7 col-sm-offset-3">';
									echo '<button type="submit" class="btnSetting">Wyświetl bilans</button>';
								echo '</div>';
								echo '<div class="col-sm-2"></div>';
							echo '</div>';
							
					echo '</form>';
				echo '</div>';
				
				}
				else if ($_SESSION['formPeriodOfTime'] == "currentMonth" || $_SESSION['formPeriodOfTime'] == "previousMonth" || $_SESSION['formPeriodOfTime'] == "currentYear")
				{ 
					header ('Location: balance.php');
				}
				
				?>
				
					</div>
			
				</div>				
				
		</article>
		
	</main>
	
	<footer class="mt-auto">
	
		
		<div class="info">
		
		Wszelkie prawa zastrzeżone &copy; 2021 Oszczędzaj pieniądze, nie bierz kredytów!
		
		</div>
	
	</footer>
	
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	<script src="budget.js"></script>

</body>
</html>