<?php
include_once('../sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location: ../../sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$firstname = auth::getCurrentUsername();
$result="";
$td_id='';
/* if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
}else{
	header("location: t_schedule_details.php");
	exit;
} */
$categories=$account->getCategories();
$cat_id="";
$subcategory_list=$account->getSubCategories($cat_id);
if(!empty($_POST)){
	if($td_id!=""){
		foreach($subcategory_list as $key=>$value){
			$category=isset($_POST[$value['subCategory']]) ? $_POST[$value['subCategory']] : '';
			$reporting_time=isset($_POST[$value['subCategory'].'_reporting_time']) ? $_POST[$value['subCategory'].'_reporting_time'] : '';
			$min_no_entries=isset($_POST[$value['subCategory'].'_min_no_entries']) ? $_POST[$value['subCategory'].'_min_no_entries'] : '';
			$fee=isset($_POST[$value['subCategory'].'_fee']) ? $_POST[$value['subCategory'].'_fee'] : '';
			$venue=isset($_POST[$value['subCategory'].'_venue']) ? $_POST[$value['subCategory'].'_venue'] : '';
			if($category!=""){
				$account->setTournamentCategories($reporting_time,$min_no_entries,$fee,$venue,$category,$td_id); 
			}
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
										<?php $subCategories=$account->getSubCategories($value['id']); 
											//print_r($subCategories);
											foreach($subCategories as $k=>$v){?>
												<div class="form-row"><div class="form-group col-sm-2"><span class="form-check form-check-inline"><input type="checkbox" class="form-check-input" id="<?php echo $v['subCategory']; ?>" name="<?php echo $v['subCategory']; ?>" value="<?php echo $v['id']; ?>"><label class="form-check-label" for="<?php echo $v['subCategory']; ?>"><?php echo $v['subCategory']; ?></label></span></div><div class="form-group col-sm-4"><input type="time" name="<?php echo $v['subCategory']; ?>_reporting_time"  class="form-control" id="timepicker"></div><div class="form-group col-sm-2"><input type="text" class="form-control" name="<?php echo $v['subCategory']; ?>_min_no_entries" placeholder="Min no. of entries"></div><div class="form-group col-sm-2"><input type="text" class="form-control" name="<?php echo $v['subCategory']; ?>_fee" placeholder="Fee"></div><div class="form-group col-sm-2"><select id="Venue" class="browser-default custom-select" name="<?php echo $v['subCategory']; ?>_venue"><option value="" selected><strong>Select Venue</strong></option><?php foreach($venues as $key=>$val){ echo '<option value="'.$val['id'].'"><strong>Venue - '.$val['venue'].'</strong></option>'; } ?></select></div></div>
										<?php } ?>
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
/* 	$(".category_btn").click(function(){
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
	}); */
});

</script>