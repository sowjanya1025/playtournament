<?php
$config_path=$_SERVER['DOCUMENT_ROOT'];
include_once($config_path.'/msa/sportsbook/views/sub-views/pt_header.php'); 
//include_once('../sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
     header('Location:'. $config_path.'/msa/sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$firstname = auth::getCurrentUsername();
$result="";
$id=0;
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getTournamentScheduleDetails($id);
	//print_r($play_tournaments);
}
$status='';
if(isset($_GET['status'])){
	$status=$_GET['status'];
}
if(!empty($_POST)){
	//echo "entering";
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
	$status=isset($_POST['status']) ? $_POST['status'] : '';
	$sports_type=isset($_POST['sports_type']) ? $_POST['sports_type'] : '';
	$tournament_name=isset($_POST['tournament_name']) ? $_POST['tournament_name'] : '';
	$management_name=isset($_POST['management_name']) ? $_POST['management_name'] : '';
	$t_start_date=isset($_POST['t_start_date']) ? $_POST['t_start_date'] : '';
	$t_end_date=isset($_POST['t_end_date']) ? $_POST['t_end_date'] : '';
	$entry_start_date=isset($_POST['entry_start_date']) ? $_POST['entry_start_date'] : '';
	$entry_end_date=isset($_POST['entry_end_date']) ? $_POST['entry_end_date'] : '';
	$entry_close_time=isset($_POST['entry_close_time']) ? $_POST['entry_close_time'] : '';
	$is_withdrawable=isset($_POST['is_withdrawable']) ? $_POST['is_withdrawable'] : '';
	$withdraw_reason=isset($_POST['withdraw_reason']) ? $_POST['withdraw_reason'] : '';
	$result=$account->setTournamentDetails($t_id,$sports_type,$tournament_name,$management_name,$t_start_date,$t_end_date,$entry_start_date,$entry_end_date,$entry_close_time,$is_withdrawable,$withdraw_reason);  
	if($result['t_id']!=""){
		session_start();
		$t_id=$result['t_id'];
		$_SESSION["td_id"] = $t_id;
		if($status!="" && $status==0){
			header("location: t_format_details.php?id=$t_id&status=$status");
		}else{
			header("location: t_venue_details.php?id=$t_id");
		}
		exit;
	}else{
		session_start();
		$_SESSION["td_id"] = $result['td_id'];
		header("location: t_format_details.php");
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
					<hr />
					<form method="post" action="t_schedule_details.php" id="form1" enctype="multipart/form-data">
						<div class="form-row">
							<?php if(isset($_GET['id'])){ ?>
								<div class="col-md-12">
									<h5 class="h5-responsive" style="color: #4caf50"><strong>Tournament Detail:</strong></h5>
								</div>
								<?php if(!isset($_GET['status'])){?>
									<div class="col-md-12">
										<h6 class="h6-responsive text-danger">You can edit only date and time *</h6>
									</div>
								<?php } ?>
								<input type="hidden" class="form-control" name="t_id" value="<?php echo $id; ?>" />
								<input type="hidden" class="form-control" name="status" value="<?php echo $status; ?>" />
								<div class="form-group col-sm-12">
									<label>Sports Type:</label>
									<select class="browser-default custom-select sports_type" name="sports_type" id="sports_type" required>
										<option value="<?php echo $play_tournaments[0]['sports_type']; ?>" selected ><?php echo$play_tournaments[0]['sports_name']; ?></option>
									</select>
									<hr />
								</div>
								<?php if(!isset($_GET['status'])){ ?>
									<div class="form-group col-sm-6">
										<label>Tournament Name:</label>
										<input type="text" class="form-control" name="tournament_name" value="<?php echo $play_tournaments[0]['tournament_name']; ?>" readonly />
										<hr />
									</div>
									<div class="form-group col-sm-6">
										<label>Tournament Management Name:</label>
										<input type="text" class="form-control" name="management_name"  required value="<?php echo $play_tournaments[0]['management_name']; ?>" readonly />
										<hr />
									</div>
								<?php }else{ ?>
									<div class="form-group col-sm-6">
										<label>Tournament Name:</label>
										<input type="text" class="form-control" name="tournament_name" value="<?php echo $play_tournaments[0]['tournament_name']; ?>" />
										<hr />
									</div>
									<div class="form-group col-sm-6">
										<label>Tournament Management Name:</label>
										<input type="text" class="form-control" name="management_name"  required value="<?php echo $play_tournaments[0]['management_name']; ?>" />
										<hr />
									</div>
								<?php } ?>
								<div class="form-group col-sm-2">
									<label>Tournament Start Date:</label>
									<input type="text" class="form-control date" name="t_start_date" id="start_date" autocomplete="off" value="<?php echo $play_tournaments[0]['t_start_date']; ?>" required />
								</div>
								<div class="form-group col-sm-2">
									<label>Tournament End Date:</label>
									<input type="text" class="form-control date" name="t_end_date" id="end_date" autocomplete="off" value="<?php echo $play_tournaments[0]['t_end_date']; ?>" required />
								</div>
								<div class="form-group col-sm-2">
									<label>Registration Start Date:</label>
									<input type="text" class="form-control date" name="entry_start_date" id="entry_start_date" autocomplete="off" value="<?php echo $play_tournaments[0]['entry_start_date']; ?>" required />
								</div>
								<div class="form-group col-sm-2">
									<label>Registration End Date:</label>
									<input type="text" class="form-control date" name="entry_end_date" id="entry_end_date" autocomplete="off" value="<?php echo $play_tournaments[0]['entry_end_date']; ?>" required />
								</div>
								<div class="form-group col-sm-4">
									<label>Registration Close Time<span class="red-text"></span>:</label>
									<input type="time" name="entry_close_time"  class="form-control " id="entry_close_time" autocomplete="off" value="<?php echo $play_tournaments[0]['entry_close_time']; ?>" required>
								</div>
								<div class="form-group col-md-12">
									<hr />
									<p>Withdrawal Option [ <span class="red-text">Player can withdraw only before the tournament entry end date*</span> ]:</p>
									<?php if(!isset($_GET['status'])){ ?>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="withdrawal_yes" value="yes" name="is_withdrawable" <?php echo ($play_tournaments[0]['is_withdrawable']== 'yes') ?  "checked" : "checked" ; ?>  required  >
											<label class="custom-control-label" for="withdrawal_yes">Yes</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="withdrawal_no" value="no" name="is_withdrawable" <?php echo ($play_tournaments[0]['is_withdrawable']== 'no') ?  "checked" : "checked" ; ?>  required  >
											<label class="custom-control-label" for="withdrawal_no">No</label>
										</div>
									<?php }else{ ?>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="withdrawal_yes" value="yes" name="is_withdrawable" <?php echo ($play_tournaments[0]['is_withdrawable']== 'yes') ?  "checked" : "checked" ; ?>  required>
											<label class="custom-control-label" for="withdrawal_yes">Yes</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" id="withdrawal_no" value="no" name="is_withdrawable" <?php echo ($play_tournaments[0]['is_withdrawable']== 'no') ?  "checked" : "checked" ; ?>  required>
											<label class="custom-control-label" for="withdrawal_no">No</label>
										</div>
									<?php } ?>
									<p id="text" >
										<input type="text" class="form-control" name="withdraw_reason" id="withdraw_reason" placeholder="Reason for withdraw" style="display:none" value="<?php if ($play_tournaments[0]['withdraw_reason']!=""){echo $play_tournaments[0]['withdraw_reason']; } ?>" >
									</p>
								</div>
							<?php }else{ ?>
								<h5 class="deepa-6" style="color: #4caf50"><strong>Tournament Detail:</strong></h5>
								<div class="form-group col-sm-12">
									<label>Sports Type:</label>
									<select class="browser-default custom-select sports_type" name="sports_type" id="sports_type" required>
										<?php $id=""; echo $account->getGames($id); ?>
									</select>
									<span class="red-text" id="sports_type_err"></span>
									<hr />
								</div>
								<div class="form-group col-sm-6">
									<label>Tournament Name:</label>
									<input type="text" class="form-control" name="tournament_name" id="tournament_name" value="" required autocomplete="off" />
									<span class="red-text" id="tournament_name_err"></span>
									<hr />
								</div>
								<div class="form-group col-sm-6">
									<label>Tournament Management Name:</label>
									<input type="text" class="form-control" name="management_name" id="management_name" required value="" autocomplete="off" />
									<span class="red-text" id="management_name_err"></span>
									<hr />
								</div>
								<div class="form-group col-sm-2">
									<label>Tournament Start Date:</label>
									<input type="text" class="form-control date" name="t_start_date" id="start_date" autocomplete="off" value="" required />
									<span class="red-text" id="start_date_err"></span>
								</div>
								<div class="form-group col-sm-2">
									<label>Tournament End Date:</label>
									<input type="text" class="form-control date" name="t_end_date" id="end_date" autocomplete="off" value="" required />
									<span class="red-text" id="end_date_err"></span>
								</div>
								<div class="form-group col-sm-2">
									<label>Registration Start Date:</label>
									<input type="text" class="form-control date" name="entry_start_date" id="entry_start_date" autocomplete="off" value="" required />
									<span class="red-text" id="entry_start_date_err"></span>
								</div>
								<div class="form-group col-sm-2">
									<label>Registration End Date:</label>
									<input type="text" class="form-control date" name="entry_end_date" id="entry_end_date" autocomplete="off" value="" required />
									<span class="red-text" id="entry_end_date_err"></span>
								</div>
								<div class="form-group col-sm-4">
									<label>Registration Close Time<span class="red-text"></span>:</label>
									<input type="time" name="entry_close_time"  class="form-control " id="entry_close_time" autocomplete="off" required>
								</div>
								<div class="form-group col-md-12">
									<hr />
									<p>Withdrawal Option [ <span class="red-text">Player can withdraw only before the tournament entry end date*</span> ]:</p>
									<div class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" id="withdrawal_yes" value="yes" name="is_withdrawable"  required >
										<label class="custom-control-label" for="withdrawal_yes">Yes</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" id="withdrawal_no" value="no" name="is_withdrawable" required >
										<label class="custom-control-label" for="withdrawal_no">No</label>
									</div>
									<p id="text" >
										<input type="text" class="form-control" name="withdraw_reason" id="withdraw_reason" placeholder="Reason for withdraw" style="display:none" value="" >
									</p>
								</div>
							<?php } ?>
						</div>
						<div class="row">
							<?php if(isset($_GET['id']) && !isset($_GET['status'])){ ?>
								<div class="offset-md-10 col-md-2"><input type="submit" title="Venue Details" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
							<?php }else if(isset($_GET['id']) && isset($_GET['status'])){ ?>
								<div class="offset-md-10 col-md-2"><input type="submit" title="Format Details" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
							<?php }else{?>
								<div class="offset-md-10 col-md-2"><input type="button" title="Format details" class="btn btn-sm btn-default text-white" id="save" value="Save & Next"></div>
							<?php } ?>
						</div>
					</form>
				</div>
				<div class="modal fade " id="confirmation" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-body">
								<p id="modal_text"></p>
							</div>
							 <div class="modal-footer">
							 	<button type="button" class="btn btn-default p-2" id='modal_save'>Save</button>
								<button type="button" class="btn btn-info p-2" data-dismiss="modal">Close</button>
							  </div>
						</div>
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

<script>
$(function(){
	 $(".date" ).datepicker({
        changeMonth:true,
        changeYear:true,
		dateFormat: 'yy-mm-dd',
		//yearRange: '1970:'+ new Date().getFullYear().toString()
		yearRange: '+0:+10'
    });	
	$("#withdrawal_yes").click(function(){
		$("#withdraw_reason").css('display','block');
	});
	$("#withdrawal_no").click(function(){
		$("#withdraw_reason").css('display','none');
	});
	$("#save").click(function(){
		var sports_type=$("#sports_type").val();
		var tournament_name=$("#tournament_name").val();
		var management_name=$("#management_name").val();
		var start_date=$("#start_date").val();
		var end_date=$("#end_date").val();
		var entry_start_date=$("#entry_start_date").val();
		var entry_end_date=$("#entry_end_date").val();
		if(sports_type==null || sports_type==""){
			$("#sports_type_err").html("Please enter sports type");
			return false;
		}else if(tournament_name==null || tournament_name==""){
			$("#sports_type_err").html("");
			$("#tournament_name_err").html("Please enter Tournament name");
			return false;
		}else if(management_name==null || management_name==""){
			$("#tournament_name_err").html("");
			$("#management_name_err").html("Please enter Management name");
			return false;
		}else if(start_date==null || start_date==""){
			$("#management_name_err").html("");
			$("#start_date_err").html("Please enter Start date");
			return false;
		}else if(end_date==null || end_date==""){
			$("#start_date_err").html("");
			$("#end_date_err").html("Please enter End date");
			return false;
		}else if(end_date<start_date){
			$("#end_date_err").html("End date should be greater than start date");
			//alert();
		}else if(entry_start_date==null || entry_start_date==""){
			$("#end_date_err").html("");
			$("#entry_start_date_err").html("Please enter Entry start date");
			return false;
		}else if(entry_end_date==null || entry_end_date==""){
			$("#entry_start_date_err").html("");
			$("#entry_end_date_err").html("Please enter Entry end date");
			return false;
		}else if(entry_end_date<entry_start_date){
			$("#entry_end_date_err").html("End date should be greater than start date");
		}else{
			$.ajax({
				type:"post",
				url:"ajax/duplicateTournamentRegistration.php",
				data:{start_date:start_date,end_date:end_date},
				dataType: 'json',
				success:function(data){
					//alert(data);
					if(data[0]!=0){
						$("#modal_text").html(data[1]);
						$('#confirmation').modal('show');
					}else{
						$('#confirmation').modal('hide');
						$("#form1").submit();
					}
				}
			});
		}
	});
	$('#modal_save').click(function(){
		  $("#form1").submit();
	});
});
</script>