<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dodaj Przychód</title>
	<meta name="description" content="Add Income">
	<meta name="keywords" content="personalny, budżet, bilans, przychody, wydatki, saldo">
	<meta name="author" content="Dariusz Krygier">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	
	<link rel="stylesheet" href="style.css">
	
	 <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
	 

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	<script src="https://kit.fontawesome.com/9855606672.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
	
	
	

	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body class="d-flex flex-column min-vh-10">

	<header>
	
			
	
		<span class = "logo text-uppercase">
			
					<i class="fa fa-coins "></i> Budżet personalny
					
		</span>
	
			<h1 class="text-uppercase text-dark naglowek ml-0"> Dodaj przychód </h1>
			
		<nav class="navbar navbar-dark bg-dark navbar-expand-lg justify-content-center text-light py-1">
			 
		
					
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="collapse navbar-collapse justify-content-center " id="mainmenu">
			
				<ul class="navbar-nav">
				
					<li class="nav-item px-3">
						<a class="nav-link" href="mainMenu.php"><i class="fas fa-home"></i> Start </a>
					</li>
					
					<li class="nav-item px-3 active">
						<a class="nav-link " href="addIncome.php"><i class="fas fa-hand-holding-usd"></i> Przychody </a>
					</li>
					
					<li class="nav-item px-3">
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
		
					<form action="" class="main-form needs-validation" novalidate style="width:350px; margin-auto">	
					
						
						
						<div class="form-group">
							 <div class="input-group">
								<div class="input-group-prepend">
									<i class="fas fa-coins"></i> 
							    </div>
								<input type="number" name="kwota" step="0.01" class="form-control" id="wplata"placeholder="Podaj kwotę" onfocus="this.placeholder=''" onblur="this.placeholder='Podaj kwotę'" required>
								<div class="invalid-feedback">Podaj kwotę!</div>
							 </div>
						</div>
						
						
						<div class="form-group">	
							<div class="input-group">
								<div class="input-group-prepend">
									<i class="fas fa-calendar-week"></i> 
							    </div>
								<input type="date" name="date"  value="" id="theDate" class="form-control" required>
								<div class="invalid-feedback">Podaj datę!</div>
							</div>
						</div>
						
						<div class="form-group incomeCategory">
						
							<label for="sel1"><span><i class="fas fa-tasks" aria-hidden="true"></i> Kategoria:</span></label>
						
							<div class="form-check">				
							  <input class="form-check-input" type="radio" name="payCategory" id="payCategory1" value="option1" checked>
							  <label class="form-check-label" for="payCategory1">
								Wynagrodzenie
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="radio" name="payCategory" id="payCategory2" value="option2">
							  <label class="form-check-label" for="payCategory2">
								Odsetki bankowe
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="radio" name="payCategory" id="payCategory3" value="option3" >
							  <label class="form-check-label" for="payCategory3">
								Sprzedaż na allegro
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="radio" name="payCategory" id="payCategory4" value="option4" >
							  <label class="form-check-label" for="payCategory4">
								Inne
							  </label>
							</div>
							
							 <div class="form-group my-2">
							  <label for="comment">Komentarz (opcjonalnie):</label>
							  <textarea class="form-control" rows="2"   id="comment"></textarea>
							</div> 
							
						</div>
						
							
							<div>
								<input type="submit" class="btn btn-success " value="Dodaj">
								
								
								<input type="reset" class="btn btn-danger" value="Anuluj"  data-toggle="modal" data-target="#myModal">
								
								
								<!-- The Modal -->
								<div class="modal fade" id="myModal">
								  <div class="modal-dialog">
									<div class="modal-content">

									  <!-- Modal Header -->
									  <div class="modal-header">
										<h4 class="modal-title">Anuluj dodawanie przychodu</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									  </div>

									  <!-- Modal body -->
									  <div class="modal-body">
										Wprowadzone dane zostaną utracone.<br>
										Czy jesteś pewien, że chcesz je usunąć?
									  </div>

									  <!-- Modal footer -->
									  <div class="modal-footer">
									  
										<button type="button" class="resetbtn btn-info btn-outline-danger" value="Usuń dane" data-dismiss="modal">Usuń dane</button>
										<button type="button" class="cancelbtn btn-info btn-outline-success" value="zostawDane" >Zostaw dane</button>
										
									  </div>

									</div>
								  </div>
								</div>
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
	

	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	
	<script src="budget.js" defer></script>

</body>
</html>