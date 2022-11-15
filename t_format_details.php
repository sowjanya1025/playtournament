<?php
$config_path=$_SERVER['DOCUMENT_ROOT'];
include_once($config_path.'/msa/sportsbook/views/sub-views/pt_header.php'); 
//include_once('../sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location:'. $config_path.'/msa/sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$result="";
$match_types=$account->getMatchTypes();
if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
}else{
	header("location: t_schedule_details.php");
	exit;
}
$play_tournaments=[];
$id=0;
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getTournamentFormatDetails($id);
	//print_r($play_tournaments);
}
$status='';
if(isset($_GET['status'])){
	$status=$_GET['status'];
}
if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
	$status=isset($_POST['status']) ? $_POST['status'] : '';
	if($td_id!=""){
		$i=1;
		while($i<5){
			$match_type=isset($_POST['match_type'.$i.'']) ? $_POST['match_type'.$i.''] : '';
			$point_type=isset($_POST['point_type'.$i.'']) ? $_POST['point_type'.$i.''] : 'no';
			$no_sets=isset($_POST['no_sets'.$i.'']) ? $_POST['no_sets'.$i.''] : '';
			$points=isset($_POST['points'.$i.'']) ? $_POST['points'.$i.''] : '';
			$result=$account->setFormatDetails($t_id,$match_type,$point_type,$no_sets,$points,$td_id);  
			$i++;
		}
	}
	if($result['t_id']!=""){
		$t_id=$result['t_id'];
		$_SESSION["td_id"] = $t_id;
		if($status!="" && $status==0){
			header("location: t_venue_details.php?id=$t_id&status=$status");
		}else{
			header("location: t_venue_details.php?id=$t_id");
		}
		exit;
	}else{
		$_SESSION["td_id"] = $result['td_id'];
		header("location: t_venue_details.php");
		exit;
	}
}
$point_types=$account->getPointTypes();
$set_types=$account->getSetTypes();
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
					<form method="post" action="t_format_details.php" id="form1" enctype="multipart/form-data">
						<h5 class="deepa-6 "><strong>Knock Out:</strong></h5>
						<hr>
						<?php $i=1;
						if(isset($_GET['id']) && !empty($play_tournaments)){ ?>
							<input type="hidden" name="t_id" value="<?php echo $id; ?>">
							<input type="hidden" class="form-control" name="status" value="<?php echo $status; ?>" />
							<?php foreach($play_tournaments as $key=>$value){ ?>
							<div class="form-row">
								<div class="form-group col-sm-3">
									<h4 class="h4-responsive"><?php echo $value['match_type']; ?><h4>
								</div>
								<input type="hidden" name="match_type<?php echo $i; ?>" value="<?php echo $value['match_type_id']; ?>">
								<div class="form-group col-sm-3">
									<select class="browser-default custom-select" name="point_type<?php echo $i; ?>" id="point_type<?php echo $i; ?>">
										<option value="" selected><strong>Select Type of point</strong></option>
										<?php if(!empty($point_types)){
											foreach($point_types as $k=>$v){
												if($v['id']==$value['point_type_id']){
													echo '<option value="'.$v['id'].'" selected><strong>'.$v['point_type'].'</strong></option>';
												}else{
													echo '<option value="'.$v['id'].'"><strong>'.$v['point_type'].'</strong></option>';
												}
											}
										} ?>
									</select>
								</div>
								<div class="form-group col-sm-3">
									<select class="browser-default custom-select no_sets" name="no_sets<?php echo $i; ?>" id1="<?php echo $i; ?>" id="no_sets<?php echo $i; ?>">
										<option value="" selected><strong>Number of sets</strong></option>
										<?php if(!empty($set_types)){
											foreach($set_types as $key=>$v){
												if($v['id']==$value['set_type_id']){
													echo '<option value="'.$v['id'].'" selected><strong>'.$v['set_type'].'</strong></option>';
												}else{
													echo '<option value="'.$v['id'].'"><strong>'.$v['set_type'].'</strong></option>';
												}
											}
										} ?>
									</select>
								</div>
								<div class="form-group col-sm-3">
									<select class="browser-default custom-select" name="points<?php echo $i; ?>" id="points<?php echo $i; ?>" >
										<option value="<?php echo $value['points_id']; ?>" selected><strong><?php echo $value['points']; ?></strong></option>
									</select>
								</div>
							</div>
							<?php $i++; }
						}else{
							foreach($match_types as $key=>$value){ ?>
							<div class="form-row">
								<div class="form-group col-sm-3">
									<h4 class="h4-responsive"><?php echo $value['match_type']; ?><h4>
								</div>
								<input type="hidden" name="match_type<?php echo $i; ?>" value="<?php echo $value['id']; ?>">
								<div class="form-group col-sm-3">
									<select class="browser-default custom-select" name="point_type<?php echo $i; ?>" id="point_type<?php echo $i; ?>" required>
										<option value="" selected disabled ><strong>Select Type of point</strong></option>
										<?php if(!empty($point_types)){
											foreach($point_types as $key=>$value){
												echo '<option value="'.$value['id'].'"><strong>'.$value['point_type'].'</strong></option>';
											}
										} ?>
									</select>
								</div>
								<div class="form-group col-sm-3">
									<select class="browser-default custom-select no_sets" name="no_sets<?php echo $i; ?>" id1="<?php echo $i; ?>" id="no_sets<?php echo $i; ?>" required>
										<option value="" selected disabled><strong>Number of sets</strong></option>
										<?php if(!empty($set_types)){
											foreach($set_types as $key=>$value){
												echo '<option value="'.$value['id'].'"><strong>'.$value['set_type'].'</strong></option>';
											}
										} ?>
									</select>
								</div>
								<div class="form-group col-sm-3">
									<select class="browser-default custom-select" name="points<?php echo $i; ?>" id="points<?php echo $i; ?>" required>
										<option value="" selected disabled ><strong>Points per sets</strong></option>
									</select>
								</div>
							</div>
						<?php $i++; }
						} ?>
						<div class="row">
							<div class="offset-md-10 col-md-2"><input type="submit" id="submit" title="Venue details" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
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
	$('.no_sets').change(function(){
		var id=$(this).attr('id1');
		//alert(id);
		var point_type_id=$('#point_type'+id).val();
		var no_sets_id=$('#no_sets'+id).val();
		//alert(point_type_id+","+no_sets_id);
		$.ajax({
			type:"post",
			url:"ajax/getPointsPerSetHandler.php",
			//url:"../sportsbook/process/ajax/getPointsPerSetHandler.php",
			data:{point_type_id:point_type_id,no_sets_id:no_sets_id},
			success:function(data){
				$("#points"+id).html(data);
				//alert(data);
			}
		});
	});
	
});
</script>