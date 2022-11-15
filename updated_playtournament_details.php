<?php 
	include_once('../sportsbook/helpers/init.php'); 
	include_once('../sportsbook/views/sub-views/header.php'); 
	$result="";
	$account=new account($dbo);
	if(isset($_GET['t_id'])){
		$id1=$_GET['t_id'];
		$id=str_replace("'", "", $id1);
		$result=$account->getRegisteredPlayTournaments($id);
	}
	//print_r($result);
?>

<body>
	<header>
		<nav class="navbar navbar-expand-lg scrolling-navbar default-color fixed-top">
			<div class="container">
				<a class="navbar-brand" href="http://localhost/sportsbook/index.php"><h2><strong>MySportsArena</strong></h2></a>
			</div>
		</nav>
	</header>
	<main class="gradient mt-5">
		<div class="container-fluid main">
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<div class="table-responsive">
						<table class="table mt-3">
							<thead>
								<tr>
									<th colspan="2" class="text-center bg-info text-white"><h3 class="h3-responsive">Tournament Details</h3></th>
								</tr>
							</thead>
							<tbody class="text-center">
								<tr>
									<td><h5 class="h5-responsive">Sports Type</h5></td>
									<td><h6 class="h6-responsive"><?php echo ucfirst($result[0]['sports_name']); ?></h6></td>
								</tr>
								<tr>
									<td><h5 class="h5-responsive">Tournament Name</h5></td>
									<td><h6 class="h6-responsive"><?php echo ucfirst($result[0]['tournament_name']); ?></h6></td>
								</tr>
								<tr>
									<td><h5 class="h5-responsive">Management Name</h5></td>
									<td><h6 class="h6-responsive"><?php echo ucfirst($result[0]['management_name']); ?></h6></td>
								</tr>
								<tr>
									<td><h5 class="h5-responsive">Tournament start date</h5></td>
									<td><h6 class="h6-responsive"><?php echo ucfirst($result[0]['t_start_date']); ?></h6></td>
								</tr>
								<tr>
									<td><h5 class="h5-responsive">Tournament end date</h5></td>
									<td><h6 class="h6-responsive"><?php echo ucfirst($result[0]['t_end_date']); ?></h6></td>
								</tr>
								<tr>
									<td><h5 class="h5-responsive">Tournament Entry start date</h5></td>
									<td><h6 class="h6-responsive"><?php echo ucfirst($result[0]['entry_start_date']); ?></h6></td>
								</tr>
								<tr>
									<td><h5 class="h5-responsive">Tournament Entry end date</h5></td>
									<td><h6 class="h6-responsive"><?php echo ucfirst($result[0]['entry_end_date']); ?></h6></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 offset-md-2 text-center">
				<?php if(isset($_GET['t_id'])){ 
					echo '<a href="http://localhost/sportsbook/index" class="bg-default text-white px-3 py-2">For more information click here</a>';
				}else{
					echo '<a href="http://localhost/sportsbook/views/notifications" class="bg-default text-white px-3 py-2">Back</a>';
				} ?>
				</div>
			</div>
		</div>
	</main>
	<footer class="footer bg-ifo text-white">
		<div class="container">
			<div id="footer-copyright" class="p-4">MySportsArena © 2019</div>
		</div>
	</footer>
</body>

<?php include_once('../sportsbook/views/sub-views/footer.php'); ?>
