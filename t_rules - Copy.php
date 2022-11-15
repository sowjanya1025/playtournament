<?php
include_once('../sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location: ../../sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$firstname = auth::getCurrentUsername();
$result="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getRegisteredPlayTournaments($id);
	//print_r($play_tournaments);
}
if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
	$sports_type=isset($_POST['sports_type']) ? $_POST['sports_type'] : '';
	$tournament_name=isset($_POST['tournament_name']) ? $_POST['tournament_name'] : '';
	$management_name=isset($_POST['management_name']) ? $_POST['management_name'] : '';
	$t_start_date=isset($_POST['t_start_date']) ? $_POST['t_start_date'] : '';
	$t_end_date=isset($_POST['t_end_date']) ? $_POST['t_end_date'] : '';
	$entry_start_date=isset($_POST['entry_start_date']) ? $_POST['entry_start_date'] : '';
	$entry_end_date=isset($_POST['entry_end_date']) ? $_POST['entry_end_date'] : '';
	$is_withdrawable=isset($_POST['is_withdrawable']) ? $_POST['is_withdrawable'] : '';
	$withdraw_reason=isset($_POST['withdraw_reason']) ? $_POST['withdraw_reason'] : '';
	$venue1=isset($_POST['venue1']) ? $_POST['venue1'] : '';
	$country1=isset($_POST['country1']) ? $_POST['country1'] : '';
	$state1=isset($_POST['state1']) ? $_POST['state1'] : '';
	$city1=isset($_POST['city1']) ? $_POST['city1'] : '';
	$no_courts1=isset($_POST['no_courts1']) ? $_POST['no_courts1'] : '';
	$start_date1=isset($_POST['start_date1']) ? $_POST['start_date1'] : '';
	$end_date1=isset($_POST['end_date1']) ? $_POST['end_date1'] : '';
	$start_time1=isset($_POST['start_time1']) ? $_POST['start_time1'] : '';
	$end_time1=isset($_POST['end_time1']) ? $_POST['end_time1'] : '';
	$venue2=isset($_POST['venue2']) ? $_POST['venue2'] : '';
	$country2=isset($_POST['country2']) ? $_POST['country2'] : '';
	$state2=isset($_POST['state2']) ? $_POST['state2'] : '';
	$city2=isset($_POST['city2']) ? $_POST['city2'] : '';
	$no_courts2=isset($_POST['no_courts2']) ? $_POST['no_courts2'] : '';
	$start_date2=isset($_POST['start_date2']) ? $_POST['start_date2'] : '';
	$end_date2=isset($_POST['end_date2']) ? $_POST['end_date2'] : '';
	$start_time2=isset($_POST['start_time2']) ? $_POST['start_time2'] : '';
	$end_time2=isset($_POST['end_time2']) ? $_POST['end_time2'] : '';
	$venue3=isset($_POST['venue3']) ? $_POST['venue3'] : '';
	$country3=isset($_POST['country3']) ? $_POST['country3'] : '';
	$state3=isset($_POST['state3']) ? $_POST['state3'] : '';
	$city3=isset($_POST['city3']) ? $_POST['city3'] : '';
	$no_courts3=isset($_POST['no_courts3']) ? $_POST['no_courts3'] : '';
	$start_date3=isset($_POST['start_date3']) ? $_POST['start_date3'] : '';
	$end_date3=isset($_POST['end_date3']) ? $_POST['end_date3'] : '';
	$start_time3=isset($_POST['start_time3']) ? $_POST['start_time3'] : '';
	$end_time3=isset($_POST['end_time3']) ? $_POST['end_time3'] : '';
	$v1_to_v2=isset($_POST['v1_to_v2']) ? $_POST['v1_to_v2'] : '';
	$v2_to_v3=isset($_POST['v2_to_v3']) ? $_POST['v2_to_v3'] : '';
	$v3_to_v1=isset($_POST['v3_to_v1']) ? $_POST['v3_to_v1'] : '';
	$lunch_time_from=isset($_POST['lunch_time_from']) ? $_POST['lunch_time_from'] : '';
	$lunch_time_to=isset($_POST['lunch_time_to']) ? $_POST['lunch_time_to'] : '';
	$contact_no1=isset($_POST['contact_no1']) ? $_POST['contact_no1'] : '';
	$contact_no2=isset($_POST['contact_no2']) ? $_POST['contact_no2'] : '';
	$contact_no3=isset($_POST['contact_no3']) ? $_POST['contact_no3'] : '';
	$email_id=isset($_POST['email_id']) ? $_POST['email_id'] : '';
	$whatsapp_no=isset($_POST['whatsapp_no']) ? $_POST['whatsapp_no'] : '';
	$leagues_no_sets=isset($_POST['leagues_no_sets']) ? $_POST['leagues_no_sets'] : '';
	$leagues_points=isset($_POST['leagues_points']) ? $_POST['leagues_points'] : '';
	$quarter_finals_no_sets=isset($_POST['quarter_finals_no_sets']) ? $_POST['quarter_finals_no_sets'] : '';
	$quarter_finals_points=isset($_POST['quarter_finals_points']) ? $_POST['quarter_finals_points'] : '';
	$semifinals_no_sets=isset($_POST['semifinals_no_sets']) ? $_POST['semifinals_no_sets'] : '';
	$semifinals_points=isset($_POST['semifinals_points']) ? $_POST['semifinals_points'] : '';
	$finals_no_sets=isset($_POST['finals_no_sets']) ? $_POST['finals_no_sets'] : '';
	$finals_points=isset($_POST['finals_points']) ? $_POST['finals_points'] : '';
	$no_groups=isset($_POST['no_groups']) ? $_POST['no_groups'] : '';
	$no_players_in_groups=isset($_POST['no_players_in_groups']) ? $_POST['no_players_in_groups'] : '';
	$shuttles_used=isset($_POST['shuttles_used']) ? $_POST['shuttles_used'] : '';
	$is_umpire_decision_final=isset($_POST['is_umpire_decision_final']) ? $_POST['is_umpire_decision_final'] : 'no';
	$participation_certificate_for_all=isset($_POST['participation_certificate_for_all']) ? $_POST['participation_certificate_for_all'] : 'no';
	$free_food=isset($_POST['free_food']) ? $_POST['free_food'] : 'no';
	$topest_not_allowed_players=isset($_POST['topest_not_allowed_players']) ? $_POST['topest_not_allowed_players'] : '';
	$prior_reporting_min=isset($_POST['prior_reporting_min']) ? $_POST['prior_reporting_min'] : '';
	$winner_trophy=isset($_POST['winner_trophy']) ? $_POST['winner_trophy'] : 'no';
	$runner_trophy=isset($_POST['runner_trophy']) ? $_POST['runner_trophy'] : 'no';
	$semifinalist_trophy=isset($_POST['semifinalist_trophy']) ? $_POST['semifinalist_trophy'] : 'no';
	$winner_medal=isset($_POST['winner_medal']) ? $_POST['winner_medal'] : 'no';
	$runner_medal=isset($_POST['runner_medal']) ? $_POST['runner_medal'] : 'no';
	$semifinalist_medal=isset($_POST['semifinalist_medal']) ? $_POST['semifinalist_medal'] : 'no';
	$winner_goodies=isset($_POST['winner_goodies']) ? $_POST['winner_goodies'] : 'no';
	$w_goodie_name=isset($_POST['w_goodie_name']) ? $_POST['w_goodie_name'] : '';
	$runner_goodies=isset($_POST['runner_goodies']) ? $_POST['runner_goodies'] : 'no';
	$r_goodie_name=isset($_POST['r_goodie_name']) ? $_POST['r_goodie_name'] : '';
	$semifinalist_goodies=isset($_POST['semifinalist_goodies']) ? $_POST['semifinalist_goodies'] : 'no';
	$s_goodie_name=isset($_POST['s_goodie_name']) ? $_POST['s_goodie_name'] : '';
	$winner_cash_prize=isset($_POST['winner_cash_prize']) ? $_POST['winner_cash_prize'] : 'no';
	$w_cash_amount=isset($_POST['w_cash_amount']) ? $_POST['w_cash_amount'] : '';
	$runner_cash_prize=isset($_POST['runner_cash_prize']) ? $_POST['runner_cash_prize'] : 'no';
	$r_cash_amount=isset($_POST['r_cash_amount']) ? $_POST['r_cash_amount'] : '';
	$semifinalist_cash_prize=isset($_POST['semifinalist_cash_prize']) ? $_POST['semifinalist_cash_prize'] : 'no';
	$s_cash_amount=isset($_POST['s_cash_amount']) ? $_POST['s_cash_amount'] : '';
	$other_details=isset($_POST['other_details']) ? $_POST['other_details'] : '';
	$image=isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
	//echo $image=isset($_POST['image']) ? $_POST['image'] : '';
	$gd_reporting_time=isset($_POST['gd_reporting_time']) ? $_POST['gd_reporting_time'] : '';
	$gd_min_no_entries=isset($_POST['gd_min_no_entries']) ? $_POST['gd_min_no_entries'] : '';
	$gd_fee=isset($_POST['gd_fee']) ? $_POST['gd_fee'] : '';
	$gd_venue=isset($_POST['gd_venue']) ? $_POST['gd_venue'] : '';
	$gd_categories=isset($_POST['gd_categories']) ? $_POST['gd_categories'] : '';
	$bd_reporting_time=isset($_POST['bd_reporting_time']) ? $_POST['bd_reporting_time'] : '';
	$bd_min_no_entries=isset($_POST['bd_min_no_entries']) ? $_POST['bd_min_no_entries'] : '';
	$bd_fee=isset($_POST['bd_fee']) ? $_POST['bd_fee'] : '';
	$bd_venue=isset($_POST['bd_venue']) ? $_POST['bd_venue'] : '';
	$bd_categories=isset($_POST['bd_categories']) ? $_POST['bd_categories'] : '';
	$bu_reporting_time=isset($_POST['bu_reporting_time']) ? $_POST['bu_reporting_time'] : '';
	$bu_min_no_entries=isset($_POST['bu_min_no_entries']) ? $_POST['bu_min_no_entries'] : '';
	$bu_fee=isset($_POST['bu_fee']) ? $_POST['bu_fee'] : '';
	$bu_venue=isset($_POST['bu_venue']) ? $_POST['bu_venue'] : '';
	$bu_categories=isset($_POST['bu_categories']) ? $_POST['bu_categories'] : '';
	$gu_reporting_time=isset($_POST['gu_reporting_time']) ? $_POST['gu_reporting_time'] : '';
	$gu_min_no_entries=isset($_POST['gu_min_no_entries']) ? $_POST['gu_min_no_entries'] : '';
	$gu_fee=isset($_POST['gu_fee']) ? $_POST['gu_fee'] : '';
	$gu_venue=isset($_POST['gu_venue']) ? $_POST['gu_venue'] : '';
	$gu_categories=isset($_POST['gu_categories']) ? $_POST['gu_categories'] : '';
	$ams_reporting_time=isset($_POST['ams_reporting_time']) ? $_POST['ams_reporting_time'] : '';
	$ams_min_no_entries=isset($_POST['ams_min_no_entries']) ? $_POST['ams_min_no_entries'] : '';
	$ams_fee=isset($_POST['ams_fee']) ? $_POST['ams_fee'] : '';
	$ams_venue=isset($_POST['ams_venue']) ? $_POST['ams_venue'] : '';
	$ams_categories=isset($_POST['ams_categories']) ? $_POST['ams_categories'] : '';
	$afs_reporting_time=isset($_POST['afs_reporting_time']) ? $_POST['afs_reporting_time'] : '';
	$afs_min_no_entries=isset($_POST['afs_min_no_entries']) ? $_POST['afs_min_no_entries'] : '';
	$afs_fee=isset($_POST['afs_fee']) ? $_POST['afs_fee'] : '';
	$afs_venue=isset($_POST['afs_venue']) ? $_POST['afs_venue'] : '';
	$afs_categories=isset($_POST['afs_categories']) ? $_POST['afs_categories'] : '';
	$ms_reporting_time=isset($_POST['ms_reporting_time']) ? $_POST['ms_reporting_time'] : '';
	$ms_min_no_entries=isset($_POST['ms_min_no_entries']) ? $_POST['ms_min_no_entries'] : '';
	$ms_fee=isset($_POST['ms_fee']) ? $_POST['ms_fee'] : '';
	$ms_venue=isset($_POST['ms_venue']) ? $_POST['ms_venue'] : '';
	$ms_categories=isset($_POST['ms_categories']) ? $_POST['ms_categories'] : '';
	$md_reporting_time=isset($_POST['md_reporting_time']) ? $_POST['md_reporting_time'] : '';
	$md_min_no_entries=isset($_POST['md_min_no_entries']) ? $_POST['md_min_no_entries'] : '';
	$md_fee=isset($_POST['md_fee']) ? $_POST['md_fee'] : '';
	$md_venue=isset($_POST['md_venue']) ? $_POST['md_venue'] : '';
	$md_categories=isset($_POST['md_categories']) ? $_POST['md_categories'] : '';
	$newfilename="";
	if($image!=""){
		$allowedExts = array("jpg", "jpeg", "png");
		$extension = pathinfo($image, PATHINFO_EXTENSION);
		if(in_array($extension, $allowedExts)){
			$temp = explode(".", $image);
			$newfilename = 'U'.$accountId.'Tournament'.rand().'.'.end($temp);
			move_uploaded_file($_FILES["image"]["tmp_name"],"images/" . $newfilename);
		}
	}
	if($tournament_name!=""){
		$result=$account->setTournamentDetails($t_id,$sports_type,$tournament_name,$management_name,$t_start_date,$t_end_date,$entry_start_date,$entry_end_date,$is_withdrawable,$withdraw_reason,$venue1,$country1,$state1,$city1,$no_courts1,$start_date1,$end_date1,$start_time1,$end_time1,$venue2,$country2,$state2,$city2,$no_courts2,$start_date2,$end_date2,$start_time2,$end_time2,$venue3,$country3,$state3,$city3,$no_courts3,$start_date3,$end_date3,$start_time3,$end_time3,$v1_to_v2,$v2_to_v3,$v3_to_v1,$lunch_time_from,$lunch_time_to,$contact_no1,$contact_no2,$contact_no3,$email_id,$whatsapp_no,$leagues_no_sets,$leagues_points,$quarter_finals_no_sets,$quarter_finals_points,$semifinals_no_sets,$semifinals_points,$finals_no_sets,$finals_points,$no_groups,$no_players_in_groups,$shuttles_used,$is_umpire_decision_final,$participation_certificate_for_all,$free_food,$topest_not_allowed_players,$prior_reporting_min,$winner_trophy,$runner_trophy,$semifinalist_trophy,$winner_medal,$runner_medal,$semifinalist_medal,$winner_goodies,$w_goodie_name,$runner_goodies,$r_goodie_name,$semifinalist_goodies,$s_goodie_name,$winner_cash_prize,$w_cash_amount,$runner_cash_prize,$r_cash_amount,$semifinalist_cash_prize,$s_cash_amount,$other_details,$newfilename,$gd_reporting_time,$gd_min_no_entries,$gd_fee,$gd_venue,$gd_categories,$bd_reporting_time,$bd_min_no_entries,$bd_fee,$bd_venue,$bd_categories,$bu_reporting_time,$bu_min_no_entries,$bu_fee,$bu_venue,$bu_categories,$gu_reporting_time,$gu_min_no_entries,$gu_fee,$gu_venue,$gu_categories,$ams_reporting_time,$ams_min_no_entries,$ams_fee,$ams_venue,$ams_categories,$afs_reporting_time,$afs_min_no_entries,$afs_fee,$afs_venue,$afs_categories,$ms_reporting_time,$ms_min_no_entries,$ms_fee,$ms_venue,$ms_categories,$md_reporting_time,$md_min_no_entries,$md_fee,$md_venue,$md_categories);  
	}
	header("location: index.php");
	exit;
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
					<h3 class="text-center text-default"><strong>Tornament Registration Form</strong></h3>
					<form method="post" action="index.php" id="form1" enctype="multipart/form-data">
						<h3 class="deepa-6"><strong>Game Rules:</strong></h3>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-5">
								<ul class="ul">
									<li>
										<h4 style="color:orange">Rule No. 01 - Shuttles Used:</h4>
									</li>
								</ul>
							</div>
							<div class="form-group col-sm-6">
								<select id="shuttles_used" class="browser-default custom-select" name="shuttles_used">
									<option value="" selected disabled><strong>Select</strong></option>
									<option value="feather" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['shuttles_used'] == 'feather' ) echo 'selected' ; }?> ><strong>Feather.</strong></option>
									<option value="plastic/nylon" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['shuttles_used'] == 'plastic/nylon' ) echo 'selected' ; }?> ><strong>Plastic / Nylon.</strong></option>
								</select>
							</div>
							<div class="form-group col-sm-12">
								<ul class="ul">
									<li>
										<h4 style="color:orange">Rule No. 02 - </h4>  
										<span class="form-check float-left">
											<input type="checkbox" class="form-check-input" id="umpire_decision_final" value="yes" name="is_umpire_decision_final" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['is_umpire_decision_final']== 'yes') ?  "checked" : "" ; } ?> >
											<label class="form-check-label" for="umpire_decision_final">Referees/ Umpire's decision will be Final</label>
										</span> 
									</li>
								</ul>
							</div>
							<div class="form-group col-sm-12">
								<ul class="ul">
									<li>
										<h4 style="color:orange">Rule No. 03 -</h4> 
										<span class="form-check float-left">
											<input type="checkbox" class="form-check-input" id="participation_certificate" value="yes" name="participation_certificate_for_all" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['participation_certificate_for_all']== 'yes') ?  "checked" : "" ; } ?> >
											<label class="form-check-label" for="participation_certificate">Participation Certificate for all Players</label>
										</span> 
									</li>
								</ul>
							</div>
							<div class="form-group col-sm-12">
								<ul class="ul">
									<li>
										<h4 style="color:orange">Rule No. 04 -</h4>
										<span class="form-check float-left">
											<input type="checkbox" class="form-check-input" id="free_food" value="yes" name="free_food" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['free_food']== 'yes') ?  "checked" : "" ; } ?>>
											<label class="form-check-label" for="free_food">Food Will be Provided:</label>
										</span>
									</li>
								</ul>
							</div>
							<div class="form-group col-sm-12">
								<ul class="ul">
									<li>		 
										<h4 style="color:orange">Rule No. 05 - Top <input id="id1" type="number" min="1" max="50" class="top-02" name="topest_not_allowed_players" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['topest_not_allowed_players']; }?>" > State or National Player are not allowed.</h4>
									</li>
								</ul>
							</div>
							<div class="form-group col-sm-12">
								<ul class="ul">
									<li>
										 <h4 style="color:orange">Rule No. 06 - Players are requested to report <input id="id1" type="number" min="1" max="50" class="top-02" name="prior_reporting_min" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['prior_reporting_min']; }?>" > min prior to the reporting time.</h4>
									</li>
								</ul>
							</div>
							<hr>
						</div>
						<div class="row">
							<div class="offset-md-10 col-md-2"><a href="t_prizes.php" title="prizes" class="btn btn-sm btn-default text-white">Save & Next</a></div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </main>
    <!---------------------------------Footer Section----------------------------------------->
    <footer class="bg-default">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 footer-box">
                    <h5 class="deepa-3" style="color:orange">TOURNAMENTS</h5>
                    <p class="deepa-4">Tournaments in bangalore</p>
                    <p>Tournaments in chennai</p>
                    <p>Tournaments in hyderabad</p>
                    <p>Tournaments in india</p>
                    <p>Global tournaments</p>

                </div>
                <div class="col-sm-4 footer-box">
                    <h5 class="deepa-3" style="color:orange">USEFUL LINKS</h5>
                    <p class="deepa-4">Organizers</p>
                    <p>About Us</p>
                    <p>Contact Us</p>
                    <p>Privacy Policy</p>
                    <p>Terms & Conditions</p>


                </div>
                <div class="col-sm-4 footer-box">
                    <h5 class="deepa-3" style="color:orange">LET'S CONNECT</h5>
                    <p class="deepa-4"><i class="fa fa-envelope-open "> info@playTournament.com</i></p>

                </div>
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
<!-- for timepicker-->
<script type="text/javascript" src = "https://mysportsarena.com/sportsbook/assets/js/jquery-ui-timespinner.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<script>
$(function(){
	 $(".date" ).datepicker({
        changeMonth:true,
        changeYear:true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1970:2019',
    });	
	$("#ex_img").on("click", function() {
	   $('#imagepreview').attr('src', $(this).attr('src')); // here asign the image to the modal when the user click the enlarge link
	   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
	});
	$('input.time').timespinner({
		format: 'HH:mm'
	});
});
</script>