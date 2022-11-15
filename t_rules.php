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
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getTournamentRulesDetails($id);
	//print_r($play_tournaments);
}
if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
}else{
	header("location: t_schedule_details.php");
	exit;
}
$game_rules=$account->getGameRules();
//print_r($game_rules);
if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
	if($td_id!=""){
		$shuttles_used=isset($_POST['shuttles_used']) ? $_POST['shuttles_used'] : '';
		$company_name=isset($_POST['company_name']) ? $_POST['company_name'] : '';
		$is_umpire_decision_final=isset($_POST['is_umpire_decision_final']) ? $_POST['is_umpire_decision_final'] : 'no';
		$participation_certificate_for_all=isset($_POST['participation_certificate_for_all']) ? $_POST['participation_certificate_for_all'] : 'no';
		$free_food=isset($_POST['free_food']) ? $_POST['free_food'] : 'no';
		$topest_not_allowed_players=isset($_POST['topest_not_allowed_players']) ? $_POST['topest_not_allowed_players'] : '';
		$prior_reporting_min=isset($_POST['prior_reporting_min']) ? $_POST['prior_reporting_min'] : '';
		$result=$account->setTournamentRules($t_id,$shuttles_used,$company_name,$is_umpire_decision_final,$participation_certificate_for_all,$free_food,$topest_not_allowed_players,$prior_reporting_min,$td_id);  
	}
	if($result['t_id']!=""){
		$t_id=$result['t_id'];
		$_SESSION["td_id"] = $t_id;
		header("location: t_prizes.php?id=$t_id");
		exit;
	}else{
		$_SESSION["td_id"] = $result['td_id'];
		header("location: t_prizes.php");
		exit;
	}	
}
$user_details=$account->getUsers();
$category_types=$account->getTournamentCategoryTypes();
//print_r($category_types);
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
					<form method="post" action="t_rules.php" id="form1" enctype="multipart/form-data">
						<h3 class="deepa-6"><strong>Game Rules:</strong></h3>
						<hr>
							<?php $i=1;
							if(isset($_GET['id']) && !empty($play_tournaments)){ ?>
								<input type="hidden" class="form-control" name="t_id" value="<?php echo $id; ?>" />
								<div class="form-row text-info">
									<div class="col-md-12">1. 
										<span class="form-group">
											<label for="shuttles_used" class="d-inline">Shuttles Used: </label>
											<select id="shuttles_used" class="browser-default custom-select d-inline" name="shuttles_used" style="width:auto;display:inline!important">
											<option value="feather" <?php if($play_tournaments[0]['shuttles_used']=='feather') echo 'selected="selected"'; ?>><strong>Feather.</strong></option>
											<option value="plastic/nylon" <?php if($play_tournaments[0]['shuttles_used']=='plastic/nylon') echo 'selected="selected"'; ?> ><strong>Plastic / Nylon.</strong></option>
											<input type="text" id="company_name" class="form-control d-inline" name="company_name" placeholder="Company name" style="width:auto;display:inline!important" value="<?php echo $play_tournaments[0]['company_name']; ?>" >
											</select>
										</span>
									</div>
								</div>
								<div class="form-row text-info">
									<div class="col-md-12">
										<input type="checkbox" class="form-check-input" id="umpire_decision_final" value="yes" name="is_umpire_decision_final" <?php if($play_tournaments[0]['is_umpire_decision_final']=='yes') echo 'checked="checked"'; ?> >
										<label class="form-check-label" for="umpire_decision_final">Referees/ Umpire's decision will be Final</label>
									</div>
								</div>
									<div class="form-row text-info">
										<div class="col-md-12">
											<input type="checkbox" class="form-check-input" id="participation_certificate" value="yes" name="participation_certificate_for_all" <?php if($play_tournaments[0]['participation_certificate_for_all']=='yes') echo 'checked="checked"'; ?> >
											<label class="form-check-label" for="participation_certificate">Participation Certificate for all Players</label>
										</div>
									</div>
									<div class="form-row text-info">
										<div class="col-md-12">
											<input type="checkbox" class="form-check-input" id="free_food" value="yes" name="free_food" <?php if($play_tournaments[0]['free_food']=='yes') echo 'checked="checked"'; ?> ><label class="form-check-label" for="free_food">Food Will be Provided:</label>
										</div>
									</div>
									<div class="form-row text-info">
										<div class="col-md-12">
											Top <input id="id1" type="number" min="1" max="50" class="top-02" name="topest_not_allowed_players" value="<?php echo $play_tournaments[0]['topest_not_allowed_players']; ?>" >State or National Player are not allowed.
										</div>
									</div>
									<div class="form-row text-info">
										<div class="col-md-12">
											Players are requested to report <input id="id1" type="number" min="1" max="50" class="top-02" name="prior_reporting_min" value="<?php echo $play_tournaments[0]['prior_reporting_min']; ?>" > min prior to the reporting time.
										</div>
									</div>
							<?php }else{
								foreach($game_rules as $key=>$value){
									echo '<div class="form-row text-info"><div class="col-md-12">'.$i++.'. '.$value['rule'].'</div></div>';
								}
							}?>
							<hr>
						<div class="row">
							<div class="offset-md-10 col-md-2"><input type="submit" title="Prizes" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
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
