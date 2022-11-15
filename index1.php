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
					<h3 class="text-center text-default"><strong>Documentation</strong></h3>
					<hr />
					<form method="post" action="index.php" id="form1" enctype="multipart/form-data">
						<div class="form-row">
							<input type="hidden" class="form-control" name="t_id" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['id']; }?>" />
							<div class="form-group col-sm-12">
								<label>Sports Type:</label>
								<select class="browser-default custom-select game_types" name="sports_type">
									<option disabled selected>Select Sports Type</option>
									<option value="cricket" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['sports_type'] == 'cricket' ) echo 'selected' ; }?> >Cricket</option>
									<option value="badminton"  <?php if (isset($play_tournaments)){if ($play_tournaments[0]['sports_type'] == 'badminton' ) echo 'selected' ; }?> >Badminton</option>
								</select>
								<hr />
							</div>
							<div class="form-group col-sm-12">
								<label>Tournament Name:</label>
								<input type="text" class="form-control" name="tournament_name" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['tournament_name']; }?>" required />
								<hr />
							</div>
							<div class="form-group col-sm-12">
								<label>Tournament Management Name:</label>
								<input type="text" class="form-control" name="management_name" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['management_name']; }?>" />
								<hr />
							</div>
							<div class="form-group col-sm-6">
								<label>Tournament Start Date:</label>
								<input type="text" class="form-control date" name="t_start_date" id="start_date" autocomplete="off" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['t_start_date']; }?>" />
								<hr />
							</div>
							<div class="form-group col-sm-6">
								<label>Tournament End Date:</label>
								<input type="text" class="form-control date" name="t_end_date" id="end_date" autocomplete="off" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['t_end_date']; }?>" />
								<hr />
							</div>
							<div class="form-group col-sm-4">
								<label>Tournament Entry Open Date:</label>
								<input type="text" class="form-control date" name="entry_start_date" id="entry_start_date" autocomplete="off" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['entry_start_date']; }?>"/>
							</div>
							<div class="form-group col-sm-4">
								<label>Tournament Entry Close Date:</label>
								<input type="text" class="form-control date" name="entry_end_date" id="entry_end_date" autocomplete="off" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['entry_end_date']; }?>"/>
							</div>
							<div class="form-group col-sm-4">
								<p>Withdrawal Option:</p>
								<div class="custom-control custom-radio">
									<input type="radio" class="custom-control-input" id="withdrawal_yes" value="yes" name="is_withdrawable" onclick="myChkFunction()" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['is_withdrawable']== 'yes') ?  "checked" : "checked" ; } ?> >
									<label class="custom-control-label" for="withdrawal_yes">yes</label>
								</div>
								<div class="custom-control custom-radio">
									<input type="radio" class="custom-control-input" id="withdrawal_no" value="no" name="is_withdrawable" onclick="myChkFunction()" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['is_withdrawable']== 'no') ?  "checked" : "checked" ; } ?> >
									<label class="custom-control-label" for="withdrawal_no">no</label>
								</div>
								<p id="text" >
									<input type="text" class="form-control" name="withdraw_reason" id="withdraw_reason" style="display:none" value="<?php if (isset($play_tournaments)){if ($play_tournaments[0]['withdraw_reason']!=""){echo $play_tournaments[0]['withdraw_reason']; } } ?>" >
								</p>
							</div>
							<!----------------------------------Venues Box-1--------------------------------------->

							<div class="form-group col-md-4  col-sm-4">
								<label>Tournament Venue - 01:</label>
								<textarea placeholder=" " style="height:150px" name="venue1"><?php if (isset($play_tournaments)){echo $play_tournaments[0]['venue1']; } ?></textarea>
							</div>
							<div class="form-group col-sm-4">
								<label>Address of Venue - 01:</label>
								<!--<textarea placeholder=" " style="height:200px" name="venue_address1"></textarea>-->
								<div class="form-group row">
									<div class="col-sm-12">
										<select class="browser-default custom-select country" name="country1" id="1">
											<?php if (isset($play_tournaments)){
													echo '<option value="'.$play_tournaments[0]['country_id1'].'" selected>'.$play_tournaments[0]['country1'].'</option>';
												}else{?>
													<option value="" disabled selected >Select country</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<select class="browser-default custom-select state" name="state1" id="state1">
											<?php if (isset($play_tournaments)){
													echo '<option value="'.$play_tournaments[0]['state_id1'].'" selected>'.$play_tournaments[0]['state1'].'</option>';
												}else{?>
													<option value="" disabled selected>Select state</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="md-form mt-0">
											<input type="text" class="form-control" id="city1" name="city1" placeholder="City" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['city1']; }?>" >
										</div>
									</div>
								</div>
							</div>
							<div class="form-group col-sm-4">
								<label>No of Courts in Venue - 01:</label>
								<textarea placeholder=" " style="height:150px" name="no_courts1" ><?php if (isset($play_tournaments)){echo $play_tournaments[0]['no_courts1']; }?></textarea>
							</div>

							<div class="form-group col-sm-3">
								<label>Venue - 01, Start Date :</label>
								<input type="text" class="form-control date" name="start_date1" autocomplete="off" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['start_date1']; }?>" />
								<hr />
							</div>
							<div class="form-group col-sm-3">
								<label>Venue - 01, Start Time:</label>
								<input type="text" class="form-control time" name="start_time1" placeholder="HH:MM:SS"value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['start_time1']; }?>" />
								<hr />
							</div>
							<div class="form-group col-sm-3">
								<label>Venue - 01, End Date:</label>
								<input type="text" class="form-control date" name="end_date1" autocomplete="off"value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['end_date1']; }?>" />
								<hr />
							</div>
							<div class="form-group col-sm-3">
								<label>Venue - 01, End Time:</label>
								<input type="text" class="form-control time" name="end_time1" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['end_time1']; }?>" />
								<hr />
							</div>
							<!---------------------------------------Venues Box-1------------------------------------>
							<!---------------------------------------Venues Box-2------------------------------------>

							<div class="form-group col-sm-4">
								<label>Tournament Venue - 02:</label>
								<textarea placeholder=" " style="height:150px" name="venue2"><?php if (isset($play_tournaments)){echo $play_tournaments[0]['venue2']; } ?></textarea>
							</div>
							<div class="form-group col-sm-4">
								<label>Address of Venue - 02:</label>
								<!--<textarea placeholder=" " style="height:200px" name="venue_address2"></textarea>--->
								<div class="form-group row">
									<div class="col-sm-12">
										<select class="browser-default custom-select country" name="country2" id="2">
											<?php if (isset($play_tournaments)){
													echo '<option value="'.$play_tournaments[0]['country_id2'].'" selected>'.$play_tournaments[0]['country2'].'</option>';
												}else{?>
													<option value="" disabled selected >Select country</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<select class="browser-default custom-select state" name="state2" id="state2">
											<?php if (isset($play_tournaments)){
													echo '<option value="'.$play_tournaments[0]['state_id2'].'" selected>'.$play_tournaments[0]['state2'].'</option>';
												}else{?>
													<option value="" disabled selected>Select state</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="md-form mt-0">
											<input type="text" class="form-control" id="city2" name="city2" placeholder="City" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['city2']; }?>">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group col-sm-4">
								<label>No of Courts in Venue - 02:</label>
								<textarea placeholder=" " style="height:150px" name="no_courts2"><?php if (isset($play_tournaments)){echo $play_tournaments[0]['no_courts2']; }?></textarea>
							</div>

							<div class="form-group col-sm-3">
								<label>Venue - 02, Start Date:</label>
								<input type="text" class="form-control date" name="start_date2" autocomplete="off" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['start_date2']; }?>"/>
								<hr />
							</div>
							<div class="form-group col-sm-3">
								<label>Venue - 02, Start Time:</label>
								<input type="text" class="form-control time" name="start_time2" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['start_time2']; }?>"/>
								<hr />
							</div>
							<div class="form-group col-sm-3">
								<label>Venue - 02, End Date:</label>
								<input type="text" class="form-control date" name="end_date2" autocomplete="off" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['end_date2']; }?>"/>
								<hr />
							</div>
							<div class="form-group col-sm-3">
								<label>Venue - 02, End Time:</label>
								<input type="text" class="form-control time" name="end_time2" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['end_time2']; }?>"/>
								<hr />
							</div>
							<!---------------------------------------Venues Box-2------------------------------------>
							<!---------------------------------------Venues Box-3------------------------------------>
							<div class="form-group col-sm-4">
								<label>Tournament Venue - 03:</label>
								<textarea placeholder=" " style="height:150px" name="venue3"><?php if (isset($play_tournaments)){echo $play_tournaments[0]['venue3']; } ?></textarea>
							</div>
							<div class="form-group col-sm-4">
								<label>Address of Venue - 03:</label>
								<!--<textarea placeholder=" " style="height:200px" name="venue_address3"></textarea>-->
								<div class="form-group row">
									<div class="col-sm-12">
										<select class="browser-default custom-select country" name="country3" id="3" >
											<?php if (isset($play_tournaments)){
													echo '<option value="'.$play_tournaments[0]['country_id3'].'" selected>'.$play_tournaments[0]['country3'].'</option>';
												}else{?>
													<option value="" disabled selected >Select country</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<select class="browser-default custom-select state" name="state3" id="state3" >
											<?php if (isset($play_tournaments)){
													echo '<option value="'.$play_tournaments[0]['state_id3'].'" selected>'.$play_tournaments[0]['state3'].'</option>';
												}else{?>
													<option value="" disabled selected>Select state</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<div class="md-form mt-0">
											<input type="text" class="form-control" id="city3" name="city3" placeholder="City" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['city3']; }?>">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group col-sm-4">
								<label>No of Courts in Venue - 03:</label>
								<textarea placeholder=" " style="height:150px" name="no_courts3"><?php if (isset($play_tournaments)){echo $play_tournaments[0]['no_courts3']; }?></textarea>
							</div>

							<div class="form-group col-sm-3">
								<label>Venue - 03, Start Date:</label>
								<input type="text" class="form-control date"  name="start_date3" autocomplete="off" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['start_date3']; }?>"/>
								<hr />
							</div>
							<div class="form-group col-sm-3">
								<label>Venue - 03, Start Time:</label>
								<input type="text" class="form-control time"  name="start_time3" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['start_time3']; }?>"/>
								<hr />
							</div>
							<div class="form-group col-sm-3">
								<label>Venue - 03, End Date:</label>
								<input type="text" class="form-control date"  name="end_date3" autocomplete="off" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['end_date3']; }?>"/>
								<hr />
							</div>
							<div class="form-group col-sm-3">
								<label>Venue - 03, End Time:</label>
								<input type="text" class="form-control time"  name="end_time3" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['end_time3']; }?>"/>
								<hr />
							</div>
							<!-------------------------------------Venues Box-3-------------------------------->

						</div>
						<h5 class="deepa-6" style="color: #4caf50"><strong>Travel Time:</strong></h5>
						<hr>
						<div class="form-row ">
							<div class="form-group col-sm-4">
								<label>Venue 01 to Venue 02:</label>
								<input type="text" class="form-control time"  name="v1_to_v2" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['v1_to_v2']; }?>" />
							</div>
							<div class="form-group col-sm-4">
								<label>Venue 02 to Venue 03:</label>
								<input type="text" class="form-control time"  name="v2_to_v3" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['v2_to_v3']; }?>" />

							</div>
							<div class="form-group col-sm-4">
								<label>Venue 03 to Venue 01:</label>
								<input type="text" class="form-control time"  name="v3_to_v1" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['v3_to_v1']; }?>" />
							</div>
						</div>
						<hr>
						<h5 class="deepa-6" style="color: #4caf50"><strong>Lunch Time:</strong></h5>
						<hr>
						<div class="form-row ">
							<div class="form-group col-sm-6">
								<label>From:</label>
								<input type="text" class="form-control time"  name="lunch_time_from" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['lunch_time_from']; }?>" />
							</div>
							<div class="form-group col-sm-6">
								<label>To:</label>
								<input type="text" class="form-control time"  name="lunch_time_to" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['lunch_time_to']; }?>" />

							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<h5 class="deepa-6" style="color: #4caf50"><strong>Organizers contact number:</strong></h5>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label>Contact Number1:</label>
									<input type="text" class="form-control" name="contact_no1" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['contact_no1']; }?>" />
								</div>
								<div class="col-md-4">
									<label>Contact Number2:</label>
									<input type="text" class="form-control" name="contact_no2" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['contact_no2']; }?>" />
								</div>
								<div class="col-md-4">
									<label>Contact Number3:</label>
									<input type="text" class="form-control" name="contact_no3" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['contact_no3']; }?>" />
								</div>
							</div>
							<hr />
						</div>
						<div class="form-group">
							<label>Mail Id:</label>
							<input type="text" class="form-control" name="email_id" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['email_id']; }?>" />
							<hr />
						</div>
						<div class="form-group">
							<label>WhatsApp Number:</label>
							<input type="text" class="form-control" name="whatsapp_no" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['whatsapp_no']; }?>" />
							<hr />
						</div>

						<h5 class="deepa-6 "><strong>Format of Tournament:<br>Knock Out:</strong></h5>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-3">
								<label style="color: #4caf50"><strong>No of Sets:</strong>
									<hr></label>
							</div>
							<div class="form-group col-sm-2">
								<label>In Leagues Matches:</label>
								<input type="text" class="form-control" name="leagues_no_sets" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['leagues_no_sets']; }?>" />
							</div>
							<div class="form-group col-sm-2">
								<label>In Quater Finals:</label>
								<input type="text" class="form-control" name="quarter_finals_no_sets" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['quarter_finals_no_sets']; }?>" />
							</div>
							<div class="form-group col-sm-2">
								<label>In Semi Finals:</label>
								<input type="text" class="form-control" name="semifinals_no_sets" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['semifinals_no_sets']; }?>" />
							</div>
							<div class="form-group col-sm-2">
								<label>In Finals:</label>
								<input type="text" class="form-control" name="finals_no_sets" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['finals_no_sets']; }?>" />
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-sm-3">
								<label style="color: #4caf50"><strong>Points in each Sets:</strong>
									<hr></label>
							</div>
							<div class="form-group col-sm-2">
								<label>In Leagues Matches:</label>
								<input type="text" class="form-control" name="leagues_points" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['leagues_points']; }?>" />
							</div>
							<div class="form-group col-sm-2">
								<label>In Quater Finals:</label>
								<input type="text" class="form-control" name="quarter_finals_points" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['quarter_finals_points']; }?>" />
							</div>
							<div class="form-group col-sm-2">
								<label>In Semi Finals:</label>
								<input type="text" class="form-control" name="semifinals_points" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['semifinals_points']; }?>" />
							</div>
							<div class="form-group col-sm-2">
								<label>In Finals:</label>
								<input type="text" class="form-control" name="finals_points" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['finals_points']; }?>" />
							</div>
						</div>
						<hr>
						<!-----------------------------------Game Rules-------------------------------------->

						<h3 class="deepa-6"><strong>Game Rules:</strong></h3>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-5">
								<ul>
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
								<ul>
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
								<ul>
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
								<ul>
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
								<ul>
									<li>		 
										<h4 style="color:orange">Rule No. 05 - Top <input id="id1" type="number" min="1" max="50" class="top-02" name="topest_not_allowed_players" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['topest_not_allowed_players']; }?>" > State or National Player are not allowed.</h4>
									</li>
								</ul>
							</div>
							<div class="form-group col-sm-12">
								<ul>
									<li>
										 <h4 style="color:orange">Rule No. 06 - Players are requested to report <input id="id1" type="number" min="1" max="50" class="top-02" name="prior_reporting_min" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['prior_reporting_min']; }?>" > min prior to the reporting time.</h4>
									</li>
								</ul>
							</div>
							<hr>
						</div>

						<hr>
						<h3 class="deepa-6"><strong>Prize:</strong></h3>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-12">
								<ul>
									<li>
										<h4 class="deepa-6"><strong>Trophy:</strong></h4>
									</li>
								</ul>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<span class="form-check float-left">
									<input type="checkbox" class="form-check-input" id="winner_trophy" name="winner_trophy" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['winner_trophy']== 'yes') ?  "checked" : "" ; } ?> >
									<label class="form-check-label" for="winner_trophy">Winner</label>
								</span> 
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<span class="form-check float-left">
									<input type="checkbox" class="form-check-input" id="runner_trophy" name="runner_trophy" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['runner_trophy']== 'yes') ?  "checked" : "" ; } ?> >
									<label class="form-check-label" for="runner_trophy">Runner</label>
								</span>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<span class="form-check float-left">
									<input type="checkbox" class="form-check-input" id="semifinalist_trophy" name="semifinalist_trophy" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['semifinalist_trophy']== 'yes') ?  "checked" : "" ; } ?> >
									<label class="form-check-label" for="semifinalist_trophy">Semifinalist</label>
								</span>
							</div>
							<div class="form-group col-sm-12">
								<ul>
									<li>
										<h4 class="deepa-6"><strong>Medals:</strong></h4>
									</li>
								</ul>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<span class="form-check float-left">
									<input type="checkbox" class="form-check-input" id="winner_medal" name="winner_medal" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['winner_medal']== 'yes') ?  "checked" : "" ; } ?> >
									<label class="form-check-label" for="winner_medal">Winner</label>
								</span>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<span class="form-check float-left">
									<input type="checkbox" class="form-check-input" id="runner_medal" name="runner_medal" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['runner_medal']== 'yes') ?  "checked" : "" ; } ?> >
									<label class="form-check-label" for="runner_medal">Runner</label>
								</span>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<span class="form-check float-left">
									<input type="checkbox" class="form-check-input" id="semifinalist_medal" name="semifinalist_medal" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['semifinalist_medal']== 'yes') ?  "checked" : "" ; } ?> >
									<label class="form-check-label" for="semifinalist_medal">Semifinalist</label>
								</span>
							</div>
							<div class="form-group col-sm-12">
								<ul>
									<li>
										<h4 class="deepa-6"><strong>Goodies:</strong></h4>
									</li>
								</ul>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<div class="row">
									<div class="col-md-4">
										<span class="form-check float-left">
											<input type="checkbox" class="form-check-input" id="winner_goodies" name="winner_goodies" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['winner_goodies']== 'yes') ?  "checked" : "" ; } ?> >
											<label class="form-check-label" for="winner_goodies">Winner</label>
										</span>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="What Goodies..." name="w_goodie_name" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['w_goodie_name']; }?>" />
									</div>
								</div>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<div class="row">
									<div class="col-md-4">
										<span class="form-check float-left">
											<input type="checkbox" class="form-check-input" id="runner_goodies" name="runner_goodies" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['runner_goodies']== 'yes') ?  "checked" : "" ; } ?> >
											<label class="form-check-label" for="runner_goodies">Runner</label>
										</span>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="What Goodies..." name="r_goodie_name" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['r_goodie_name']; }?>" />
									</div>
								</div>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<div class="row">
									<div class="col-md-4">
										<span class="form-check float-left">
											<input type="checkbox" class="form-check-input" id="semifinalist_goodies" name="semifinalist_goodies" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['semifinalist_goodies']== 'yes') ?  "checked" : "" ; } ?> >
											<label class="form-check-label" for="semifinalist_goodies">Semifinalist</label>
										</span>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="What Goodies..." name="s_goodie_name" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['s_goodie_name']; }?>" />
									</div>
								</div>
							</div>        
							<div class="form-group col-sm-12">
								<ul>
									<li>
										<h4 class="deepa-6"><strong>Cash Prize:</strong></h4>
									</li>
								</ul>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<div class="row">
									<div class="col-md-4">
										<span class="form-check float-left">
											<input type="checkbox" class="form-check-input" id="winner_cash_prize" name="winner_cash_prize" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['winner_cash_prize']== 'yes') ?  "checked" : "" ; } ?> >
											<label class="form-check-label" for="winner_cash_prize">Winner</label>
										</span>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="How Much Cash..." name="w_cash_amount" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['w_cash_amount']; }?>" />
									</div>
								</div>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<div class="row">
									<div class="col-md-4">
										<span class="form-check float-left">
											<input type="checkbox" class="form-check-input" id="runner_cash_prize" name="runner_cash_prize" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['runner_cash_prize']== 'yes') ?  "checked" : "" ; } ?> >
											<label class="form-check-label" for="runner_cash_prize">Runner</label>
										</span>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="How Much Cash..." name="r_cash_amount" value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['r_cash_amount']; }?>" />
									</div>
								</div>
							</div>
							<div class="form-group col-sm-10 offset-sm-1">
								<div class="row">
									<div class="col-md-4">
										<span class="form-check float-left">
											<input type="checkbox" class="form-check-input" id="semifinalist_cash_prize" name="semifinalist_cash_prize" value="yes" <?php if (isset($play_tournaments)){echo ($play_tournaments[0]['semifinalist_cash_prize']== 'yes') ?  "checked" : "" ; } ?> >
											<label class="form-check-label" for="semifinalist_cash_prize">Semifinalist</label>
										</span>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="How Much Cash..." name="s_cash_amount"  value="<?php if (isset($play_tournaments)){echo $play_tournaments[0]['s_cash_amount']; }?>" />
									</div>
								</div>
							</div>
						</div>
						<hr>
					   

						<!-----------------------------------Script ------------------------------->
						<script>
							function myBFunction() {
								var inpObj = document.getElementById("id1");

								document.getElementById("demo").innerHTML = "";
							}
						</script>
						<!-----------------------------------Script ------------------------------->

						<!-----------------------------------Script ------------------------------->
						<script>
							function myAFunction() {
								var inpObj = document.getElementById("id2");

								document.getElementById("demo").innerHTML = "";
							}
						</script>
						<!-----------------------------------Script ------------------------------->

						<!----------------------------------Game Rules----------------------------->
						<!----------------------------------Detail Box----------------------------->

						<div class="form-row">
							<div class="form-group col-md-12 col-ms-12">
								<label>Details:</label>
								<textarea placeholder=" " style="height:200px" name="other_details"><?php if (isset($play_tournaments)){echo $play_tournaments[0]['other_details']; }?></textarea>
								<hr />
							</div>
							<div class="form-group col-md-6 col-ms-6">
								<label>Upload Image:</label>
								<div class="form-group col-md-12">
									<?php if (isset($play_tournaments)){
										if ($play_tournaments[0]['image']!=""){
											echo '<img src="images/'.$play_tournaments[0]['image'].'" alt="" height="70" width="70">'; 
										}
									}?>
									<input type="file" id="myFile" name="image" id1="img_prvw" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['image']; }?>" />
									<!-- <div class="img_prvw"></div> -->
									<!-- <button onclick="myFunction() "></button> -->

									<!---------------------------------Script-------------------------------------->
									<script>
										function myFunction() {
											var x = document.getElementById("myFile");
											// x.disabled = true;
										}
									</script>
									<!------------------------------------------------------------------------------->
								</div>
							</div>
							<div class="form-group col-md-6 col-ms-6 ">
								<div class="float-right"><span>Ex: </span><img src="images/play_tournament_ex_img.jpeg" alt="" height="70" width="70" id="ex_img"></div>
							</div>
							<hr />
						</div>
						<h5 class="deepa-6"><strong>Categories:</strong></h5>
						<hr>

						<!----------------------------------THIRD BUTTON------------------------------------------>

						<h5 style="color: rgb(192, 96, 96)"><strong>Girls Double:</strong></h5>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-3">
								<label><strong>Reporting Time:</strong></label>
								<input type="text" class="form-control time" name="gd_reporting_time" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['gd_reporting_time']; }?>" >
							</div>
							<div class="form-group col-sm-3">
								<label><strong>Min No of Entries:</strong></label>
								<input type="text" class="form-control" name="gd_min_no_entries" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['gd_min_no_entries']; }?>" >

							</div>

							<div class="form-group  col-sm-3">
								<label><strong>Fee:</strong></label>
								<input type="text" class="form-control" name="gd_fee" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['gd_fee']; }?>" >
							</div>
							<div class="form-group  col-sm-3">
								<label class="ven-01"><strong>Venue:</strong></label>
								<select id="Venue" class="browser-default custom-select" name="gd_venue">
									<option value="" selected><strong>Select</strong></option>
									<option value="venue1" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['gd_venue'] == 'venue1' ) echo 'selected' ; }?> ><strong>Venue - 01</strong></option>
									<option value="venue2" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['gd_venue'] == 'venue2' ) echo 'selected' ; }?> ><strong>Venue - 02</strong></option>
									<option value="venue3" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['gd_venue'] == 'venue3' ) echo 'selected' ; }?> ><strong>Venue - 03</strong></option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12"><label class="ven-01"><strong>Select Category:</strong></label></div>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<?php
												$gd08_style="";$gd08_id1="0";$gd09_style="";$gd09_id1="0";$gd10_style="";$gd10_id1="0";$gd11_style="";$gd11_id1="0";$gd13_style="";$gd13_id1="0";$gd15_style="";$gd15_id1="0";$gd17_style="";$gd17_id1="0";$gd19_style="";$gd19_id1="0";$gd25_style="";$gd25_id1="0";$gd35_style="";$gd35_id1="0";$gd45_style="";$gd45_id1="0";$AdultsFEMALE_style="";$AdultsFEMALE_id1="0";
												if(isset($play_tournaments)){
													$categories=explode(",",$play_tournaments[0]['gd_categories']);
													foreach($categories as $key=>$value){
														if($value=="GD-08"){
															$gd08_style="background-color:#33b5e5";
															$gd08_id1="1";
														}
														if($value=="GD-09"){
															$gd09_style="background-color:#33b5e5";
															$gd09_id1="1";
														}
														if($value=="GD-10"){
															$gd10_style="background-color:#33b5e5";
															$gd10_id1="1";
														}
														if($value=="GD-11"){
															$gd11_style="background-color:#33b5e5";
															$gd11_id1="1";
														}
														if($value=="GD-13"){
															$gd13_style="background-color:#33b5e5";
															$gd13_id1="1";
														}
														if($value=="GD-15"){
															$gd15_style="background-color:#33b5e5";
															$gd15_id1="1";
														}
														if($value=="GD-17"){
															$gd17_style="background-color:#33b5e5";
															$gd17_id1="1";
														}
														if($value=="GD-19"){
															$gd19_style="background-color:#33b5e5";
															$gd19_id1="1";
														}
														if($value=="GD-25"){
															$gd25_style="background-color:#33b5e5";
															$gd25_id1="1";
														}
														if($value=="GD-35"){
															$gd35_style="background-color:#33b5e5";
															$gd35_id1="1";
														}
														if($value=="GD-45"){
															$gd45_style="background-color:#33b5e5";
															$gd45_id1="1";
														}
														if($value=="Adults_FEMALE"){
															$gdAdults_style="background-color:#33b5e5";
															$gdAdults_id1="1";
														}
													}
												}
											?>
											<td><button type="button" id="gd" value="GD-08" id1="<?php echo $gd08_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd08_style; ?>" >GD-08</button></td>
											<td><button type="button" id="gd" value="GD-09" id1="<?php echo $gd09_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd09_style; ?>" >GD-09</button></td>
											<td><button type="button" id="gd" value="GD-10" id1="<?php echo $gd10_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd10_style; ?>" >GD-10</button></td>
											<td><button type="button" id="gd" value="GD-11" id1="<?php echo $gd11_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd11_style; ?>" >GD-11</button></td>
											<td><button type="button" id="gd" value="GD-13" id1="<?php echo $gd13_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd13_style; ?>" >GD-13</button></td>
											<td><button type="button" id="gd" value="GD-15" id1="<?php echo $gd15_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd15_style; ?>" >GD-15</button></td>
											<td><button type="button" id="gd" value="GD-17" id1="<?php echo $gd17_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd17_style; ?>" >GD-17</button></td>
											<td><button type="button" id="gd" value="GD-19" id1="<?php echo $gd19_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd19_style; ?>" >GD-19</button></td>
											<td><button type="button" id="gd" value="GD-25" id1="<?php echo $gd25_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd25_style; ?>" >GD-25</button></td>
											<td><button type="button" id="gd" value="GD-35" id1="<?php echo $gd35_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd35_style; ?>" >GD-35</button></td>
											<td><button type="button" id="gd" value="GD-45" id1="<?php echo $gd45_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gd45_style; ?>" >GD-45</button></td>
											<td><button type="button" id="gd" value="Adults-FEMALE" id1="<?php echo $gdAdults_id1; ?>" class="btn btn-sm black-text px-1 category_btn gd" style="<?php echo $gdAdults_style; ?>" >Adults-FEMALE</button></td>
											<td><button type="button" id="gd" class="btn btn-sm btn-default px-2 clear_category_btn">Clear Categories</button></td>
										</tr>
									</tbody>
								</table>
							</div>
							<input type="hidden" name="gd_categories" id="gd_categories"  value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['gd_categories']; }?>" />
						</div>
						<hr>
						<!--------------------------------------FOURTH BITTON------------------------------------->

						<h5 style="color: rgb(192, 96, 96)"><strong>Boys Double:</strong></h5>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-3">
								<label><strong>Reporting Time:</strong></label>
								<input type="text" class="form-control time" name="bd_reporting_time" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['bd_reporting_time']; }?>" >

							</div>
							<div class="form-group col-sm-3">
								<label><strong>Min No of Entries:</strong></label>
								<input type="text" class="form-control" name="bd_min_no_entries" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['bd_min_no_entries']; }?>" >

							</div>
							<div class="form-group  col-sm-3">
								<label><strong>Fee:</strong></label>
								<input type="text" class="form-control" name="bd_fee" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['bd_fee']; }?>" >
							</div>
							<div class="form-group  col-sm-3">
								<label class="ven-01"><strong>Venue:</strong></label>
								<select id="Venue" class="browser-default custom-select" name="bd_venue">
									<option value="" selected><strong>Select</strong></option>
									<option value="venue1" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['bd_venue'] == 'venue1' ) echo 'selected' ; }?> ><strong>Venue - 01</strong></option>
									<option value="venue2" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['bd_venue'] == 'venue2' ) echo 'selected' ; }?> ><strong>Venue - 02</strong></option>
									<option value="venue3" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['bd_venue'] == 'venue3' ) echo 'selected' ; }?> ><strong>Venue - 03</strong></option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12"><label class="ven-01"><strong>Select Category:</strong></label></div>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<?php
												$bd08_style="";$bd08_id1="0";$bd09_style="";$bd09_id1="0";$bd10_style="";$bd10_id1="0";$bd11_style="";$bd11_id1="0";$bd13_style="";$bd13_id1="0";$bd15_style="";$bd15_id1="0";$bd17_style="";$bd17_id1="0";$bd19_style="";$bd19_id1="0";$bd25_style="";$bd25_id1="0";$bd35_style="";$bd35_id1="0";$bd45_style="";$bd45_id1="0";$AdultsMALE_style="";$AdultsMALE_id1="0";
												if(isset($play_tournaments)){
													$categories=explode(",",$play_tournaments[0]['bd_categories']);
													foreach($categories as $key=>$value){
														if($value=="BD-08"){
															$bd08_style="background-color:#33b5e5";
															$bd08_id1="1";
														}
														if($value=="BD-09"){
															$bd09_style="background-color:#33b5e5";
															$bd09_id1="1";
														}
														if($value=="BD-10"){
															$bd10_style="background-color:#33b5e5";
															$bd10_id1="1";
														}
														if($value=="BD-11"){
															$bd11_style="background-color:#33b5e5";
															$bd11_id1="1";
														}
														if($value=="BD-13"){
															$bd13_style="background-color:#33b5e5";
															$bd13_id1="1";
														}
														if($value=="BD-15"){
															$bd15_style="background-color:#33b5e5";
															$bd15_id1="1";
														}
														if($value=="BD-17"){
															$bd17_style="background-color:#33b5e5";
															$bd17_id1="1";
														}
														if($value=="BD-19"){
															$bd19_style="background-color:#33b5e5";
															$bd19_id1="1";
														}
														if($value=="BD-25"){
															$bd25_style="background-color:#33b5e5";
															$bd25_id1="1";
														}
														if($value=="BD-35"){
															$bd35_style="background-color:#33b5e5";
															$bd35_id1="1";
														}
														if($value=="BD-45"){
															$bd45_style="background-color:#33b5e5";
															$bd45_id1="1";
														}
														if($value=="Adults-MALE"){
															$bdAdults_style="background-color:#33b5e5";
															$bdAdults_id1="1";
														}
													}
												}
											?>
											<td><button type="button" id="bd" value="BD-08" id1="<?php echo $bd08_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd08_style; ?>" >BD-08</button></td>
											<td><button type="button" id="bd" value="BD-09" id1="<?php echo $bd09_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd09_style; ?>" >BD-09</button></td>
											<td><button type="button" id="bd" value="BD-10" id1="<?php echo $bd10_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd10_style; ?>" >BD-10</button></td>
											<td><button type="button" id="bd" value="BD-11" id1="<?php echo $bd11_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd11_style; ?>" >BD-11</button></td>
											<td><button type="button" id="bd" value="BD-13" id1="<?php echo $bd13_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd13_style; ?>" >BD-13</button></td>
											<td><button type="button" id="bd" value="BD-15" id1="<?php echo $bd15_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd15_style; ?>" >BD-15</button></td>
											<td><button type="button" id="bd" value="BD-17" id1="<?php echo $bd17_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd17_style; ?>" >BD-17</button></td>
											<td><button type="button" id="bd" value="BD-19" id1="<?php echo $bd19_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd19_style; ?>" >BD-19</button></td>
											<td><button type="button" id="bd" value="BD-25" id1="<?php echo $bd25_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd25_style; ?>" >BD-25</button></td>
											<td><button type="button" id="bd" value="BD-35" id1="<?php echo $bd35_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd35_style; ?>" >BD-35</button></td>
											<td><button type="button" id="bd" value="BD-45" id1="<?php echo $bd45_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bd45_style; ?>" >BD-45</button></td>
											<td><button type="button" id="bd" value="Adults-MALE" id1="<?php echo $bdAdults_id1; ?>" class="btn btn-sm black-text px-1 category_btn bd" style="<?php echo $bdAdults_style; ?>" >Adults-MALE</button></td>
											<td><button type="button" id="bd" class="btn btn-sm btn-default px-2 clear_category_btn">Clear Categories</button></td>
										</tr>
									</tbody>
								</table>
							</div>
							<input type="hidden" name="bd_categories" id="bd_categories" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['bd_categories']; }?>" />
						</div>
						<hr>
						<!----------------------------------------FIVE CARD---------------------------------->

						<h5 style="color: rgb(192, 96, 96)"><strong>Boy Single:</strong></h5>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-3">
								<label><strong>Reporting Time:</strong></label>
								<input type="text" class="form-control time" name="bu_reporting_time" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['bu_reporting_time']; }?>">

							</div>

							<div class="form-group col-sm-3">
								<label><strong>Min No of Entries:</strong></label>
								<input type="text" class="form-control" name="bu_min_no_entries" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['bu_min_no_entries']; }?>" >

							</div>

							<div class="form-group  col-sm-3">
								<label><strong>Fee:</strong></label>
								<input type="text" class="form-control" name="bu_fee" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['bu_fee']; }?>" >
							</div>
							<div class="form-group  col-sm-3">
								<label class="ven-01"><strong>Venue:</strong></label>
								<select id="Venue" class="browser-default custom-select" name="bu_venue">
									<option value="" selected><strong>Select</strong></option>
									<option value="venue1" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['bu_venue'] == 'venue1' ) echo 'selected' ; }?> ><strong>Venue - 01</strong></option>
									<option value="venue2" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['bu_venue'] == 'venue2' ) echo 'selected' ; }?> ><strong>Venue - 02</strong></option>
									<option value="venue3" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['bu_venue'] == 'venue3' ) echo 'selected' ; }?> ><strong>Venue - 03</strong></option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12"><label class="ven-01"><strong>Select Category:</strong></label></div>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<?php
												$bu08_style="";$bu08_id1="0";$bu09_style="";$bu09_id1="0";$bu10_style="";$bu10_id1="0";$bu11_style="";$bu11_id1="0";$bu13_style="";$bu13_id1="0";$bu15_style="";$bu15_id1="0";$bu17_style="";$bu17_id1="0";$bu19_style="";$bu19_id1="0";$buAdults_style="";$buAdults_id1="0";
												if(isset($play_tournaments)){
													$categories=explode(",",$play_tournaments[0]['bu_categories']);
													foreach($categories as $key=>$value){
														if($value=="BU-08"){
															$bu08_style="background-color:#33b5e5";
															$bu08_id1="1";
														}
														if($value=="BU-09"){
															$bu09_style="background-color:#33b5e5";
															$bu09_id1="1";
														}
														if($value=="BU-10"){
															$bu10_style="background-color:#33b5e5";
															$bu10_id1="1";
														}
														if($value=="BU-11"){
															$bu11_style="background-color:#33b5e5";
															$bu11_id1="1";
														}
														if($value=="BU-13"){
															$bu13_style="background-color:#33b5e5";
															$bu13_id1="1";
														}
														if($value=="BU-15"){
															$bu15_style="background-color:#33b5e5";
															$bu15_id1="1";
														}
														if($value=="BU-17"){
															$bu17_style="background-color:#33b5e5";
															$bu17_id1="1";
														}
														if($value=="BU-19"){
															$bu19_style="background-color:#33b5e5";
															$bu19_id1="1";
														}
														if($value=="Adults-MALE"){
															$buAdults_style="background-color:#33b5e5";
															$buAdults_id1="1";
														}
													}
												}
											?>
											<td><button type="button" id="bu" value="BU-08" id1="<?php echo $bu08_id1; ?>" class="btn btn-sm black-text px-2 category_btn bu" style="<?php echo $bu08_style; ?>" >BU-08</button></td>
											<td><button type="button" id="bu" value="BU-09" id1="<?php echo $bu09_id1; ?>" class="btn btn-sm black-text px-2 category_btn bu" style="<?php echo $bu09_style; ?>" >BU-09</button></td>
											<td><button type="button" id="bu" value="BU-10" id1="<?php echo $bu10_id1; ?>" class="btn btn-sm black-text px-2 category_btn bu" style="<?php echo $bu10_style; ?>" >BU-10</button></td>
											<td><button type="button" id="bu" value="BU-11" id1="<?php echo $bu11_id1; ?>" class="btn btn-sm black-text px-2 category_btn bu" style="<?php echo $bu11_style; ?>" >BU-11</button></td>
											<td><button type="button" id="bu" value="BU-13" id1="<?php echo $bu13_id1; ?>" class="btn btn-sm black-text px-2 category_btn bu" style="<?php echo $bu13_style; ?>" >BU-13</button></td>
											<td><button type="button" id="bu" value="BU-15" id1="<?php echo $bu15_id1; ?>" class="btn btn-sm black-text px-2 category_btn bu" style="<?php echo $bu15_style; ?>" >BU-15</button></td>
											<td><button type="button" id="bu" value="BU-17" id1="<?php echo $bu17_id1; ?>" class="btn btn-sm black-text px-2 category_btn bu" style="<?php echo $bu17_style; ?>" >BU-17</button></td>
											<td><button type="button" id="bu" value="BU-19" id1="<?php echo $bu19_id1; ?>" class="btn btn-sm black-text px-2 category_btn bu" style="<?php echo $bu19_style; ?>" >BU-19</button></td>
											<td><button type="button" id="bu" value="Adults-MALE" id1="<?php echo $buAdults_id1; ?>" class="btn btn-sm black-text px-2 category_btn bu" style="<?php echo $buAdults_style; ?>" >Adults-MALE</button></td>
											<td><button type="button" id="bu" class="btn btn-sm btn-default px-2 clear_category_btn">Clear Categories</button></td>
										</tr>
									</tbody>
								</table>
							</div>
							<input type="hidden" name="bu_categories" id="bu_categories"  name="bd_reporting_time"  value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['bu_categories']; }?>" />
						</div>
						<hr>
						<!----------------------------------SIX-CARD--------------------------->

						<h5 style="color: rgb(192, 96, 96)"><strong>Girl Single:</strong></h5>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-3">
								<label><strong>Reporting Time:</strong></label>
								<input type="text" class="form-control time" name="gu_reporting_time" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['gu_reporting_time']; }?>">

							</div>

							<div class="form-group col-sm-3">
								<label><strong>Min No of Entries:</strong></label>
								<input type="text" class="form-control" name="gu_min_no_entries" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['gu_min_no_entries']; }?>" >

							</div>

							<div class="form-group  col-sm-3">
								<label><strong>Fee:</strong></label>
								<input type="text" class="form-control" name="gu_fee" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['gu_fee']; }?>" >
							</div>
							<div class="form-group  col-sm-3">
								<label class="ven-01"><strong>Venue:</strong></label>
								<select id="Venue" class="browser-default custom-select" name="gu_venue">
									<option value="" selected><strong>Select</strong></option>
									<option value="venue1" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['gu_venue'] == 'venue1' ) echo 'selected' ; }?> ><strong>Venue - 01</strong></option>
									<option value="venue2" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['gu_venue'] == 'venue2' ) echo 'selected' ; }?> ><strong>Venue - 02</strong></option>
									<option value="venue3" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['gu_venue'] == 'venue3' ) echo 'selected' ; }?> ><strong>Venue - 03</strong></option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12"><label class="ven-01"><strong>Select Category:</strong></label></div>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<?php
												$gu08_style="";$gu08_id1="0";$gu09_style="";$gu09_id1="0";$gu10_style="";$gu10_id1="0";$gu11_style="";$gu11_id1="0";$gu13_style="";$gu13_id1="0";$gu15_style="";$gu15_id1="0";$gu17_style="";$gu17_id1="0";$gu19_style="";$gu19_id1="0";$guAdults_style="";$guAdults_id1="0";
												if(isset($play_tournaments)){
													$categories=explode(",",$play_tournaments[0]['gu_categories']);
													foreach($categories as $key=>$value){
														if($value=="GU-08"){
															$gu08_style="background-color:#33b5e5";
															$gu08_id1="1";
														}
														if($value=="GU-09"){
															$gu09_style="background-color:#33b5e5";
															$gu09_id1="1";
														}
														if($value=="GU-10"){
															$gu10_style="background-color:#33b5e5";
															$gu10_id1="1";
														}
														if($value=="GU-11"){
															$gu11_style="background-color:#33b5e5";
															$gu11_id1="1";
														}
														if($value=="GU-13"){
															$gu13_style="background-color:#33b5e5";
															$gu13_id1="1";
														}
														if($value=="GU-15"){
															$gu15_style="background-color:#33b5e5";
															$gu15_id1="1";
														}
														if($value=="GU-17"){
															$gu17_style="background-color:#33b5e5";
															$gu17_id1="1";
														}
														if($value=="GU-19"){
															$gu19_style="background-color:#33b5e5";
															$gu19_id1="1";
														}
														if($value=="Adults-MALE"){
															$guAdults_style="background-color:#33b5e5";
															$guAdults_id1="1";
														}
													}
												}
											?>
											<td><button type="button" id="gu" value="GU-08" id1="<?php echo $gu08_id1; ?>" class="btn btn-sm black-text px-2 category_btn gu" style="<?php echo $gu08_style; ?>" >GU-08</button></td>
											<td><button type="button" id="gu" value="GU-09" id1="<?php echo $gu09_id1; ?>" class="btn btn-sm black-text px-2 category_btn gu" style="<?php echo $gu09_style; ?>" >GU-09</button></td>
											<td><button type="button" id="gu" value="GU-10" id1="<?php echo $gu10_id1; ?>" class="btn btn-sm black-text px-2 category_btn gu" style="<?php echo $gu10_style; ?>" >GU-10</button></td>
											<td><button type="button" id="gu" value="GU-11" id1="<?php echo $gu11_id1; ?>" class="btn btn-sm black-text px-2 category_btn gu" style="<?php echo $gu11_style; ?>" >GU-11</button></td>
											<td><button type="button" id="gu" value="GU-13" id1="<?php echo $gu13_id1; ?>" class="btn btn-sm black-text px-2 category_btn gu" style="<?php echo $gu13_style; ?>" >GU-13</button></td>
											<td><button type="button" id="gu" value="GU-15" id1="<?php echo $gu15_id1; ?>" class="btn btn-sm black-text px-2 category_btn gu" style="<?php echo $gu15_style; ?>" >GU-15</button></td>
											<td><button type="button" id="gu" value="GU-17" id1="<?php echo $gu17_id1; ?>" class="btn btn-sm black-text px-2 category_btn gu" style="<?php echo $gu17_style; ?>" >GU-17</button></td>
											<td><button type="button" id="gu" value="GU-19" id1="<?php echo $gu19_id1; ?>" class="btn btn-sm black-text px-2 category_btn gu" style="<?php echo $gu19_style; ?>" >GU-19</button></td>
											<td><button type="button" id="gu" value="Adults-FEMALE" id1="<?php echo $guAdults_id1; ?>" class="btn btn-sm black-text px-2 category_btn gu" style="<?php echo $guAdults_style; ?>" >Adults-FEMALE</button></td>
											<td><button type="button" id="gu" class="btn btn-sm btn-default px-2 clear_category_btn">Clear Categories</button></td>
										</tr>
									</tbody>
								</table>
							</div>
							<input type="hidden" name="gu_categories" id="gu_categories" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['gu_categories']; }?>" />
						</div>
						<hr>
						<!------------------------------------------7th-Card----------------------------------->

						<h5 style="color: rgb(192, 96, 96)"><strong>Adults Male Single:</strong></h5>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-3">
								<label><strong>Reporting Time:</strong></label>
								<input type="text" class="form-control time" name="ams_reporting_time" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['ams_reporting_time']; }?>">

							</div>

							<div class="form-group col-sm-3">
								<label><strong>Min No of Entries:</strong></label>
								<input type="text" class="form-control" name="ams_min_no_entries" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['ams_min_no_entries']; }?>" >

							</div>

							<div class="form-group  col-sm-3">
								<label><strong>Fee:</strong></label>
								<input type="text" class="form-control" name="ams_fee" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['ams_fee']; }?>" >
							</div>
							<div class="form-group  col-sm-3">
								<label class="ven-01"><strong>Venue:</strong></label>
								<select id="Venue" class="browser-default custom-select" name="ams_venue">
									<option value="" selected><strong>Select</strong></option>
									<option value="venue1" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['ams_venue'] == 'venue1' ) echo 'selected' ; }?> ><strong>Venue - 01</strong></option>
									<option value="venue2" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['ams_venue'] == 'venue2' ) echo 'selected' ; }?> ><strong>Venue - 02</strong></option>
									<option value="venue3" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['ams_venue'] == 'venue3' ) echo 'selected' ; }?> ><strong>Venue - 03</strong></option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12"><label class="ven-01"><strong>Select Category:</strong></label></div>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<?php
												$ams21_style="";$ams21_id1="0";$ams25_style="";$ams25_id1="0";$ams35_style="";$ams35_id1="0";$ams45_style="";$ams45_id1="0";$amsAdults_style="";$amsAdults_id1="0";
												if(isset($play_tournaments)){
													$categories=explode(",",$play_tournaments[0]['ams_categories']);
													foreach($categories as $key=>$value){
														if($value=="AMS-21"){
															$ams21_style="background-color:#33b5e5";
															$ams21_id1="1";
														}
														if($value=="AMS-25"){
															$ams25_style="background-color:#33b5e5";
															$ams25_id1="1";
														}
														if($value=="AMS-35"){
															$ams35_style="background-color:#33b5e5";
															$ams35_id1="1";
														}
														if($value=="AMS-45"){
															$ams45_style="background-color:#33b5e5";
															$ams45_id1="1";
														}
														if($value=="Adults-MALE"){
															$amsAdults_style="background-color:#33b5e5";
															$amsAdults_id1="1";
														}
													}
												}
											?>
											<td><button type="button" id="ams" value="AMS-21" id1="<?php echo $ams21_id1; ?>" class="btn btn-sm black-text px-2 category_btn ams" style="<?php echo $ams21_style; ?>" >AMS-21</button></td>
											<td><button type="button" id="ams" value="AMS-25" id1="<?php echo $ams25_id1; ?>" class="btn btn-sm black-text px-2 category_btn ams" style="<?php echo $ams25_style; ?>" >AMS-25</button></td>
											<td><button type="button" id="ams" value="AMS-35" id1="<?php echo $ams35_id1; ?>" class="btn btn-sm black-text px-2 category_btn ams" style="<?php echo $ams35_style; ?>" >AMS-35</button></td>
											<td><button type="button" id="ams" value="AMS-45" id1="<?php echo $ams45_id1; ?>" class="btn btn-sm black-text px-2 category_btn ams" style="<?php echo $ams45_style; ?>" >AMS-45</button></td>
											<td><button type="button" id="ams" value="Adults-MALE" id1="<?php echo $amsAdults_id1; ?>" class="btn btn-sm black-text px-2 category_btn ams" style="<?php echo $amsAdults_style; ?>" >Adults-MALE</button></td>
											<td><button type="button" id="ams" class="btn btn-sm btn-default px-2 clear_category_btn">Clear Categories</button></td>
										</tr>
									</tbody>
								</table>
							</div>
							<input type="hidden" name="ams_categories" id="ams_categories" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['ams_categories']; }?>" />
						</div>
						<hr>
						<!----------------------------------8th-Card---------------------------------->

						<h5 style="color: rgb(192, 96, 96)"><strong>Adults Female Single:</strong></h5>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-3">
								<label><strong>Reporting Time:</strong></label>
								<input type="text" class="form-control time" name="afs_reporting_time" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['afs_reporting_time']; }?>">

							</div>

							<div class="form-group col-sm-3">
								<label><strong>Min No of Entries:</strong></label>
								<input type="text" class="form-control" name="afs_min_no_entries" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['afs_min_no_entries']; }?>" >

							</div>

							<div class="form-group  col-sm-3">
								<label><strong>Fee:</strong></label>
								<input type="text" class="form-control" name="afs_fee" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['afs_fee']; }?>" >
							</div>
							<div class="form-group  col-sm-3">
								<label class="ven-01"><strong>Venue:</strong></label>
								<select id="Venue" class="browser-default custom-select" name="afs_venue">
									<option value="" selected><strong>Select</strong></option>
									<option value="venue1" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['afs_venue'] == 'venue1' ) echo 'selected' ; }?> ><strong>Venue - 01</strong></option>
									<option value="venue2" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['afs_venue'] == 'venue2' ) echo 'selected' ; }?> ><strong>Venue - 02</strong></option>
									<option value="venue3" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['afs_venue'] == 'venue3' ) echo 'selected' ; }?> ><strong>Venue - 03</strong></option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12"><label class="ven-01"><strong>Select Category:</strong></label></div>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<?php
												$afs21_style="";$afs21_id1="0";$afs25_style="";$afs25_id1="0";$afs35_style="";$afs35_id1="0";$afs45_style="";$afs45_id1="0";$afsAdults_style="";$afsAdults_id1="0";
												if(isset($play_tournaments)){
													$categories=explode(",",$play_tournaments[0]['afs_categories']);
													foreach($categories as $key=>$value){
														if($value=="AFS-21"){
															$afs21_style="background-color:#33b5e5";
															$afs21_id1="1";
														}
														if($value=="AFS-25"){
															$afs25_style="background-color:#33b5e5";
															$afs25_id1="1";
														}
														if($value=="AFS-35"){
															$afs35_style="background-color:#33b5e5";
															$afs35_id1="1";
														}
														if($value=="AFS-45"){
															$afs45_style="background-color:#33b5e5";
															$afs45_id1="1";
														}
														if($value=="Adults-MALE"){
															$afsAdults_style="background-color:#33b5e5";
															$afsAdults_id1="1";
														}
													}
												}
											?>
											<td><button type="button" id="afs" value="AFS-21" id1="<?php echo $afs21_id1; ?>" class="btn btn-sm black-text px-2 category_btn afs" style="<?php echo $afs21_style; ?>" >AFS-21</button></td>
											<td><button type="button" id="afs" value="AFS-25" id1="<?php echo $afs25_id1; ?>" class="btn btn-sm black-text px-2 category_btn afs" style="<?php echo $afs25_style; ?>" >AFS-25</button></td>
											<td><button type="button" id="afs" value="AFS-35" id1="<?php echo $afs35_id1; ?>" class="btn btn-sm black-text px-2 category_btn afs" style="<?php echo $afs35_style; ?>" >AFS-35</button></td>
											<td><button type="button" id="afs" value="AFS-45" id1="<?php echo $afs45_id1; ?>" class="btn btn-sm black-text px-2 category_btn afs" style="<?php echo $afs45_style; ?>" >AFS-45</button></td>
											<td><button type="button" id="afs" value="Adults-FEMALE" id1="<?php echo $afsAdults_id1; ?>" class="btn btn-sm black-text px-2 category_btn afs" style="<?php echo $afsAdults_style; ?>" >Adults-FEMALE</button></td>
											<td><button type="button" id="afs" class="btn btn-sm btn-default px-2 clear_category_btn">Clear Categories</button></td>
										</tr>
									</tbody>
								</table>
							</div>
							<input type="hidden" name="afs_categories" id="afs_categories" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['afs_categories']; }?>" />
						</div>
						<hr>
						<!---------------------------------9th Card-------------------------------->

						<h5 style="color: rgb(192, 96, 96)"><strong>Mixed Single:</strong></h5>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-3">
								<label><strong>Reporting Time:</strong></label>
								<input type="text" class="form-control time" name="ms_reporting_time" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['ms_reporting_time']; }?>">

							</div>

							<div class="form-group col-sm-3">
								<label><strong>Min No of Entries:</strong></label>
								<input type="text" class="form-control" name="ms_min_no_entries" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['ms_min_no_entries']; }?>" >

							</div>

							<div class="form-group  col-sm-3">
								<label><strong>Fee:</strong></label>
								<input type="text" class="form-control" name="ms_fee" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['ms_fee']; }?>" >
							</div>
							<div class="form-group  col-sm-3">
								<label class="ven-01"><strong>Venue:</strong></label>
								<select id="Venue" class="browser-default custom-select" name="ms_venue">
									<option value="" selected><strong>Select</strong></option>
									<option value="venue1" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['ms_venue'] == 'venue1' ) echo 'selected' ; }?> ><strong>Venue - 01</strong></option>
									<option value="venue2" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['ms_venue'] == 'venue2' ) echo 'selected' ; }?> ><strong>Venue - 02</strong></option>
									<option value="venue3" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['ms_venue'] == 'venue3' ) echo 'selected' ; }?> ><strong>Venue - 03</strong></option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12"><label class="ven-01"><strong>Select Category:</strong></label></div>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<?php
												$ms08_style="";$ms08_id1="0";$ms09_style="";$ms09_id1="0";$ms10_style="";$ms10_id1="0";$ms11_style="";$ms11_id1="0";$ms13_style="";$ms13_id1="0";$ms15_style="";$ms15_id1="0";$ms17_style="";$ms17_id1="0";$ms19_style="";$ms19_id1="0";$ms21_style="";$ms21_id1="0";$ms25_style="";$ms25_id1="0";$ms35_style="";$ms35_id1="0";$ms45_style="";$ms45_id1="0";;
												if(isset($play_tournaments)){
													$categories=explode(",",$play_tournaments[0]['ms_categories']);
													foreach($categories as $key=>$value){
														if($value=="MS-08"){
															$ms08_style="background-color:#33b5e5";
															$ms08_id1="1";
														}
														if($value=="MS-09"){
															$ms09_style="background-color:#33b5e5";
															$ms09_id1="1";
														}
														if($value=="MS-10"){
															$ms10_style="background-color:#33b5e5";
															$ms10_id1="1";
														}
														if($value=="MS-11"){
															$ms11_style="background-color:#33b5e5";
															$ms11_id1="1";
														}
														if($value=="MS-13"){
															$ms13_style="background-color:#33b5e5";
															$ms13_id1="1";
														}
														if($value=="MS-15"){
															$ms15_style="background-color:#33b5e5";
															$ms15_id1="1";
														}
														if($value=="MS-17"){
															$ms17_style="background-color:#33b5e5";
															$ms17_id1="1";
														}
														if($value=="MS-19"){
															$ms19_style="background-color:#33b5e5";
															$ms19_id1="1";
														}
														if($value=="MS-21"){
															$ms21_style="background-color:#33b5e5";
															$ms21_id1="1";
														}
														if($value=="MS-25"){
															$ms25_style="background-color:#33b5e5";
															$ms25_id1="1";
														}
														if($value=="MS-35"){
															$ms35_style="background-color:#33b5e5";
															$ms35_id1="1";
														}
														if($value=="MS-45"){
															$ms45_style="background-color:#33b5e5";
															$ms45_id1="1";
														}
													}
												}
											?>
											<td><button type="button" id="ms" value="MS-08" id1="<?php echo $ms08_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms08_style; ?>" >MS-08</button></td>
											<td><button type="button" id="ms" value="MS-09" id1="<?php echo $ms09_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms09_style; ?>" >MS-09</button></td>
											<td><button type="button" id="ms" value="MS-10" id1="<?php echo $ms10_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms10_style; ?>" >MS-10</button></td>
											<td><button type="button" id="ms" value="MS-11" id1="<?php echo $ms11_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms11_style; ?>" >MS-11</button></td>
											<td><button type="button" id="ms" value="MS-13" id1="<?php echo $ms13_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms13_style; ?>" >MS-13</button></td>
											<td><button type="button" id="ms" value="MS-15" id1="<?php echo $ms15_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms15_style; ?>" >MS-15</button></td>
											<td><button type="button" id="ms" value="MS-17" id1="<?php echo $ms17_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms17_style; ?>" >MS-17</button></td>
											<td><button type="button" id="ms" value="MS-19" id1="<?php echo $ms19_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms19_style; ?>" >MS-19</button></td>
											<td><button type="button" id="ms" value="MS-21" id1="<?php echo $ms21_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms21_style; ?>" >MS-21</button></td>
											<td><button type="button" id="ms" value="MS-25" id1="<?php echo $ms25_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms25_style; ?>" >MS-25</button></td>
											<td><button type="button" id="ms" value="MS-35" id1="<?php echo $ms35_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms35_style; ?>" >MS-35</button></td>
											<td><button type="button" id="ms" value="MS-45" id1="<?php echo $ms45_id1; ?>" class="btn btn-sm black-text px-2 category_btn ms" style="<?php echo $ms45_style; ?>" >MS-45</button></td>
											<td><button type="button" id="ms" class="btn btn-sm btn-default px-2 clear_category_btn">Clear Categories</button></td>
										</tr>
									</tbody>
								</table>
							</div>
							<input type="hidden" name="ms_categories" id="ms_categories" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['ms_categories']; }?>" >
						</div>
						<hr>
						<!-----------------------------------10TH-CARD------------------------------->

						<h5 style="color: rgb(192, 96, 96)"><strong>Mixed Double:</strong></h5>
						<hr>
						<div class="form-row">
							<div class="form-group col-sm-3">
								<label><strong>Reporting Time:</strong></label>
								<input type="text" class="form-control time" name="md_reporting_time" placeholder="HH:MM:SS" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['md_reporting_time']; }?>">

							</div>

							<div class="form-group col-sm-3">
								<label><strong>Min No of Entries:</strong></label>
								<input type="text" class="form-control" name="md_min_no_entries" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['md_min_no_entries']; }?>" >

							</div>

							<div class="form-group  col-sm-3">
								<label><strong>Fee:</strong></label>
								<input type="text" class="form-control" name="md_fee" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['md_fee']; }?>" >
							</div>
							<div class="form-group  col-sm-3">
								<label class="ven-01"><strong>Venue:</strong></label>
								<select id="Venue" class="browser-default custom-select" name="md_venue">
									<option value="" selected><strong>Select</strong></option>
									<option value="venue1" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['md_venue'] == 'venue1' ) echo 'selected' ; }?> ><strong>Venue - 01</strong></option>
									<option value="venue2" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['md_venue'] == 'venue2' ) echo 'selected' ; }?> ><strong>Venue - 02</strong></option>
									<option value="venue3" <?php if (isset($play_tournaments)){if ($play_tournaments[0]['md_venue'] == 'venue3' ) echo 'selected' ; }?> ><strong>Venue - 03</strong></option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12"><label class="ven-01"><strong>Select Category:</strong></label></div>
							<div class="table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<?php
												$md08_style="";$md08_id1="0";$md09_style="";$md09_id1="0";$md10_style="";$md10_id1="0";$md11_style="";$md11_id1="0";$md13_style="";$md13_id1="0";$md15_style="";$md15_id1="0";$md17_style="";$md17_id1="0";$md19_style="";$md19_id1="0";$md21_style="";$md21_id1="0";$md25_style="";$md25_id1="0";$md35_style="";$md35_id1="0";$md45_style="";$md45_id1="0";;
												if(isset($play_tournaments)){
													$categories=explode(",",$play_tournaments[0]['md_categories']);
													foreach($categories as $key=>$value){
														if($value=="MD-08"){
															$md08_style="background-color:#33b5e5";
															$md08_id1="1";
														}
														if($value=="MD-09"){
															$md09_style="background-color:#33b5e5";
															$md09_id1="1";
														}
														if($value=="MD-10"){
															$md10_style="background-color:#33b5e5";
															$md10_id1="1";
														}
														if($value=="MD-11"){
															$md11_style="background-color:#33b5e5";
															$md11_id1="1";
														}
														if($value=="MD-13"){
															$md13_style="background-color:#33b5e5";
															$md13_id1="1";
														}
														if($value=="MD-15"){
															$md15_style="background-color:#33b5e5";
															$md15_id1="1";
														}
														if($value=="MD-17"){
															$md17_style="background-color:#33b5e5";
															$md17_id1="1";
														}
														if($value=="MD-19"){
															$md19_style="background-color:#33b5e5";
															$md19_id1="1";
														}
														if($value=="MD-21"){
															$md21_style="background-color:#33b5e5";
															$md21_id1="1";
														}
														if($value=="MD-25"){
															$md25_style="background-color:#33b5e5";
															$md25_id1="1";
														}
														if($value=="MD-35"){
															$md35_style="background-color:#33b5e5";
															$md35_id1="1";
														}
														if($value=="MD-45"){
															$md45_style="background-color:#33b5e5";
															$md45_id1="1";
														}
													}
												}
											?>
											<td><button type="button" id="md" value="MD-08" id1="<?php echo $md08_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md08_style; ?>" >MD-08</button></td>
											<td><button type="button" id="md" value="MD-09" id1="<?php echo $md09_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md09_style; ?>" >MD-09</button></td>
											<td><button type="button" id="md" value="MD-10" id1="<?php echo $md10_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md10_style; ?>" >MD-10</button></td>
											<td><button type="button" id="md" value="MD-11" id1="<?php echo $md11_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md11_style; ?>" >MD-11</button></td>
											<td><button type="button" id="md" value="MD-13" id1="<?php echo $md13_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md13_style; ?>" >MD-13</button></td>
											<td><button type="button" id="md" value="MD-15" id1="<?php echo $md15_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md15_style; ?>" >MD-15</button></td>
											<td><button type="button" id="md" value="MD-17" id1="<?php echo $md17_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md17_style; ?>" >MD-17</button></td>
											<td><button type="button" id="md" value="MD-19" id1="<?php echo $md19_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md19_style; ?>" >MD-19</button></td>
											<td><button type="button" id="md" value="MD-21" id1="<?php echo $md21_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md21_style; ?>" >MD-21</button></td>
											<td><button type="button" id="md" value="MD-25" id1="<?php echo $md25_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md25_style; ?>" >MD-25</button></td>
											<td><button type="button" id="md" value="MD-35" id1="<?php echo $md35_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md35_style; ?>" >MD-35</button></td>
											<td><button type="button" id="md" value="MD-45" id1="<?php echo $md45_id1; ?>" class="btn btn-sm black-text px-2 category_btn md" style="<?php echo $md45_style; ?>" >MD-45</button></td>
											<td><button type="button" id="md" class="btn btn-sm btn-default px-2 clear_category_btn">Clear Categories</button></td>
										</tr>
									</tbody>
								</table>
							</div>
							<input type="hidden" name="md_categories" id="md_categories" value="<?php if (isset($play_tournaments)){ echo $play_tournaments[0]['md_categories']; }?>" >
						</div>
						<hr>
						<!------------------------------------------BUTTONS------------------------------------->
						<div class="form-row ">
							<!--<div class="form-group col-sm-6">
								<label></label>
								<a href="#" button type="button " class="btn btn-primary-dimpu-02">PREVIEW</button></a>
								<hr />
							</div>-->
							<div class="form-group col-sm-12 text-center">
								<label></label>
								<button type="submit " class="btn btn-default btn-md">SUBMIT</button>
								<hr />
							</div>
						</div>
					</form>
				</div>
				<div class="modal fade " id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
							</div>
							<div class="modal-body">
								<img src="" id="imagepreview" style="width: 570px; height: 464px;" class="img-fluid">
							</div>
						</div>
					</div>
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
	$("#withdrawal_yes").click(function(){
		$("#withdraw_reason").css('display','block');
	});
	$("#withdrawal_no").click(function(){
		$("#withdraw_reason").css('display','none');
	});
	$(".category_btn").click(function(){
		var category_type=$(this).attr('id');
		var value=$(this).val();
		var existing_categories=$("#"+category_type+"_categories").val();
		var clicked_btn=$(this).attr('id1');
		if(existing_categories==""){
			$("#"+category_type+"_categories").val(value);
		}else{
			if(clicked_btn==0){
				$("#"+category_type+"_categories").val(function(){
					return this.value +","+value;
				});
			}
		}
		$(this).attr('id1','1');
		$(this).css('background-color','#33b5e5');
	});
	$(".clear_category_btn").click(function(){
		var category_type=$(this).attr('id');
		$("#"+category_type+"_categories").val("");
		$("."+category_type).css('background-color','white');
		$("."+category_type).attr('id1','0');
	});
	$.ajax({
		type:"post",
		url:"../sportsbook/process/ajax/countriesHandler.php",
		success:function(data){
			$(".country").append(data);
		}
	});
	$(".country").change(function(){
		var countries_id=$(this).val();
		var id=$(this).attr('id');
		$.ajax({
			type:"post",
			url:"../sportsbook/process/ajax/countrywiseStatesHandler.php",
			data:{id:countries_id},
			success:function(data){
				$("#state"+id).html(data);
			}
		});	
	});
	/* $("#myFile").on('change', function() {
		var gal_name=$(this).attr("id1");
		//console.log(gal_name);
        imagesPreview(this, 'div.'+gal_name);
		function imagesPreview(input, placeToInsertImagePreview) {
			if (input.files) {
				var filesAmount = input.files.length;
				for (i = 0; i < filesAmount; i++) {
					var filename=input.files[i]['name'];
					var extension = filename.replace(/^.*\./, '');
					console.log();
					var reader = new FileReader();
						reader.onload = function(event) {
							$("<span class='pip'><img class='imageThumb' src='"+event.target.result+"' title='"+filename+"' width='140' height='140' /><a class='img_close' id='remove'>&times;</a></span>").appendTo(placeToInsertImagePreview);
							$(".img_close").click(function(){
								$(this).parent(".pip").remove();
							});
						}
					reader.readAsDataURL(input.files[i]);
				}
			}
		}
    }); */
});
</script>