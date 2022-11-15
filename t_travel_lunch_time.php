<?php
$config_path=$_SERVER['DOCUMENT_ROOT'];
include_once($config_path.'/msa/sportsbook/views/sub-views/pt_header.php'); 
//include_once('../sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location:'. $config_path.'/msa/sportsbook/index.php');
}

/*include_once('../sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location: ../../sportsbook/index.php');
}
*/

$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$firstname = auth::getCurrentUsername();
$result="";
if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
}else{
	header("location: t_schedule_details.php");
	exit;
}
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getTournamentLunchDetails($id);
	//print_r($play_tournaments);
}
$venues=$account->getVenueNos($td_id);
$no_venues=sizeof($venues);
if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
	if($td_id!=""){
		/* if($no_venues==1){
			$from_venues_id='';
			$to_venues_id='';
			$time='';
			$lunch_time_from=isset($_POST['lunch_time_from']) ? $_POST['lunch_time_from'] : '';
			$lunch_time_to=isset($_POST['lunch_time_to']) ? $_POST['lunch_time_to'] : '';
			$result=$account->setTravelLunchTime($from_venues_id,$to_venues_id,$time,$lunch_time_from,$lunch_time_to,$td_id);  
		}else if($no_venues==2){
			$from_venues_id=isset($_POST['from_venues_id']) ? $_POST['from_venues_id'] : '';
			$to_venues_id=isset($_POST['to_venues_id']) ? $_POST['to_venues_id'] : '';
			$time=isset($_POST['time']) ? $_POST['time'] : '';
			$lunch_time_from=isset($_POST['lunch_time_from']) ? $_POST['lunch_time_from'] : '';
			$lunch_time_to=isset($_POST['lunch_time_to']) ? $_POST['lunch_time_to'] : '';
			$result=$account->setTravelLunchTime($from_venues_id,$to_venues_id,$time,$lunch_time_from,$lunch_time_to,$td_id);  
		}else if($no_venues==3){
			$i=1;
			while($no_venues>=1){
				$from_venues_id=isset($_POST['from_venues_id'.$i.'']) ? $_POST['from_venues_id'.$i.''] : '';
				$to_venues_id=isset($_POST['to_venues_id'.$i.'']) ? $_POST['to_venues_id'.$i.''] : '';
				$time=isset($_POST['time'.$i.'']) ? $_POST['time'.$i.''] : '';
				$lunch_time_from=isset($_POST['lunch_time_from']) ? $_POST['lunch_time_from'] : '';
				$lunch_time_to=isset($_POST['lunch_time_to']) ? $_POST['lunch_time_to'] : '';
				$result=$account->setTravelLunchTime($from_venues_id,$to_venues_id,$time,$lunch_time_from,$lunch_time_to,$td_id); 
				$no_venues--;
				$i++;
			}
		} */
		$lunch_time_from=isset($_POST['lunch_time_from']) ? $_POST['lunch_time_from'] : '';
		$lunch_time_to=isset($_POST['lunch_time_to']) ? $_POST['lunch_time_to'] : '';
		$result=$account->setTravelLunchTime($t_id,$lunch_time_from,$lunch_time_to,$td_id);  
	}	
	if($result['t_id']!=""){
		$t_id=$result['t_id'];
		$_SESSION["td_id"] = $t_id;
		header("location: t_rules.php?id=$t_id");
		exit;
	}else{
		$_SESSION["td_id"] = $result['td_id'];
		header("location: t_rules.php");
		exit;
	}
}
$user_details=$account->getUsers();
$category_types=$account->getTournamentCategoryTypes();
//print_r($venues);
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
						<a class="nav-link active black-text my-2" id="" href="index.php" aria-selected="false">Registration</a>
						<a class="nav-link black-text my-2" id="" href="history.php" aria-selected="false">History</a>
					</div>
				</div>
				<div class="col-md-10 box-2">
					<?php if($result!=""){
							echo $result;
						} 
					?>
					<h3 class="text-center text-default"><strong>Tournament Registration Form</strong></h3>
					<hr />
					<form method="post" action="t_travel_lunch_time.php" id="form1" enctype="multipart/form-data">
						<?php if(isset($_GET['id']) && !empty($play_tournaments)){ ?>
							<input type="hidden" class="form-control" name="t_id" value="<?php echo $id; ?>" />
						<?php } ?>
						<!--<?php //if(sizeof($venues)>1){?>
							<h5 class="deepa-6" style="color: #4caf50"><strong>Travel Time:</strong></h5>
							<hr>
							<div class="form-row">
								<?php/*  $i=1;$j=2;
								if($no_venues==2){
									echo '<div class="form-group col-sm-4"><label>Venue 01 to Venue 02:</label><input type="hidden" name="from_venues_id" value="'.$venues[0]['id'].'"><input type="hidden" name="to_venues_id" value="'.$venues[1]['id'].'"><input type="time" name="time" class="form-control" id="timepicker1" value=""></div>';
								}else if($no_venues==3){
									echo '<div class="form-group col-sm-4"><label>Venue 01 to Venue 02:</label><input type="hidden" name="from_venues_id1" value="'.$venues[0]['id'].'"><input type="hidden" name="to_venues_id1" value="'.$venues[1]['id'].'"><input type="time" name="time1" class="form-control" id="timepicker1" value=""></div><div class="form-group col-sm-4"><label>Venue 02 to Venue 03:</label><input type="hidden" name="from_venues_id2" value="'.$venues[1]['id'].'"><input type="hidden" name="to_venues_id2" value="'.$venues[2]['id'].'"><input type="time" name="time2"  class="form-control" id="timepicker1" value=""></div><div class="form-group col-sm-4">
									<label>Venue 03 to Venue 01:</label><input type="hidden" name="from_venues_id3" value="'.$venues[2]['id'].'"><input type="hidden" name="to_venues_id3" value="'.$venues[0]['id'].'"><input type="time" name="time3"  class="form-control" id="timepicker1" value=""></div>';
								}	 */								
								?>
							</div>
						<?php //} ?>-->
						<hr>
						<h5 class="deepa-6" style="color: #4caf50"><strong>Lunch Time:</strong></h5>
						<hr>
						<div class="form-row ">
							<div class="form-group col-sm-6">
								<label>From:</label>
								<?php if(isset($_GET['id']) && !empty($play_tournaments)){
									echo '<input type="time" name="lunch_time_from"  class="form-control" id="timepicker1" value="'.$play_tournaments[0]['lunch_time_from'].'">';
								}else{
									echo '<input type="time" name="lunch_time_from"  class="form-control" id="timepicker1" value="">';
								} ?>
							</div>
							<div class="form-group col-sm-6">
								<label>To:</label>
								<?php if(isset($_GET['id']) && !empty($play_tournaments)){
									echo '<input type="time" name="lunch_time_to"  class="form-control" id="timepicker1" value="'.$play_tournaments[0]['lunch_time_to'].'">';
								}else{
									echo '<input type="time" name="lunch_time_to"  class="form-control" id="timepicker1" value="">';
								} ?>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="offset-md-10 col-md-2"><input type="submit" title="Game rules" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
						</div>
					</form>
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