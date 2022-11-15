<?php
include_once('../sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location: ../../sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$firstname = auth::getCurrentUsername();
$result="";
/* if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getRegisteredPlayTournaments($id);
} */
if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
}else{
	/* header("location: t_schedule_details.php");
	exit; */
}
$categories=$account->getCategories();
if(!empty($_POST)){
	if($td_id!=""){
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
		if($gd_reporting_time!=""){
			$result=$account->setTournamentCategories($gd_reporting_time,$gd_min_no_entries,$gd_fee,$gd_venue,$gd_categories,$td_id); 
		}
		if($bd_reporting_time!=""){
			$result=$account->setTournamentCategories($bd_reporting_time,$bd_min_no_entries,$bd_fee,$bd_venue,$bd_categories,$td_id);  
		}
		if($bu_reporting_time!=""){
			$result=$account->setTournamentCategories($bu_reporting_time,$bu_min_no_entries,$bu_fee,$bu_venue,$bu_categories,$td_id);  
		}
		if($gu_reporting_time!=""){
			$result=$account->setTournamentCategories($gu_reporting_time,$gu_min_no_entries,$gu_fee,$gu_venue,$gu_categories,$td_id);  
		}
		if($ams_reporting_time!=""){
			$result=$account->setTournamentCategories($ams_reporting_time,$ams_min_no_entries,$ams_fee,$ams_venue,$ams_categories,$td_id);  
		}
		if($afs_reporting_time!=""){
			$result=$account->setTournamentCategories($afs_reporting_time,$afs_min_no_entries,$afs_fee,$afs_venue,$afs_categories,$td_id);  
		}
		if($ms_reporting_time!=""){
			$result=$account->setTournamentCategories($ms_reporting_time,$ms_min_no_entries,$ms_fee,$ms_venue,$ms_categories,$td_id);  
		}
		if($md_reporting_time!=""){
			$result=$account->setTournamentCategories($md_reporting_time,$md_min_no_entries,$md_fee,$md_venue,$md_categories,$td_id);  
		}
		
	}
	header("location: t_umpire_details.php");
	exit;
}
$venues=$account->getVenueNos($td_id);
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
					<form method="post" action="t_category.php" id="form1" enctype="multipart/form-data">
						<h3 class="deepa-6"><strong>Categories:</strong></h3>
						<hr>
						<div class="container accordion_container">
							<div class="panel-group accordion" id="accordion">
								<?php $i=1;
								foreach($categories as $key=>$value){?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>" ><h5><?php echo $value['category']." ";?><span class="fa accordion-icon"></span></h5></a>
										</h4>
									</div>
									<div id="collapse<?php echo $i++; ?>" class="panel-collapse collapse in">
										<div class="form-row">
											<div class="form-group col-sm-3">
												<label><strong>Reporting Time:</strong></label>
												 <input type="time" name="<?php echo $value['cat_code']; ?>_reporting_time"  class="form-control" >
											</div>
											<div class="form-group col-sm-3">
												<label><strong>Min No of Entries:</strong></label>
												<input type="text" class="form-control" name="<?php echo $value['cat_code']; ?>_min_no_entries">
											</div>
											<div class="form-group  col-sm-3">
												<label><strong>Fee:</strong></label>
												<input type="text" class="form-control" name="<?php echo $value['cat_code']; ?>_fee">
											</div>
											<div class="form-group  col-sm-3">
												<label><strong>Venue:</strong></label>
												<select id="Venue" class="browser-default custom-select" name="<?php echo $value['cat_code']; ?>_venue">
													<option value="" selected><strong>Select Venue</strong></option>
													<?php foreach($venues as $key=>$val){ 
														echo '<option value="'.$val['id'].'"><strong>Venue - '.$val['venue'].'</strong></option>';
													 } ?>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12"><label class="ven-01"><strong>Select Category:</strong></label></div>
											<div class="table-responsive">
												<table class="table">
													<tbody>
														<tr>
															<?php $subCategories=$account->getSubCategories($value['id']); 
															foreach($subCategories as $k=>$v){?>
																<td><button type="button" id="<?php echo $value['cat_code']; ?>" value="<?php echo $v['id']; ?>" id1="" class="btn btn-sm black-text px-1 category_btn <?php echo $value['cat_code']; ?>" style="" ><?php echo $v['subCategory']; ?></button></td>
															<?php } ?>
															<td><button type="button" id="<?php echo $value['cat_code']; ?>" class="btn btn-sm btn-default px-2 clear_category_btn">Clear Categories</button></td>
														</tr>
													</tbody>
												</table>
											</div>
											<input type="hidden" name="<?php echo $value['cat_code']; ?>_categories" id="<?php echo $value['cat_code']; ?>_categories" />
										</div>
									</div>
								</div>
								<?php } ?>
							</div> 
						</div>
						<div class="row">
							<div class="offset-md-10 col-md-2 float-right text-right"><input type="submit" title="Umpire Details" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
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
});

</script>