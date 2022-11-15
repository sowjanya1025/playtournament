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
	//echo $td_id;
	//exit;
}else{
	header("location: t_schedule_details.php");
	exit;
} 
//$_SESSION["td_id"]=130;
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getTournamentUPIDetails($id);
	//print_r($play_tournaments);
	//exit; 
	
	//print_r($play_tournaments);
	//$no_umpires=count($play_tournaments);
}
//$categories=$account->getCategories();
//$no_courts=$account->getNoCourts($td_id);
if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : ''; // posted from edit form - tournament_details_id
	if($td_id!=""){ //  tournament id from session
	
		$gpay=isset($_POST['gpay_num']) ? $_POST['gpay_num'] : '';
		$phonepay=isset($_POST['phonepay_num']) ? $_POST['phonepay_num'] : '';
		$upiid=isset($_POST['upiid_num']) ? $_POST['upiid_num'] : '';
		$image=isset($_FILES['qrcode']['name']) ? $_FILES['qrcode']['name'] : '';
		$newfilename="";
		if($image!=""){
			$allowedExts = array("jpg", "jpeg", "png");
			$extension = pathinfo($image, PATHINFO_EXTENSION);
			if(in_array($extension, $allowedExts)){
				$temp = explode(".", $image);
				$newfilename = 'qr'.$accountId.'Tournament'.rand().'.'.end($temp);
				move_uploaded_file($_FILES["qrcode"]["tmp_name"],"images/" . $newfilename);
			}
		}

	}
		$result=$account->setTournamentUPIDetails($td_id,$gpay,$phonepay,$upiid,$newfilename,$t_id); 
	
	if(isset($_SESSION["td_id"])){
		header("location: t_watsapp_link.php");
	}else{
		unset($_SESSION["td_id"]);
		header("location: index.php");
		exit;
	}
	//unset($_SESSION["td_id"]);
	/* header("location: index.php");
	exit; */ 
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
				<?php if(isset($_GET['id']) && !empty($play_tournaments)){ ?>
				<div class="col-md-10 box-2">
					<h3 class="text-center text-default"><strong>Tournament Registration Forms</strong></h3>
					<form method="post" action="t_upiID_details.php" id="form1" enctype="multipart/form-data">
						<input type="hidden" class="form-control" name="t_id" value="<?php echo $id; ?>" />
							<h3 class="deepa-6"><strong>Tournament Organizer Payment Details:</strong></h3>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="hotel1" class="col-sm-10 control-label">GPay Number:</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" name="gpay_num" id="gpay_num" placeholder="GpayNumber" value="<?php echo $play_tournaments[0]['gpay_number']; ?>" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hotel2" class="col-sm-10 control-label">PhonePe Number:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="phonepay_num" id="phonepay_num" placeholder="PhonePayNumber"  value="<?php echo $play_tournaments[0]['phonepay_number']; ?>" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hotel2" class="col-sm-10 control-label">UPI ID:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="upiid_num" id="upiid_num" placeholder="Upi ID" value="<?php echo $play_tournaments[0]['upi_id']; ?>" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hotel3" class="col-sm-10 control-label">Upload QRCode:</label>
									<div class="col-sm-10">
									<img src="images/<?php echo $play_tournaments[0]['qrcode']; ?>" alt="QRCode" height="42" width="42">
										<input type="hidden" id="" name="qrcode" value="<?php echo $play_tournaments[0]['qrcode']; ?>" />
									<input type="file" name="qrcode" id="qrcode"  />
									</div>
								</div>
							</div>
							
							
						
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
				<?php }  else { ?>
				
				
				
				<div class="col-md-10 box-2">
					<h3 class="text-center text-default"><strong>Tournament Registration Form</strong></h3>
					<form method="post" action="t_upiID_details.php" id="form1" enctype="multipart/form-data">
						
							<h3 class="deepa-6"><strong>Tournament Organizer Payment Details:</strong></h3>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="hotel1" class="col-sm-10 control-label">GPay Number:</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" name="gpay_num" id="gpay_num" placeholder="GpayNumber" value="" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hotel2" class="col-sm-10 control-label">PhonePe Number:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="phonepay_num" id="phonepay_num" placeholder="PhonePayNumber" value="" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hotel2" class="col-sm-10 control-label">UPI ID:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="upiid_num" id="upiid_num" placeholder="Upi ID" value="" />
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="hotel3" class="col-sm-10 control-label">Upload QRCode:</label>
									<div class="col-sm-10">
									<input type="file" name="qrcode" id="qrcode"  />
									</div>
								</div>
							</div>
							
							
						
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
				</div> <?php } ?>
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