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
$id="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getTournamentCategoryDetails($id);
	//print_r($play_tournaments);
}
if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
	$tournamentCategories=$account->getTournamentCategories($td_id);
	$venues=$account->getVenueNos($td_id);
	//print_r($venues);
}else{
	header("location: t_schedule_details.php");
	exit;
}
$categories=$account->getCategories();
//print_r($categories);
$cat_id="";
//$subcategory_list=$account->getSubCategories($cat_id);
//print_r($subcategory_list);
$result="";
if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
 	if($td_id!=""){
		foreach($categories as $key=>$value){
			$category=isset($_POST[$value['id'].'category']) ? $_POST[$value['id'].'category'] : '';
			$reporting_time=isset($_POST[$value['id'].'reporting_time']) ? $_POST[$value['id'].'reporting_time'] : '';
			$min_no_entries=isset($_POST[$value['id'].'min_no_entries']) ? $_POST[$value['id'].'min_no_entries'] : '';
			$fee=isset($_POST[$value['id'].'fee']) ? $_POST[$value['id'].'fee'] : '';
			$venue=isset($_POST[$value['id'].'venue']) ? $_POST[$value['id'].'venue'] : '';
			if($category!=""){
			$result=$account->setTournamentCategories($t_id,$reporting_time,$min_no_entries,$fee,$venue,$category,$td_id); 
			}
		}
	}
	if($t_id!=""){
		$t_id=$t_id;
		$_SESSION["td_id"] = $t_id;
		header("location: t_umpire_details.php?id=$t_id");
		exit;
	}else{
		$_SESSION["td_id"] = $result['td_id'];
		header("location: t_umpire_details.php");
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
					<?php if($result!=""){
							echo $result;
						} 
					?>
					<h3 class="text-center text-default"><strong>Tournament Registration Form</strong></h3>
					<form method="post" action="t_category.php" id="form1" enctype="multipart/form-data" name="myForm">
						<h3 class="deepa-6"><strong>Categories:</strong></h3>
						<hr>
						<div class="container accordion_container">
							<div class="panel-group accordion" id="accordion">
								<?php foreach($categories as $key=>$value){?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $value['id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $value['id']; ?>" ><h5><?php echo $value['category']." ";?><span class="fa accordion-icon"></span></h5></a>
										</h4>
									</div>
									<div id="collapse<?php echo $value['id']; ?>" class="panel-collapse collapse in">
										<?php $subCategories=$account->getSubCategories($value['id'],$id); ?>
											<div class="subcat_details<?php echo $value['id']; ?>">
												<?php  if(isset($_GET['id']) && !empty($play_tournaments)){ 
													foreach($play_tournaments as $s_key=>$s_value){
														if($s_value['category_id']==$value['id']){
															echo '<div class="form-row"><div class="form-group col-sm-2"><span class="form-check form-check-inline"><select class="browser-default custom-select" name="category" id="category" readonly><option value="'.$s_value['subcategory_id'].'" selected><strong>'.$s_value['subcategory_name'].'</strong></option></select></span></div><div class="form-group col-sm-2"><input type="text" class="form-control" name="min_no_entries" id="min_no_entries" placeholder="Min no. of entries" readonly value="'.$s_value['min_no_entries'].'"></div><div class="form-group col-sm-2"><input type="text" class="form-control" name="fee" id="fee" placeholder="Fee" value="'.$s_value['fee'].'" readonly></div><div class="form-group col-sm-2"><select id="venue" class="browser-default custom-select" name="venue" readonly><option value="'.$s_value['tournament_venues_id'].'" selected><strong>'.$s_value['venue_name'].'</strong></option></select></div><div class="form-group col-sm-1"><button type="button" class="btn btn-sm bg-default text-white del p-2" id1="'.$value['id'].'" id="'.$s_value['id'].'"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>';
														}
													}
												?>
													<input type="hidden" class="form-control" name="t_id" value="<?php echo $id; ?>" />
													<div class="form-row rows">
														<div class="form-group col-sm-2">
															<span class="form-check form-check-inline">
																<select class="browser-default custom-select" name="<?php echo $value['id']; ?>category" id="<?php echo $value['id']; ?>category" >
																	<option value="" selected><strong>Select Category</strong></option>
																	<?php
																	foreach($subCategories as $k=>$v){
																		echo '<option value="'.$v['id'].'"><strong>'.$v['subCategory'].'</strong></option>';
																	}
																	?>
																</select>
															</span>
														</div>
														<div class="form-group col-sm-2">
															<input type="text" class="form-control" name="<?php echo $value['id']; ?>min_no_entries" placeholder="Min no. of entries" id="<?php echo $value['id']; ?>min_no_entries">
														</div>
														<div class="form-group col-sm-2">
															<input type="text" class="form-control" name="<?php echo $value['id']; ?>fee" placeholder="Fee" id="<?php echo $value['id']; ?>fee">
														</div>
														<div class="form-group col-sm-2">
															<select id="<?php echo $value['id']; ?>venue" class="browser-default custom-select" name="<?php echo $value['id']; ?>venue">
															<?php foreach($venues as $key=>$val){ echo '<option value="'.$val['id'].'" selected ><strong>'.$val['venue_name'].'</strong></option>'; } ?>
															</select>
														</div>
														<div class="form-group col-sm-1">
															<button type="button" class="btn btn-sm bg-default text-white add" id1="<?php echo $value['id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
														</div>
													</div>
												<?php }else{ ?>
													<div class="form-row rows">
														<div class="form-group col-sm-2">
															<span class="form-check form-check-inline">
																<select class="browser-default custom-select" name="<?php echo $value['id']; ?>category" id="<?php echo $value['id']; ?>category" >
																	<option value="" selected><strong>Select Category</strong></option>
																	<?php
																	foreach($subCategories as $k=>$v){
																		echo '<option value="'.$v['id'].'"><strong>'.$v['subCategory'].'</strong></option>';
																	}
																	?>
																</select>
															</span>
														</div>
														<div class="form-group col-sm-2">
															<input type="text" class="form-control" name="<?php echo $value['id']; ?>min_no_entries" placeholder="Min no. of entries" id="<?php echo $value['id']; ?>min_no_entries">
														</div>
														<div class="form-group col-sm-2">
															<input type="text" class="form-control" name="<?php echo $value['id']; ?>fee" placeholder="Fee" id="<?php echo $value['id']; ?>fee">
														</div>
														<div class="form-group col-sm-2">
															<select id="<?php echo $value['id']; ?>venue" class="browser-default custom-select" name="<?php echo $value['id']; ?>venue">
															<?php foreach($venues as $key=>$val){ echo '<option value="'.$val['id'].'" selected ><strong>'.$val['venue_name'].'</strong></option>'; } ?>
															</select>
														</div>
														<div class="form-group col-sm-1">
															<button type="button" class="btn btn-sm bg-default text-white add" id1="<?php echo $value['id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
														</div>
													</div>
												<?php } ?>
											</div>
										<?php //} ?>
									</div>
								</div>
								<?php } ?>
							</div> 
						</div>
						<div class="row">
							<div class="offset-md-10 col-md-2 float-right text-right"><input type="submit" name="submit" id="submit" title="Umpire Details" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
						</div>
					</form>
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
	/* $(".add").click(function(){
		var cat_id=$(this).attr('id1');
		var category=$('#'+cat_id+'category').val();
		var reporting_time=$('#'+cat_id+'reporting_time').val();
		var min_no_entries=$('#'+cat_id+'min_no_entries').val();
		var fee=$('#'+cat_id+'fee').val();
		var venue=$('#'+cat_id+'venue').val();
		var td_id='<?php echo $td_id; ?>';
		//var venues='<?php $venues; ?>';
		//alert(venues);
		//alert(td_id+","+cat_id+","+category+","+reporting_time+","+min_no_entries+","+fee+","+venue);
		if(category==""){
			$('#category').css('border','1px solid red');
		}else if(reporting_time==""){
			$('#reporting_time').css('border','1px solid red');
		}else if(min_no_entries==""){
			$('#min_no_entries').css('border','1px solid red');
		}else if(fee==""){
			$('#fee').css('border','1px solid red');
		}else if(venue==""||venue==null){
			$('#venue').css('border','1px solid red');
		}else{
			$.ajax({
				type:"post",
				url:"ajax/getCategories.php",
				data:{cat_id:cat_id,category:category,reporting_time:reporting_time,min_no_entries:min_no_entries,fee:fee,venue:venue,td_id:td_id},
				success:function(data){
					$('.subcat_details'+cat_id).html(data);
					//alert(data);
				}
			});
		}
	}); */
	/* $("#submit").click(function()
    {
        if($('input[type=text]').val()==""){
			$(this).attr("disabled", "disabled");
		}

        return true; // ensure form still submits
    }); */
});
$(document).on('click','.add',function(){
		var cat_id=$(this).attr('id1');
		var category=$('#'+cat_id+'category').val();
		var reporting_time=$('#'+cat_id+'reporting_time').val();
		var min_no_entries=$('#'+cat_id+'min_no_entries').val();
		var fee=$('#'+cat_id+'fee').val();
		var venue=$('#'+cat_id+'venue').val();
		var td_id='<?php echo $td_id; ?>';
		//var venues='<?php $venues; ?>';
		//alert(venues);
		//alert(td_id+","+cat_id+","+category+","+reporting_time+","+min_no_entries+","+fee+","+venue);
		if(category==""){
			$('#'+cat_id+'category').css('border','1px solid red');
		}else if(reporting_time==""){
			$('#'+cat_id+'reporting_time').css('border','1px solid red');
		}else if(min_no_entries==""){
			$('#'+cat_id+'min_no_entries').css('border','1px solid red');
		}else if(fee==""){
			$('#'+cat_id+'fee').css('border','1px solid red');
		}else if(venue==""||venue==null){
			$('#'+cat_id+'venue').css('border','1px solid red');
		}else{
			$.ajax({
				type:"post",
				url:"ajax/getCategories.php",
				data:{cat_id:cat_id,category:category,reporting_time:reporting_time,min_no_entries:min_no_entries,fee:fee,venue:venue,td_id:td_id},
				success:function(data){
					$('.subcat_details'+cat_id).html(data);
					//alert(data);
				}
			});
		}
});
$(document).on('click','.del',function(){
	var cat_id=$(this).attr('id1');
	var t_cat_id=$(this).attr('id');
	var td_id='<?php echo $td_id; ?>';
	$.ajax({
		type:"post",
		url:"ajax/delCategories.php",
		data:{t_cat_id:t_cat_id,td_id:td_id,cat_id:cat_id},
		success:function(data){
			$('.subcat_details'+cat_id).html(data);
		}
	});
});
$(document).on('click','#del',function(){
	$(this).closest('.form-row').remove();
});
</script>