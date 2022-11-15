<?php
include_once('../sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location: ../../sportsbook/index.php');
}
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
	$play_tournaments=$account->getTournamentHotelHospitalDetails($id);
	//print_r($play_tournaments);
	$no_umpires=count($play_tournaments);
}
$categories=$account->getCategories();
$no_courts=$account->getNoCourts($td_id);
if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
	if($td_id!=""){
		$hotel1=isset($_POST['hotel1']) ? $_POST['hotel1'] : '';
		$hotel2=isset($_POST['hotel2']) ? $_POST['hotel2'] : '';
		$hotel3=isset($_POST['hotel3']) ? $_POST['hotel3'] : '';
		$hospital1=isset($_POST['hospital1']) ? $_POST['hospital1'] : '';
		$hospital2=isset($_POST['hospital2']) ? $_POST['hospital2'] : '';
		$hospital3=isset($_POST['hospital3']) ? $_POST['hospital3'] : '';
		$result=$account->setHotelHospitalDetails($t_id,$hotel1,$hotel2,$hotel3,$hospital1,$hospital2,$hospital3,$td_id); 
	}
	unset($_SESSION["td_id"]);
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
					<h3 class="text-center text-default"><strong>Tournament Registration Form</strong></h3>
					<form method="post" action="t_hospitals_hotels.php" id="form1" enctype="multipart/form-data">
						<?php if(isset($_GET['id']) && !empty($play_tournaments)){ ?>
							<input type="hidden" class="form-control" name="t_id" value="<?php echo $id; ?>" />
							<h3 class="deepa-6"><strong>Nearby Hotel Details:</strong></h3>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="hotel1" class="col-sm-10 control-label">Hotel name1</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" name="hotel1" id="hotel1" placeholder="Hotel Name1" value="<?php echo $play_tournaments[0]['hotel1']; ?>" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hotel2" class="col-sm-10 control-label">Hotel Name2</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="hotel2" id="hotel2" placeholder="Hotel Name2" value="<?php echo $play_tournaments[0]['hotel2']; ?>" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hotel3" class="col-sm-10 control-label">Hotel Name3</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="hotel3" id="hotel3" placeholder="Hotel Name3" value="<?php echo $play_tournaments[0]['hotel3']; ?>" />
									</div>
								</div>
							</div>
							<h3 class="deepa-6"><strong>Nearby Hospital Details:</strong></h3>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="hospital1" class="col-sm-10 control-label">Hospital name1</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" name="hospital1" id="hospital1" placeholder="Hospital Name1" value="<?php echo $play_tournaments[0]['hospital1']; ?>" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hospital2" class="col-sm-10 control-label">Hospital Name2</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="hospital2" id="hospital2" placeholder="Hospital Name2" value="<?php echo $play_tournaments[0]['hospital2']; ?>" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hospital3" class="col-sm-10 control-label">Hospital Name3</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="hospital3" id="hospital3" placeholder="Hospital Name3" value="<?php echo $play_tournaments[0]['hospital3']; ?>" />
									</div>
								</div>
							</div>
						<?php }else{ ?>
							<h3 class="deepa-6"><strong>Nearby Hotel Details:</strong></h3>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="hotel1" class="col-sm-10 control-label">Hotel name1</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" name="hotel1" id="hotel1" placeholder="Hotel Name1" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hotel2" class="col-sm-10 control-label">Hotel Name2</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="hotel2" id="hotel2" placeholder="Hotel Name2"/>
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hotel3" class="col-sm-10 control-label">Hotel Name3</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="hotel3" id="hotel3" placeholder="Hotel Name3"/>
									</div>
								</div>
							</div>
							<h3 class="deepa-6"><strong>Nearby Hospital Details:</strong></h3>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="hospital1" class="col-sm-10 control-label">Hospital name1</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" name="hospital1" id="hospital1" placeholder="Hospital Name1" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hospital2" class="col-sm-10 control-label">Hospital Name2</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="hospital2" id="hospital2" placeholder="Hospital Name2"/>
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hospital3" class="col-sm-10 control-label">Hospital Name3</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="hospital3" id="hospital3" placeholder="Hospital Name3"/>
									</div>
								</div>
							</div>
						<?php } ?>
						<div class="form-row ">
							<div class="form-group col-sm-12 text-center">
								<button type="button" class="btn btn-default btn-md" id="submit" data-toggle="modal" data-target="#confirm_submit">SUBMIT</button>
								<hr />
							</div>
						</div>
						<?php //} ?>
						<div class="modal fade" id="confirm_submit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-body msg">
										By clicking submit button, the tournament will be hosted to all the players. Are you sure that you want to submit?
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
	$("#no_umpires").change(function(){
		var umpires="";
		var no_umpires=$(this).val();
		var no_courts='<?php echo $no_courts; ?>';
		if(parseInt(no_courts)!=parseInt(no_umpires)){
			$("#umpire_err").html("The number of umpires u have choosen is not equal to the number of courts("+no_courts+") you have selected. Please make sure that the number of umpires is equal to the number of courts");
		}else{
			$("#umpire_err").html("");
		}
		var i=1;
		while(no_umpires>0){
			umpires+='<div class="form-row"><div class="form-group col-md-12"><h5 class="deepa-6">Umpire'+i+':</h5></div><div class="form-group col-md-4"><label for="fullname'+i+'">Full name:</label><input type="text" class="form-control" name="fullname'+i+'" id="fullname'+i+'" /></div><div class="form-group col-md-4"><label for="username'+i+'">Username:</label><input type="text" class="form-control" name="username'+i+'" id="username'+i+'"/></div><div class="form-group col-md-4"><label for="password'+i+'">Password:</label><input type="password" class="form-control" name="password'+i+'" id="password'+i+'"/></div></div>';
			no_umpires--;
			i++;
		}
		$("#umpires_details").html(umpires);
	});
	/* $("#submit").click(function(){
		
	}); */
});

</script>