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
						<a class="nav-link" href="mainMenu.html"><i class="fas fa-home"></i> Start </a>
					</li>
					
					<li class="nav-item px-3 ">
						<a class="nav-link " href="addIncome.html"><i class="fas fa-hand-holding-usd"></i> Przychody </a>
					</li>
					
					<li class="nav-item px-3 ">
						<a class="nav-link" href="addExpense.html"><i class="fas fa-shopping-cart"></i> Wydatki </a>
					</li>
					
					<li class="nav-item px-3 active">
						<a class="nav-link" href="showBalance.html"><i class="fas fa-balance-scale-right"></i> Bilans </a>
					</li>
					
					<li class="nav-item px-3">
						<a class="nav-link" href="settings.html"><i class="fas fa-cogs"></i> Ustawienia </a>
					</li>
					
					<li class="nav-item px-3">
						<a class="nav-link" href="logout.html"><i class="fas fa-sign-out-alt"></i> Wyloguj </a>
					</li>
				
				</ul>
			
			</div>
		
		</nav>	
		

	</header>
	
	<main>
	
		
		
		<article>
		
		
			<div class="container">
				
				<div class="row" id="logowanie">
				
				
				
					<div class="dropdown" >
					  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Wybierz datę:
					  </button>
					  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
						<button class="dropdown-item" type="button" id="thisMonth">Bieżący miesiąc</button>
						<button class="dropdown-item" type="button" id="previousMonth">Poprzedni miesiąc</button>
						<button class="dropdown-item" type="button" id="thisYear">Bieżący rok</button>
						<button class="dropdown-item" type="button" id="selectDateRange" data-toggle="modal" data-target="#dateRange">Przedział czasowy</button>
					  </div>
					</div>
					
				</div>				
					
										<!-- Modal -->
					<div class="modal fade" id="dateRange" tabindex="-1" role="dialog" aria-labelledby="dateRange" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Wybierz przedział czasowy:</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  
						  <div class="modal-body">
							
							<div class="container">
									
									<div class="row" id="logowanie">
							
										<form action="" class="main-form" novalidate style="width:350px; margin-auto">	
														
											
											<div class="form-group">	
												<div class="input-group">
													<div class="input-group-prepend">
														<i class="fas fa-calendar-week"></i> 
													</div>
													<input type="date" name="date" id="dateFrom" class="form-control" required>
													<div class="invalid-feedback">Podaj datę!</div>
													<script type="text/javascript" src="budget.js"></script>
												</div>
											</div>
											
											<div class="form-group">	
												<div class="input-group">
													<div class="input-group-prepend">
														<i class="fas fa-calendar-week"></i> 
													</div>
													<input type="date" name="date" id="dateTill" class="form-control" required>
													<div class="invalid-feedback">Podaj datę!</div>
													<script type="text/javascript" src="budget.js"></script>
												</div>
											</div>
										</form>
									</div>
							</div>
											
							
										  </div>
											<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
													<button type="button" class="btn btn-success" data-dismiss="modal">Wybierz</button>
												</div>
						</div>
						</div>
					</div>
					
				
				
				<div class="row align-self-center my-1" id="showBalanceChosenDate">
				
					<div class="col-lg-6 align-content-center align-items-center justify-content-*-center">
				
					
						<h2 class="justify-content-center h4 text-light"> Wybrany przedział czasowy: </h2>
					
						<h2 class="justify-content-center h5 text-light" id="show"> <output id="wynik1"> </output>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<output id="wynik2"> </output> </h2>
					
					
					
					</div>
				</div>
				
			<div class="row">
			
				<div class="col-lg-6">
					<h2 class="sub-header text-light">Przychody</h2>
					<div class="table-responsive">
								<table class="table table-striped table-dark table-bordered table-hover">
								  <thead class="thead-light">
									<tr>
									  <th class="col-md-1">#</th>
									  <th class="col-md-2">Header</th>
									  <th class="col-md-3">Header</th>
									</tr>
								  </thead>
								  <tbody>
									<tr>
									  <td class="col-md-1">1,001</td>
									  <td class="col-md-2">1,001</td>
									  <td class="col-md-3">1,001 <i class="fas fa-edit"></i> <i class="fas fa-trash"></i></td>
									</tr>
									<tr>
									  <td class="col-md-1">1,001</td>
									  <td class="col-md-2">1,001</td>
									  <td class="col-md-3">1,001 <i class="fas fa-edit"></i> <i class="fas fa-trash"></i> </td>
									</tr>
									 <tr>
									  <td class="col-md-1">1,001</td>
									  <td class="col-md-2">1,001</td>
									  <td class="col-md-3">1,001 <i class="fas fa-edit"></i> <i class="fas fa-trash"></i> </td>
									</tr>
								  </tbody>
								</table>
					</div>
				</div>
					<div class="col-lg-6">
							  <h2 class="sub-header text-light">Wydatki</h2>
						<div class="table-responsive">
								<table class="table table-striped table-dark table-bordered table-hover">
								  <thead class="thead-light">
									<tr>
									  <th class="col-md-1">#</th>
									  <th class="col-md-2">Header</th>
									  <th class="col-md-3">Header</th>
									</tr>
								  </thead>
								  <tbody>
									<tr>
									  <td class="col-md-1">1,001 </td>
									  <td class="col-md-2">1,001</td>
									  <td class="col-md-3">1,001 <i class="fas fa-edit"></i> <i class="fas fa-trash"></i></td>
									</tr>
									<tr>
									  <td class="col-md-1">1,001</td>
									  <td class="col-md-2">1,001</td>
									  <td class="col-md-3">1,001 <i class="fas fa-edit"></i> <i class="fas fa-trash"></i></td>
									</tr>
									 <tr>
									  <td class="col-md-1">1,001</td>
									  <td class="col-md-2">1,001</td>
									  <td class="col-md-3">1,001 <i class="fas fa-edit"></i> <i class="fas fa-trash"></i></td>
									</tr>
								  </tbody>
								</table>
						</div>
					</div>
					
					


			</div>
			
			<div class="row">
			
				<div class="col-lg-12">
					<h2 class="sub-header text-light">Bilans</h2>
					<div class="table-responsive">
								<table class="table table-striped table-dark table-bordered" id="tableShowBalance">
								 
								  <tbody>
									<tr >
									  <td class="col-lg-12">Twój bilans: </td>
									
									</tr>
									<tr>
										<td class="col-lg-12">Gratulacje</td>
									</tr>
									
								  </tbody>
								</table>
					</div>
				</div>
				
			</div>
			<div class="row">
			<div class="col-lg-12 pie">
				<canvas id="cvs" width="350" height="250" >
					[No canvas support]
				</canvas>
			</div>
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