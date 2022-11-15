<?php
$config_path=$_SERVER['DOCUMENT_ROOT'];
include_once($config_path.'/msa/sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location:'. $config_path.'/msa/sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$firstname = auth::getCurrentUsername();
$result="";
$no_venues=0;
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getTournamentVenueDetails($id);
	$no_venues=count($play_tournaments);
	//print_r($play_tournaments);
}
if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
}else{
	header("location: t_schedule_details.php");
	exit;
}
if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
	$no_venue=isset($_POST['no_venue']) ? $_POST['no_venue'] : '';
	$i=1;
	if($td_id!=""){
		$k=1;
		while($no_venue>0){
			//$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
			$venue=isset($_POST['venue'.$i.'']) ? $_POST['venue'.$i.''] : '';
			$country=isset($_POST['country'.$i.'']) ? $_POST['country'.$i.''] : '';
			$state=isset($_POST['state'.$i.'']) ? $_POST['state'.$i.''] : '';
			$city=isset($_POST['city'.$i.'']) ? $_POST['city'.$i.''] : '';
			$no_courts=isset($_POST['no_courts'.$i.'']) ? $_POST['no_courts'.$i.''] : '';
			$start_date=isset($_POST['start_date'.$i.'']) ? $_POST['start_date'.$i.''] : '';
			$end_date=isset($_POST['end_date'.$i.'']) ? $_POST['end_date'.$i.''] : '';
			$start_time=isset($_POST['start_time'.$i.'']) ? $_POST['start_time'.$i.''] : '';
			$end_time=isset($_POST['end_time'.$i.'']) ? $_POST['end_time'.$i.''] : '';
			$result=$account->setVenues($t_id,$i,$venue,$country,$state,$city,$no_courts,$start_date,$end_date,$start_time,$end_time,$td_id); 
			//$j=1;
			$venues_id=$result['venues_id'];
			while($no_courts>0){
				//$court_name=isset($_POST['court_name'.$i.''.$j.'']) ? $_POST['court_name'.$i.''.$j.''] : '';
				//$address=isset($_POST['address'.$i.''.$j.'']) ? $_POST['address'.$i.''.$j.''] : '';
				$court_name="c".$k;
				$account->setCourts($court_name,$venues_id);
				$no_courts--;
				//$j++;
				$k++;
			}
			$no_venue--;
			$i++;
		}
	}
	if($result['t_id']!=""){
		$account->sendEmailAndNotification($result['t_id']);
		unset($_SESSION["td_id"]);
		header("location: index.php");
		exit;
	}else{
		$_SESSION["td_id"] = $td_id;
		header("location: t_travel_lunch_time.php");
		exit;
	}
}
$user_details=$account->getUsers();
$category_types=$account->getTournamentCategoryTypes();
$mins=$account->getMatchTime($td_id);
//echo $mins;
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
					<?php /* if($result!=""){
							echo $result;
						}  */
					?>
					<h3 class="text-center text-default"><strong>Tournament Registration Form</strong></h3>
					<hr />
					<form method="post" action="t_venue_details.php" id="form1" enctype="multipart/form-data">
						<?php if (isset($_GET['id'])){ ?>
							<h5 class="h5-responsive text-danger">You can edit only date and time *</h5>
							<input type="hidden" class="form-control" name="t_id" value="<?php echo $id; ?>" />
							<div class="form-row">
								<span class="form-group col-md-12">
									<label for="no_venue" class="d-inline">Number of Venues: </label>
									<input type="text" class="form-control" name="no_venue" id="no_venue" min="1" max="3" value="<?php echo $no_venues; ?>" disabled />
									<input type="hidden" class="form-control" name="no_venue" min="1" max="3" value="<?php echo $no_venues; ?>" />
								</span>
							</div>
							<div id="venue_details">
								<?php $i=1;foreach($play_tournaments as $key=>$value){ ?>
								<div class="form-row">
									<div class="form-group col-md-12">
										<h5 class="deepa-6">Venue<?php echo $i; ?>:</h5>
									</div>
									<div class="form-group col-md-3  col-sm-3">
										<label>Tournament Venue - 0<?php echo $i; ?>:</label>
										<input type="text" class="form-control" name="venue<?php echo $i; ?>" id="venue<?php echo $i; ?>" value="<?php echo $value['venue_name']; ?>" disabled />
									</div>
									<div class="form-group col-md-9 col-sm-9">
										<label>Address of Venue - 0<?php echo $i; ?>:</label>
										<div class="form-group row">
											<div class="col-md-4">
												<select class="browser-default custom-select country my-2" name="country<?php echo $i; ?>" id="<?php echo $i; ?>"><option value="<?php echo $value['country']; ?>" disabled selected ><?php echo $value['country']; ?></option></select>
											</div>
											<div class="col-md-4">
												<select class="browser-default custom-select state my-2" name="state<?php echo $i; ?>" id="state<?php echo $i; ?>"><option value="<?php echo $value['state']; ?>" disabled selected><?php echo $value['state']; ?></option></select>
											</div>
											<div class="col-md-4">
												<input type="text" class="form-control" id="city<?php echo $i; ?>" name="city<?php echo $i; ?>" placeholder="City" value="<?php echo $value['city']; ?>" disabled>
											</div>
										</div>
									</div>
									<div class="form-group col-md-3">	
										<label>Venue - 0<?php echo $i; ?>, Start Date :</label>
										<input type="text" class="form-control date" name="start_date<?php echo $i; ?>" id="start_date<?php echo $i; ?>" autocomplete="off" value="<?php echo $value['start_date']; ?>" /><hr />
									</div>
									<div class="form-group col-md-3">
										<label>Venue - 0<?php echo $i; ?>, Start Time:</label>
										<input type="time" name="start_time<?php echo $i; ?>"  class="form-control timepicker2" id="start_time<?php echo $i; ?>" value="<?php echo $value['start_time']; ?>"><hr />
									</div>
									<div class="form-group col-md-3">
										<label>Venue - 0<?php echo $i; ?>, End Date:</label>
										<input type="text" class="form-control date" name="end_date<?php echo $i; ?>" id="end_date<?php echo $i; ?>" autocomplete="off" value="<?php echo $value['end_date']; ?>" /><hr />
									</div>
									<div class="form-group col-md-3">
										<label>Venue - 0<?php echo $i; ?>, End Time:</label>
										<input type="time" name="end_time<?php echo $i; ?>"  class="form-control timepicker2" id="end_time<?php echo $i; ?>" value="<?php echo $value['end_time']; ?>"><hr />
									</div>
									<div class="form-group col-md-12">
										<label>No of Courts in Venue - 0<?php echo $i; ?>:</label>
										<input type="number" class="form-control no_courts" name="no_courts<?php echo $i; ?>" id="no_courts<?php echo $i; ?>" min="1" value="<?php echo $value['no_courts']; ?>" disabled />
									</div>
								</div>
								<?php $i++;} ?>
							</div>
						<?php }else{ ?>
							<h3 class="deepa-6"><strong>Venue Details:</strong></h3>
							<div class="form-row">
								<span class="form-group col-md-12">
									<label for="no_venue" class="d-inline">Number of Venues: </label>
									<input type="number" class="form-control" name="no_venue" id="no_venue" min="1" max="3"/>
								</span>
							</div>
							<div id="venue_details"></div>
						<?php } ?>
						<div class="row">
							<div class="offset-md-10 col-md-2"><input id="submit" type="button" data-toggle="modal" data-target="#cal" title="Travel & Lunch Time" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
						</div>
						<div class="modal fade" id="cal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-body msg">
									
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary btn-sm">Save</button>
									</div>
								</div>
							</div>
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

