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
if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
}else{
	/* header("location: t_schedule_details.php");
	exit; */
}

if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
	$leagues_no_sets=isset($_POST['leagues_no_sets']) ? $_POST['leagues_no_sets'] : '';
	$leagues_points=isset($_POST['leagues_points']) ? $_POST['leagues_points'] : '';
	$quarter_finals_no_sets=isset($_POST['quarter_finals_no_sets']) ? $_POST['quarter_finals_no_sets'] : '';
	$quarter_finals_points=isset($_POST['quarter_finals_points']) ? $_POST['quarter_finals_points'] : '';
	$semifinals_no_sets=isset($_POST['semifinals_no_sets']) ? $_POST['semifinals_no_sets'] : '';
	$semifinals_points=isset($_POST['semifinals_points']) ? $_POST['semifinals_points'] : '';
	$finals_no_sets=isset($_POST['finals_no_sets']) ? $_POST['finals_no_sets'] : '';
	$finals_points=isset($_POST['finals_points']) ? $_POST['finals_points'] : '';
	if($td_id!=""){
		$result=$account->setFormatDetails($leagues_no_sets,$leagues_points,$quarter_finals_no_sets,$quarter_finals_points,$semifinals_no_sets,$semifinals_points,$finals_no_sets,$finals_points,$td_id);  
	} 
	$_SESSION["td_id"] = $result;
	header("location: t_venue_details.php");
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
					<hr />				
					<form method="post" action="t_format_details.php" id="form1" enctype="multipart/form-data">
						<h5 class="deepa-6 "><strong>Knock Out:</strong></h5>
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
						<div class="row">
							<div class="offset-md-10 col-md-2"><input type="submit" title="Venue details" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
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
