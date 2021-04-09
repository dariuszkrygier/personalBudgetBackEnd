<?php

	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header ('Location: index.php');
		exit();
	}
	
	if(isset($_SESSION['formPeriodOfTime']))
	{
		$allGood = true;
		$periodOfTime=$_SESSION['formPeriodOfTime'];
		$now = date('Y-m-d');
		
		if($periodOfTime == "currentMonth")
		{
			$startDate = date('Y-m-d',strtotime("first day of this month"));
			$endDate = date('Y-m-d',strtotime("now"));
		}
		else if($periodOfTime == "previousMonth")
		{
			$startDate = date('Y-m-d',strtotime("first day of previous month"));
			$endDate = date('Y-m-d',strtotime("last day of previous month"));
		}
		else if($periodOfTime == "currentYear")
		{
			$startDate = date('Y-m-d',strtotime("1 January this year"));
			$endDate = date('Y-m-d',strtotime("now"));
		}
		else if($periodOfTime == "selectedPeriod")
		{
			$startDate = $_SESSION['periodStartDate'];
			$endDate = $_SESSION['periodEndDate'];	
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
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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

<body class="d-flex flex-column min-vh-10" onload="createPieChart()">

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
				
					<div class="col-md-6 align-self-start">	
					
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
				$sql ="SELECT c.name, SUM(i.amount) FROM users u INNER JOIN incomes i ON u.id = i.user_id INNER JOIN incomes_category_assigned_to_users c ON i.income_category_assigned_to_user_id = c.id WHERE u.id = $userId AND i.date_of_income >= '$startDate' AND  i.date_of_income <= '$endDate' GROUP BY c.id";
			
				$resultOfQuery=$connection->query($sql);
			
				if(!$resultOfQuery) throw new Exception($connection->error);
				
				$howCategory=$resultOfQuery->num_rows;
			
				if($howCategory>0)
				{
						echo '<article>';
							echo '<h3 class="w3-panel w3-green">Zestawienie przychodów dla poszczególnych kategorii w okresie od '.$startDate.' do '.$endDate.'</h3>';
										
							echo '<div class="table-responsive text-left">';          
								echo '<div class="table-responsive">';         
									echo '<table class="table table-striped table-bordered table-condensed w3-panel w3-green">'; 
										echo '<thead>'; 
											 echo '<tr>'; 
												echo '<th>Nazwa kategorii</th>'; 
												echo '<th>Suma przychodów [zł]</th>'; 
											echo '</tr>'; 
										echo '</thead>'; 
										echo '<tbody>'; 
											while ($row = $resultOfQuery->fetch_assoc())
											{
												echo '<tr>'; 
												echo '<td>'.$row['name'].'</td>'; 
												echo '<td>'.$row['SUM(i.amount)'].'</td>'; 
												echo '</tr>'; 
											} 
											$resultOfQuery->free_result();
										echo '</tbody>'; 
									echo '</table>'; 
								echo '</div>'; 
							echo '</div>'; 							
						echo '</article>'; 	
				}
				else
				{
					echo '<h4 class="bilansHeader">Brak przychodów w okresie od '.$startDate.' do '.$endDate.'</h4>';
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
					</div>
					
					<div class="col-md-6 ">	
					
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
				$sql ="SELECT c.name, SUM(e.amount) FROM users u INNER JOIN expenses e ON u.id = e.user_id INNER JOIN expenses_category_assigned_to_users c ON e.expense_category_assigned_to_user_id = c.id WHERE u.id = $userId AND e.date_of_expense >= '$startDate' AND  e.date_of_expense <= '$endDate' GROUP BY c.id";
			
				$resultOfQuery=$connection->query($sql);
			
				if(!$resultOfQuery) throw new Exception($connection->error);
				
				$howCategory=$resultOfQuery->num_rows;
			
				if($howCategory>0)
				{
					$noExpenses = false;
						echo '<article>';
							echo '<h3 class="w3-panel w3-yellow">Zestawienie wydatków dla poszczególnych kategorii w okresie od '.$startDate.' do '.$endDate.'</h3>';
										
							echo '<div class="table-responsive text-left text-light">';          
								echo '<div class="table-responsive" >';         
									echo '<table class="table table-striped table-bordered table-condensed w3-panel w3-yellow" id="tableExpenses">'; 
										echo '<thead>'; 
											 echo '<tr>'; 
												echo '<th>Nazwa kategorii</th>'; 
												echo '<th>Suma wydatków [zł]</th>'; 
											echo '</tr>'; 
										echo '</thead>'; 
										echo '<tbody>';
										$i = 0;								
											while ($row = $resultOfQuery->fetch_assoc())
											{
												echo '<tr>'; 
												echo '<td>'.$row['name'].'</td>';
												$dataPoints[$i]["label"]= $row['name'];
												echo '<td>'.$row['SUM(e.amount)'].'</td>';
												$dataPoints[$i]["y"]= $row['SUM(e.amount)'];
												echo '</tr>'; 
												$i=$i+1;
											} 
											$resultOfQuery->free_result();
										echo '</tbody>'; 
									echo '</table>'; 
								echo '</div>'; 
							echo '</div>'; 							
						echo '</article>'; 	
				}
				else
				{
					echo '<h4 class="bilansHeader">Brak wydatków w okresie od '.$startDate.' do '.$endDate.'</h4>';
					$noExpenses = true;
					
				
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
					</div>
					</div>
					
								<div class="row" id="logowanie">
					<div class="col-md-6  ">
							
								<script>
function createPieChart () 
{
	var chart = new CanvasJS.Chart("chartContainer", {
				exportEnabled: true,
				animationEnabled: true,
				title:{
					text: "Zestawienie wydatków w danym okresie."
				},
				legend:{
					cursor: "pointer",
					itemclick: explodePie
				},
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} (#percent%)",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			
	chart.render();
	chart.title.set("fontSize", 24);
	chart.title.set("fontColor", "#092834", false);
	chart.legend.set("fontSize", 16);
}

function explodePie (e) 
{
			if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
				e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
			} else {
				e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
			}
			e.chart.render();

}
	</script>	
							
<?php		
						if ($noExpenses == false)
						echo '<div id="chartContainer"></div>';
?>
							</div>
							</div>
							
									<div class="row w3-panel w3-green justify-content-center text-light" >
						
							<div class="col-md-3 text-light">Suma przychodów [zł]:</div>
							
							
								
								
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
				//SUM incomes
				$userId = $_SESSION['id'];
				$sql ="SELECT SUM(i.amount) FROM users u INNER JOIN incomes i ON u.id = i.user_id WHERE u.id = $userId AND i.date_of_income >= '$startDate' AND  i.date_of_income <= '$endDate'";
			
				$resultOfQuery=$connection->query($sql);
			
				if(!$resultOfQuery) throw new Exception($connection->error);
				
				$howRecords=$resultOfQuery->num_rows;
			
				if($howRecords>0)
				{
													
					while ($row = $resultOfQuery->fetch_assoc())
					{
						echo $row['SUM(i.amount)'];	
						$sumIncomes = $row['SUM(i.amount)'];
					} 
					
					$resultOfQuery->free_result();		
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
										
								 </div>
							
							
							
						
						
					
					
					<div class="row w3-panel w3-yellow justify-content-center" >
						
							<div class="col-md-3">Suma wydatków [zł]:</div>
							
							
								
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
				//Sum expenses
				$userId = $_SESSION['id'];
				$sql ="SELECT SUM(e.amount) FROM users u INNER JOIN expenses e ON u.id = e.user_id WHERE u.id = $userId AND e.date_of_expense >= '$startDate' AND  e.date_of_expense <= '$endDate'";
			
				$resultOfQuery=$connection->query($sql);
			
				if(!$resultOfQuery) throw new Exception($connection->error);
				
				$howRecords=$resultOfQuery->num_rows;
			
				if($howRecords>0)
				{
													
					while ($row = $resultOfQuery->fetch_assoc())
					{
						echo $row['SUM(e.amount)'];
						$sumExpenses = $row['SUM(e.amount)'];
						
					} 
					$resultOfQuery->free_result();		
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
								
								
							</div>	
							
									<div class="row justify-content-center my-2" >
					
							<div class="col-md-3 my-2 text w3-panel w3-blue-grey">Różnica:</div>
							
							
								<div class="text-light w3-panel w3-blue-grey my-2">
									<div id="differenceNumber">
									<?php
									$difference = $sumIncomes - $sumExpenses;
									echo number_format($difference,2,'.', '');
									?>
									</div>
								</div>
							
							
							
								 
							
						</div>
				
						
				
					
					<div class="row" id="logowanie">
						<div class="justify-content-center text-light">
							
								<div class="justify-content-center text-light text-center w3-panel w3-blue" id="differenceText"></div>
								<button class="btn btn-info" onclick="displayText()">Sprawdź czy dobrze zarządzasz finasami?</button>
								<script src="js/functionDisplayText.js"></script>
							
							
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
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	
	<script src="js/bootstrap.min.js"></script>
	<script src="budget.js"></script>

</body>
</html>