<script>
$(function(){
	$('#submit').click(function(){
		var no_venues=$('#no_venue').val();
		var mins='<?php echo $mins; ?>';
		var msg='As per your entry, ';
		var i=1;
		while(no_venues>0){
			var start_date=new Date($('#start_date'+i).val());
			var end_date=new Date($('#end_date'+i).val());
			var diff  = new Date(end_date - start_date);  
			var no_days  = (diff/1000/60/60/24)+1;  
			var start_time=$('#start_time'+i).val();
			var end_time=$('#end_time'+i).val();
			var time_diff = ( new Date("1-1-1970 " + end_time) - new Date("1-1-1970 " + start_time) ) / 1000 / 60 / 60;  
			var no_courts=$('#no_courts'+i).val();
			var total_no_matches=Math.ceil(((no_days*time_diff*no_courts)*60)/mins);
			var total_no_players=total_no_matches+1;
			msg+='in venue'+i+' '+total_no_players+' players can be registerd. ';
			no_venues--;
			i++;
		}
		msg+='If you want more players to be registered on your tournament, <span class="red-text">Tournament End date</span> needs to extended or <span class="red-text">Tournament End Time</span> needs to extended or more <span class="red-text">number of courts</span> need to be added';
		$('.msg').html(msg);
	});
	$("#no_venue").on('keyup change',function(){
		var venues="";
		var no_venues=$(this).val();
		if(no_venues>3){
			alert("Please enter the number below 4");
			return false;
		}
		var i=1;
		while(no_venues>0){
			venues+='<div class="form-row"><div class="form-group col-md-12"><h5 class="deepa-6">Venue'+i+':</h5></div><div class="form-group col-md-3 col-sm-3"><label>Tournament Venue - 0'+i+':</label><input type="text" class="form-control" name="venue'+i+'" id="venue'+i+'"/></div><div class="form-group col-md-9 col-sm-9"><label>Address of Venue - 0'+i+':</label><div class="form-group row"><div class="col-md-4"><select class="browser-default custom-select country my-2" name="country'+i+'" id="'+i+'"><option value="" disabled selected >Select country</option></select></div><div class="col-md-4"><select class="browser-default custom-select state my-2" name="state'+i+'" id="state'+i+'"><option value="" disabled selected>Select state</option></select></div><div class="col-md-4"><input type="text" class="form-control" id="city'+i+'" name="city'+i+'" placeholder="City" value="" ></div></div></div><div class="form-group col-md-3"><label>Venue - 0'+i+', Start Date :</label><input type="text" class="form-control date" name="start_date'+i+'" autocomplete="off" value="" id="start_date'+i+'"/></div><div class="form-group col-md-3"><label>Venue - 0'+i+', Start Time:</label><input type="time" name="start_time'+i+'"  class="form-control" id="start_time'+i+'" value=""></div><div class="form-group col-md-3"><label>Venue - 0'+i+', End Date:</label><input type="text" class="form-control date" name="end_date'+i+'" autocomplete="off" value="" id="end_date'+i+'"/></div><div class="form-group col-md-3"><label>Venue - 0'+i+', End Time:</label><input type="time" name="end_time'+i+'"  class="form-control" id="end_time'+i+'" value=""></div><div class="col-md-12"><label>No of Courts in Venue - 0'+i+':</label><input type="number" class="form-control no_courts" name="no_courts'+i+'" id="no_courts'+i+'" id1="'+i+'" min="1" /></div><div class="row" id="no_court'+i+'"></div></div><hr />';
			no_venues--;
			i++;
		}
		$("#venue_details").html(venues);
		//for country and state
		$.ajax({
			type:"post",
			url:"../sportsbook/process/ajax/countriesHandler.php",
			success:function(data){
				$(".country").append(data);
			}
		});
		$(".date" ).datepicker({
			changeMonth:true,
			changeYear:true,
			dateFormat: 'yy-mm-dd',
			yearRange: '1970:2020',
		});	
	});
	$(".date" ).datepicker({
		changeMonth:true,
		changeYear:true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1970:2020',
	});	
});
$(document).on('change','.country',function(){
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
/* $(document).on('keyup','.no_courts',function(){
	var no_courts=$(this).val();
	var id=$(this).attr('id1');
	var courts="";
	var i=1;
	while(no_courts>0){
		courts+='<div class="col-md-6"><label>Court Name'+i+':</label><input type="text" class="form-control" name="court_name'+id+i+'"></div><div class="col-md-6"><label>Address'+i+':</label><input type="text" class="form-control" name="address'+id+i+'"></div>';
		no_courts--;
		i++;
	}
	//alert(courts);
	$("#no_court"+id).html(courts);
}); */
</script>