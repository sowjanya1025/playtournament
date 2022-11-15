<?php
$config_path=$_SERVER['DOCUMENT_ROOT'];
include_once($config_path.'/msa/sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location:'. $config_path.'/msa/sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$firstname = auth::getCurrentUsername();

$user_details=$account->getUsers();
//$category_types=$account->getTournamentCategoryTypes();
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
						<a class="nav-link active black-text my-2" id="" href="index.php" aria-selected="false">Host Tournament</a>
						<a class="nav-link black-text my-2" id="" href="history.php" aria-selected="false">History</a>
						<a class="nav-link black-text my-2" id="" href="tournament_reg.php" aria-selected="false">Registrations</a>
						<a class="nav-link black-text my-2" id="" href="fixtures.php" aria-selected="false">Fixtures</a>
						<a class="nav-link black-text my-2" id="" href="spot_registrations.php" aria-selected="false">Spot Registration</a>

					</div>
				</div>
				<div class="col-md-10 box-2">
					
					<h3 class="text-center text-default"><strong>Tournament Registration Form</strong></h3>
					<hr />
					<h5 class="deepa-6" style="color: #4caf50"><strong>Organizer's Detail:</strong></h5>
					<div class="row">
						<div class="col-md-3">
							<label >Tournament conductor name:</label>
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control tc_name"  name="tc_name" value="<?php if (isset($user_details)){echo $user_details[0]['fullname']; }?>" readonly />
						</div>
					</div>
					<br/>
					<div class="row">
						<div class="col-md-3">
							<label >Email Id:</label>
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control tc_email"  name="tc_email" value="<?php if (isset($user_details)){echo $user_details[0]['username']; }?>" readonly />
						</div>
					</div>
					<br/>
					<div class="row">
						<div class="col-md-3">
							<label >Phone number:</label>
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control tc_phone"  name="tc_phone" value="<?php if (isset($user_details)){echo $user_details[0]['phone_no']; }?>" readonly />
						</div>
					</div>
					<div class="row">
						<div class="offset-md-11 col-md-1"><a href="t_schedule_details.php" title="Tournament details" class="btn btn-sm btn-default text-white">Next</a></div>
					</div>
				</div>
			</div>
        </div>
    </main>
    <!---------------------------------Footer Section----------------------------------------->
    <footer class="page-footer default-color text-white fixed-bottom text-center">
	
        <div class="footer-copyright text-center py-4">
			<a href="https://www.mysportsarena.com">MySportsArena</a> © 2020
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
});
</script>