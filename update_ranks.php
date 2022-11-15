<?php
$config_path=$_SERVER['DOCUMENT_ROOT'];
include_once($config_path.'/msa/sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location:'. $config_path.'/msa/sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$firstname = auth::getCurrentUsername();
$id="";
$error="";
$tournaments=$account->getTournamentLists();

$users_list=[];
if(isset($_GET['t_id']) && isset($_GET['cat_id'])){
	$users_list=$account->getRegUsers($_GET['t_id'],$_GET['cat_id']);
}
$no_urs=count($users_list);

if (!empty($_POST)){
	$no_urs = isset($_POST['no_urs']) ? $_POST['no_urs'] : '';	

	for($i=1;$i<=$no_urs;$i++){
		$reg_id = isset($_POST['reg_id'.$i]) ? $_POST['reg_id'.$i] : '';	
		$rank = isset($_POST['rank'.$i]) ? $_POST['rank'.$i] : '';	
		$account->updateRank($reg_id,$rank);
	}
	header("Location: tournament_reg.php");
	exit; 

}


?>
<body>
    <header>
        <nav class="navbar navbar-expand-lg default-color fixed-top">
			<div class="container">
				<a class="navbar-brand" href="#">
                <h3 class="heads-1">PlayTournaments</h3>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                   <span class="navbar-toggle-icon"></span> 
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../sportsbook/index"><h4 class="h4-responsive">Go to MySportsArena</h4></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"></a>
                        </li>
                    </ul>
                </div>
			</div>
        </nav>
    </header>

    <!-------------------------------------Banner Section----------------------------------------------->
    <main id="main">
        <div class="container-fluid">
			<div class="row">
				<div class="col-md-2">
					<div class="nav nav-tabs flex-column nav-pills" id="about-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link black-text my-2" id="" href="index.php" aria-selected="false">Host Tournament</a>
						<a class="nav-link black-text my-2" id="" href="history.php" aria-selected="false">History</a>
						<a class="nav-link active black-text my-2" id="" href="tournament_reg.php" aria-selected="false">Registrations</a>
					</div>
				</div>
				<div class="col-md-10 ">
					<div class="table-responsive">
						<form method="post" action="update_ranks.php">
						<table class="table">
							<thead class="bg-info text-white">
								<tr>
									<th>#</th>
									<th>Player Name</th>
									<th>Player Email</th>
									<th>Rank</th>
								</tr>
							</thead>
							<tbody id="user_details">
								<?php $i=1;
								
									foreach($users_list as $key=>$val){
										
										echo '<tr>
											<td>'.$i.'</td>
											<td>'.$val['name'].'</td>
											<td>'.$val['email'].'</td>
											<td><input type="hidden" name="reg_id'.$i.'" value="'.$val['tr_id'].'"><input type="number" name="rank'.$i.'" value="'.$val['rank'].'"></td>
										</tr>';
										$i++;
									}
									
									
								?>
								
								
							</tbody>
							<tfoot>
								<tr class="text-center">
									<th colspan="4"><input type="hidden" name="no_urs" value="<?php echo $no_urs; ?>"><button type="submit" class="btn btn-sm bg-default text-white">Submit</button></th>
								</tr>
								
							</tfoot>
						</table>
						</form>
					</div>
				</div>
				
			</div>
        </div>
    </main>
    <!---------------------------------Footer Section----------------------------------------->
    <footer class="page-footer default-color text-white fixed-bottom text-center">
	
        <div class="footer-copyright text-center py-4">
			<a href="https://www.mysportsarena.com">MySportsArena</a> © <?php echo date('Y'); ?>
		</div>

    </footer>
</body>
</html>
<script type="text/javascript" src="https://mysportsarena.com/sportsbook/assets/js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://mysportsarena.com/sportsbook/assets/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://mysportsarena.com/sportsbook/assets/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://mysportsarena.com/sportsbook/assets/js/mdb.min.js"></script>
<script type="text/javascript" src = "https://mysportsarena.com/sportsbook/assets/js/jquery-ui.js"></script> 
<script type="text/javascript" src = "https://mysportsarena.com/sportsbook/assets/js/dropdown.js"></script> 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<script>
$(function(){
	 $(".date" ).datepicker({
        changeMonth:true,
        changeYear:true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1970:2019',
    });	
	
	$('#table1').DataTable();
	$("#table1_wrapper select").addClass("browser-default custom-select");
	$(".custom-select").css("width", "40%" );
	
});
</script>