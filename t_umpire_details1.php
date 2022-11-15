<?php
include_once('../sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location: ../../sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$firstname = auth::getCurrentUsername();
$result="";$no_court=0;$prev_no_umpires=0;
if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
}else{
	header("location: t_schedule_details.php");
	exit;
}
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getTournamentUmpireDetails($id);
	//print_r($play_tournaments);
	if(!empty($play_tournaments)){
		$no_umpires=count($play_tournaments);
		$no_court=$play_tournaments[0]['no_courts'];
	}
}
$categories=$account->getCategories();
$no_courts=$account->getNoCourts($td_id);
//$td_id=97;
if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
	if($td_id!=""){
		$no_umpires1=isset($_POST['no_umpires']) ? $_POST['no_umpires'] : '';
		$prev_no_umpires=isset($_POST['prev_no_umpires']) ? $_POST['prev_no_umpires'] : '';
		$i=1;
		$insert="no";
		if($t_id!="" && $prev_no_umpires!=$no_umpires1){
			$account->delUmpireDetails($t_id);
			$insert="yes";
		}
		while($no_umpires1>0){
			$ump_id=isset($_POST['ump_id'.$i.'']) ? $_POST['ump_id'.$i.''] : '';
			$fullname=isset($_POST['fullname'.$i.'']) ? $_POST['fullname'.$i.''] : '';
			$username=isset($_POST['username'.$i.'']) ? $_POST['username'.$i.''] : '';
			$password=isset($_POST['password'.$i.'']) ? $_POST['password'.$i.''] : '';
			$result=$account->setUmpireDetails($t_id,$ump_id,$fullname,$username,$password,$td_id,$insert); 
			$no_umpires1--;
			$i++;
		}
	}

	if($result['t_id']!=""){
		$t_id=$result['t_id'];
		$_SESSION["td_id"] = $t_id;
		header("location: t_hospitals_hotels.php?id=$t_id");
		exit;
	}else{
		$_SESSION["td_id"] = $result['td_id'];
		header("location: t_hospitals_hotels.php");
		exit;
	}
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
					<form method="post" action="t_umpire_details.php" id="form1" enctype="multipart/form-data">
						<h3 class="deepa-6"><strong>Umpire Details:</strong></h3>
						<hr>
						<?php if(isset($_GET['id']) && !empty($play_tournaments)){ ?>
							<input type="hidden" class="form-control" name="t_id" value="<?php echo $id; ?>" />
							<div class="form-row">
								<span class="form-group col-md-12">
									<label for="no_umpires" class="d-inline">Number of umpires: </label>
									<input type="number" class="form-control" name="no_umpires" id="no_umpires" min="1" max="10" value="<?php echo $no_umpires; ?>" />
									<input type="hidden" class="form-control" name="prev_no_umpires" id="no_umpires" min="1" max="10" value="<?php echo $no_umpires; ?>" />
									<?php if($no_court!=$no_umpires){
										echo '<span class="red-text">Number of umpires not equal to number of courts.Please match the number of umpires to the number of courts</span>';
									}else{
										echo '';
									} ?>							
								</span>
								<span class="form-group col-md-12 text-danger" id="umpire_err"></span>
							</div>
							<div id="umpires_details">
								<?php $i=1;foreach($play_tournaments as $key=>$val){ ?>
									<div class="form-row">
										<div class="form-group col-md-12">
											<h5 class="deepa-6">Umpire<?php echo $i; ?>:</h5>
										</div>
										<input type="hidden" class="form-control" name="ump_id<?php echo $i; ?>" value="<?php echo $val['id']; ?>" />
										<div class="form-group col-md-4">
											<label for="fullname<?php echo $i; ?>">Full name:</label>
											<input type="text" class="form-control" name="fullname<?php echo $i; ?>" id="fullname<?php echo $i; ?>" value="<?php echo $val['firstname']; ?>"/>
										</div>
										<div class="form-group col-md-4">
											<label for="username<?php echo $i; ?>">Username:</label>
											<input type="text" class="form-control" name="username<?php echo $i; ?>" id="username<?php echo $i; ?>" value="<?php echo $val['username']; ?>"/>
										</div>
										<div class="form-group col-md-4">
											<label for="password<?php echo $i; ?>">Password:</label>
											<input type="password" class="form-control" name="password<?php echo $i; ?>" id="password<?php echo $i; ?>" value="<?php echo $val['password']; ?>"/>
										</div>
									</div>
								<?php $i++; } ?>
							</div>
						<?php }else{ ?>
							<div class="form-row">
								<span class="form-group col-md-12">
									<label for="no_umpires" class="d-inline">Number of umpires: </label>
									<input type="number" class="form-control" name="no_umpires" id="no_umpires" min="1" max="10"/>
								</span>
								<span class="form-group col-md-12 text-danger" id="umpire_err"></span>
							</div>
							<div id="umpires_details"></div>
						<?php } ?>
						<div class="row">
							<div class="offset-md-10 col-md-2 float-right text-right"><input type="submit" name="submit" id="submit" title="Nearby hotels and hospitals" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
						</div>
					</form>
				</div>
				<div class="modal fade " id="umpires_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-body">
								<div class="table table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Umpires Name</th>
												<th>Username</th>
												<th>City</th>
												<th>Sports Type</th>
												<th>Cost</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody id="umpire_list_table">
											
										</tbody>
									</table>
								</div>
							</div>
							<div class="modal-footer">
								<div class="row">
									<div class="col-md-12">
										<ul class="bio1 pl-0">
											<li><button type="button" class="btn btn-secondary btn-sm clear" data-dismiss="modal">Close</button></li>
											<li><button type="submit" class="btn btn-primary btn-sm" id="save">Submit</button></li>
										</ul>
									</div>
								</div>		
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
			umpires+='<div class="form-row"><div class="form-group col-md-12"><h5 class="deepa-6">Umpire'+i+':</h5></div><div class="form-group col-md-3"><label for="fullname'+i+'">Full name:</label><input type="text" class="form-control" name="fullname'+i+'" id="fullname'+i+'" /></div><div class="form-group col-md-3"><label for="username'+i+'">Username:</label><input type="text" class="form-control" name="username'+i+'" id="username'+i+'"/></div><div class="form-group col-md-3"><label for="password'+i+'">Password:</label><input type="password" class="form-control" name="password'+i+'" id="password'+i+'"/></div><div class="form-group col-md-3"><label for="ump_list'+i+'">Our available Umpires</label><input type="button" class="btn btn-default py-2 m-0 ump_list" name="ump_list'+i+'" id="ump_list'+i+'" id1="'+i+'" value="Click here to hire" data-toggle="modal" data-target="#umpires_list"/></div></div>';
			no_umpires--;
			i++;
		}
		$("#umpires_details").html(umpires);
	});
	$(document).on('click','.ump_list',function(){
		var id=$(this).attr('id1');
		$.ajax({
			type:"post",
			url:"ajax/umpires_list.php",
			data:{id:id},
			success:function(data){
				$('#umpire_list_table').html(data);
				//alert(data);
			}
		});
	});
});
$(document).on('click','.hire',function(){
	var ump_id=$(this).attr('id');
	var row_id=$(this).attr('id1');
	var name=$('#name'+ump_id).text();
	var email=$('#email'+ump_id).text();
	//alert(name+","+email+","+city+","+sports_type+","+cost);
	$("#fullname"+row_id).val(name);
	$("#username"+row_id).val(email);
	$("#umpires_list").modal("hide");
});
</script>