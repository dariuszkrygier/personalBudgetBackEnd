<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<title>Wylogowanie</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Logout">
	<meta name="keywords" content="personalny, budżet, bilans, przychody, wydatki, saldo">
	<meta name="author" content="Dariusz Krygier">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
		<link rel="stylesheet" href="css/bootstrap.min.css">
	
	<link rel="stylesheet" href="style.css">
	
	 <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	<script src="https://kit.fontawesome.com/9855606672.js" crossorigin="anonymous"></script>
	
	<script
			  src="https://code.jquery.com/jquery-3.5.1.js"
			  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
			  crossorigin="anonymous"></script>
	



	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body class="d-flex flex-column min-vh-10">

	<header>
	
			
	
		<span class = "logo text-uppercase">
			
					<i class="fa fa-coins "></i> Budżet personalny
					
		</span>
	
			<h1 class="text-uppercase text-dark naglowek ml-0"> Wylogowanie </h1>
			
		<nav class="navbar navbar-dark bg-dark navbar-expand-lg justify-content-center text-light py-1">
			 
		
					
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="collapse navbar-collapse justify-content-center " id="mainmenu">
			
				<ul class="navbar-nav">
				
					<li class="nav-item px-3">
						<a class="nav-link" href="mainMenu.html"><i class="fas fa-home"></i> Start </a>
					</li>
					
					<li class="nav-item px-3 ">
						<a class="nav-link " href="addIncome.html"><i class="fas fa-hand-holding-usd"></i> Przychody </a>
					</li>
					
					<li class="nav-item px-3 ">
						<a class="nav-link" href="addExpense.html"><i class="fas fa-shopping-cart"></i> Wydatki </a>
					</li>
					
					<li class="nav-item px-3 ">
						<a class="nav-link" href="showBalance.html"><i class="fas fa-balance-scale-right"></i> Bilans </a>
					</li>
					
					<li class="nav-item px-3 ">
						<a class="nav-link" href="settings.html"><i class="fas fa-cogs"></i> Ustawienia </a>
					</li>
					
					<li class="nav-item px-3 active">
						<a class="nav-link" href="logout.html"><i class="fas fa-sign-out-alt"></i> Wyloguj </a>
					</li>
				
				</ul>
			
			</div>
		
		</nav>	
		

	</header>
	
	<main>
	
		
		
		<article>
		
		
			<div class="container">
				
			<div class="row settings" >
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#logoutModal">Wyloguj</button>
			</div>
			
			<!-- The Modal -->
<div class="modal" id="logoutModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Wylogowanie</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Czy jesteś pewien, że chcesz się wylogować?
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Pozostań zalogowany</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">Wyloguj</button>
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