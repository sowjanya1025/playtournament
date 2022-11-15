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
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$play_tournaments=$account->getTournamentPrizeDetails($id);
	//print_r($play_tournaments);
}
if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
}else{
	header("location: t_schedule_details.php");
	exit;
}
if(!empty($_POST)){
	$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
	if($td_id!=""){
		$winner_trophy=isset($_POST['winner_trophy']) ? $_POST['winner_trophy'] : 'no';
		$runner_trophy=isset($_POST['runner_trophy']) ? $_POST['runner_trophy'] : 'no';
		$semifinalist_trophy=isset($_POST['semifinalist_trophy']) ? $_POST['semifinalist_trophy'] : 'no';
		$winner_medal=isset($_POST['winner_medal']) ? $_POST['winner_medal'] : 'no';
		$runner_medal=isset($_POST['runner_medal']) ? $_POST['runner_medal'] : 'no';
		$semifinalist_medal=isset($_POST['semifinalist_medal']) ? $_POST['semifinalist_medal'] : 'no';
		$winner_goodies=isset($_POST['winner_goodies']) ? $_POST['winner_goodies'] : 'no';
		$w_goodie_name=isset($_POST['w_goodie_name']) ? $_POST['w_goodie_name'] : '';
		$runner_goodies=isset($_POST['runner_goodies']) ? $_POST['runner_goodies'] : 'no';
		$r_goodie_name=isset($_POST['r_goodie_name']) ? $_POST['r_goodie_name'] : '';
		$semifinalist_goodies=isset($_POST['semifinalist_goodies']) ? $_POST['semifinalist_goodies'] : 'no';
		$s_goodie_name=isset($_POST['s_goodie_name']) ? $_POST['s_goodie_name'] : '';
		$winner_cash_prize=isset($_POST['winner_cash_prize']) ? $_POST['winner_cash_prize'] : 'no';
		$w_cash_amount=isset($_POST['w_cash_amount']) ? $_POST['w_cash_amount'] : '';
		$runner_cash_prize=isset($_POST['runner_cash_prize']) ? $_POST['runner_cash_prize'] : 'no';
		$r_cash_amount=isset($_POST['r_cash_amount']) ? $_POST['r_cash_amount'] : '';
		$semifinalist_cash_prize=isset($_POST['semifinalist_cash_prize']) ? $_POST['semifinalist_cash_prize'] : 'no';
		$s_cash_amount=isset($_POST['s_cash_amount']) ? $_POST['s_cash_amount'] : '';
		$other_details=isset($_POST['other_details']) ? $_POST['other_details'] : '';
		$image=isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
		$newfilename="";
		if($image!=""){
			$allowedExts = array("jpg", "jpeg", "png");
			$extension = pathinfo($image, PATHINFO_EXTENSION);
			if(in_array($extension, $allowedExts)){
				$temp = explode(".", $image);
				$newfilename = 'U'.$accountId.'Tournament'.rand().'.'.end($temp);
				move_uploaded_file($_FILES["image"]["tmp_name"],"images/" . $newfilename);
			}
		}
		if($newfilename==""){
			$newfilename=isset($_POST['image1']) ? $_POST['image1'] : '';
		}
		$result=$account->setTournamentPrizes($t_id,$winner_trophy,$runner_trophy,$semifinalist_trophy,$winner_medal,$runner_medal,$semifinalist_medal,$winner_goodies,$w_goodie_name,$runner_goodies,$r_goodie_name,$semifinalist_goodies,$s_goodie_name,$winner_cash_prize,$w_cash_amount,$runner_cash_prize,$r_cash_amount,$semifinalist_cash_prize,$s_cash_amount,$other_details,$newfilename,$td_id);  
	}	
	if($result['t_id']!=""){
		$t_id=$result['t_id'];
		$_SESSION["td_id"] = $t_id;
		header("location: t_category.php?id=$t_id");
		exit;
	}else{
		$_SESSION["td_id"] = $result['td_id'];
		header("location: t_category.php");
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
					<form method="post" action="t_prizes.php" id="form1" enctype="multipart/form-data">
						<h3 class="deepa-6"><strong>Prizes:</strong></h3>
						<hr>
						<?php if(isset($_GET['id']) && !empty($play_tournaments)){ ?>
							<input type="hidden" class="form-control" name="t_id" value="<?php echo $id; ?>" />
							<div class="form-row">
								<div class="form-group col-md-2">
									<h4 class="deepa-6"><strong>Trophy:</strong></h4>
								</div>
								<div class="form-group col-md-10">
									<span class="form-check form-check-inline">
										<input type="checkbox" class="form-check-input" id="winner_trophy" name="winner_trophy" value="yes" <?php if($play_tournaments[0]['winner_trophy']=='yes') echo 'checked="checked"'; ?> >
										<label class="form-check-label" for="winner_trophy">Winner</label>
									</span> 
									<span class="form-check form-check-inline">
										<input type="checkbox" class="form-check-input" id="runner_trophy" name="runner_trophy" value="yes" <?php if($play_tournaments[0]['runner_trophy']=='yes') echo 'checked="checked"'; ?> >
										<label class="form-check-label" for="runner_trophy">Runner</label>
									</span>
									<span class="form-check form-check-inline">
										<input type="checkbox" class="form-check-input" id="semifinalist_trophy" name="semifinalist_trophy" value="yes" <?php if($play_tournaments[0]['semifinalist_trophy']=='yes') echo 'checked="checked"'; ?> >
										<label class="form-check-label" for="semifinalist_trophy">Semifinalist</label>
									</span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-sm-2">
									<h4 class="deepa-6"><strong>Medals:</strong></h4>
								</div>
								<div class="form-group col-md-10">
										<span class="form-check form-check-inline">
											<input type="checkbox" class="form-check-input" id="winner_medal" name="winner_medal" value="yes" <?php if($play_tournaments[0]['winner_medal']=='yes') echo 'checked="checked"'; ?> >
											<label class="form-check-label" for="winner_medal">Winner</label>
										</span>
										<span class="form-check form-check-inline">
											<input type="checkbox" class="form-check-input" id="runner_medal" name="runner_medal" value="yes" <?php if($play_tournaments[0]['runner_medal']=='yes') echo 'checked="checked"'; ?> >
											<label class="form-check-label" for="runner_medal">Runner</label>
										</span>
										<span class="form-check form-check-inline">
											<input type="checkbox" class="form-check-input" id="semifinalist_medal" name="semifinalist_medal" value="yes" <?php if($play_tournaments[0]['semifinalist_medal']=='yes') echo 'checked="checked"'; ?> >
											<label class="form-check-label" for="semifinalist_medal">Semifinalist</label>
										</span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-sm-2">
									<h4 class="deepa-6"><strong>Goodies:</strong></h4>
								</div>
								<div class="form-group col-md-10">
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left  pl-0">
												<input type="checkbox" class="form-check-input" id="winner_goodies" name="winner_goodies" value="yes" <?php if($play_tournaments[0]['winner_goodies']=='yes') echo 'checked="checked"'; ?> >
												<label class="form-check-label" for="winner_goodies">Winner</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="What Goodies..." name="w_goodie_name" value="<?php echo $play_tournaments[0]['w_goodie_name']; ?>" />
										</div>
									</div>
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left pl-0">
												<input type="checkbox" class="form-check-input" id="runner_goodies" name="runner_goodies" value="yes" <?php if($play_tournaments[0]['runner_goodies']=='yes') echo 'checked="checked"'; ?> >
												<label class="form-check-label" for="runner_goodies">Runner</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="What Goodies..." name="r_goodie_name" value="<?php echo $play_tournaments[0]['r_goodie_name']; ?>" />
										</div>
									</div>
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left pl-0">
												<input type="checkbox" class="form-check-input" id="semifinalist_goodies" name="semifinalist_goodies" value="yes" <?php if($play_tournaments[0]['semifinalist_goodies']=='yes') echo 'checked="checked"'; ?> >
												<label class="form-check-label" for="semifinalist_goodies">Semifinalist</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="What Goodies..." name="s_goodie_name" value="<?php echo $play_tournaments[0]['s_goodie_name']; ?>" />
										</div>
									</div>
								</div> 
							</div>
							<div class="form-row">
								<div class="form-group col-md-2">
									<h4 class="deepa-6"><strong>Cash Prize:</strong></h4>
								</div>
								<div class="form-group col-md-10">
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left pl-0">
												<input type="checkbox" class="form-check-input" id="winner_cash_prize" name="winner_cash_prize" value="yes" <?php if($play_tournaments[0]['winner_cash_prize']=='yes') echo 'checked="checked"'; ?> >
												<label class="form-check-label" for="winner_cash_prize">Winner</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="How Much Cash..." name="w_cash_amount" value="<?php echo $play_tournaments[0]['w_cash_amount']; ?>" />
										</div>
									</div>
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left pl-0">
												<input type="checkbox" class="form-check-input" id="runner_cash_prize" name="runner_cash_prize" value="yes" <?php if($play_tournaments[0]['runner_cash_prize']=='yes') echo 'checked="checked"'; ?> >
												<label class="form-check-label" for="runner_cash_prize">Runner</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="How Much Cash..." name="r_cash_amount" value="<?php echo $play_tournaments[0]['r_cash_amount']; ?>" />
										</div>
									</div>
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left pl-0">
												<input type="checkbox" class="form-check-input" id="semifinalist_cash_prize" name="semifinalist_cash_prize" value="yes" <?php if($play_tournaments[0]['semifinalist_cash_prize']=='yes') echo 'checked="checked"'; ?> >
												<label class="form-check-label" for="semifinalist_cash_prize">Semifinalist</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="How Much Cash..." name="s_cash_amount"  value="<?php echo $play_tournaments[0]['s_cash_amount']; ?>" />
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-row">
								<div class="form-group col-md-12 col-ms-12">
									<label>Details:</label>
									<textarea placeholder=" " style="height:100px" name="other_details" value="" ><?php echo $play_tournaments[0]['other_details']; ?></textarea>
									<hr />
								</div>
								<div class="form-group col-md-6 col-ms-6">
									<label>Upload Image:</label>
									<div class="form-group col-md-12">
										<img src="images/<?php echo $play_tournaments[0]['image']; ?>" alt="Tournament Image" height="42" width="42">
										<input type="hidden" id="" name="image1" value="<?php echo $play_tournaments[0]['image']; ?>" />
										<input type="file" id="myFile" name="image" id1="img_prvw" value="" />
									</div>
								</div>
								<div class="form-group col-md-6 col-ms-6 ">
									<div class="float-right"><span>Ex: </span><img src="images/play_tournament_ex_img.jpeg" alt="" height="70" width="70" id="ex_img"></div>
								</div>
								<hr />
							</div>
						<?php }else{ ?>
							<div class="form-row">
								<div class="form-group col-md-2">
									<h4 class="deepa-6"><strong>Trophy:</strong></h4>
								</div>
								<div class="form-group col-md-10">
									<span class="form-check form-check-inline">
										<input type="checkbox" class="form-check-input" id="winner_trophy" name="winner_trophy" value="yes">
										<label class="form-check-label" for="winner_trophy">Winner</label>
									</span> 
									<span class="form-check form-check-inline">
										<input type="checkbox" class="form-check-input" id="runner_trophy" name="runner_trophy" value="yes">
										<label class="form-check-label" for="runner_trophy">Runner</label>
									</span>
									<span class="form-check form-check-inline">
										<input type="checkbox" class="form-check-input" id="semifinalist_trophy" name="semifinalist_trophy" value="yes">
										<label class="form-check-label" for="semifinalist_trophy">Semifinalist</label>
									</span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-sm-2">
									<h4 class="deepa-6"><strong>Medals:</strong></h4>
								</div>
								<div class="form-group col-md-10">
										<span class="form-check form-check-inline">
											<input type="checkbox" class="form-check-input" id="winner_medal" name="winner_medal" value="yes">
											<label class="form-check-label" for="winner_medal">Winner</label>
										</span>
										<span class="form-check form-check-inline">
											<input type="checkbox" class="form-check-input" id="runner_medal" name="runner_medal" value="yes">
											<label class="form-check-label" for="runner_medal">Runner</label>
										</span>
										<span class="form-check form-check-inline">
											<input type="checkbox" class="form-check-input" id="semifinalist_medal" name="semifinalist_medal" value="yes">
											<label class="form-check-label" for="semifinalist_medal">Semifinalist</label>
										</span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-sm-2">
									<h4 class="deepa-6"><strong>Goodies:</strong></h4>
								</div>
								<div class="form-group col-md-10">
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left  pl-0">
												<input type="checkbox" class="form-check-input" id="winner_goodies" name="winner_goodies" value="yes" >
												<label class="form-check-label" for="winner_goodies">Winner</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="What Goodies..." name="w_goodie_name" value="" />
										</div>
									</div>
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left pl-0">
												<input type="checkbox" class="form-check-input" id="runner_goodies" name="runner_goodies" value="yes">
												<label class="form-check-label" for="runner_goodies">Runner</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="What Goodies..." name="r_goodie_name" value="" />
										</div>
									</div>
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left pl-0">
												<input type="checkbox" class="form-check-input" id="semifinalist_goodies" name="semifinalist_goodies" value="yes">
												<label class="form-check-label" for="semifinalist_goodies">Semifinalist</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="What Goodies..." name="s_goodie_name" value="" />
										</div>
									</div>
								</div> 
							</div>
							<div class="form-row">
								<div class="form-group col-md-2">
									<h4 class="deepa-6"><strong>Cash Prize:</strong></h4>
								</div>
								<div class="form-group col-md-10">
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left pl-0">
												<input type="checkbox" class="form-check-input" id="winner_cash_prize" name="winner_cash_prize" value="yes">
												<label class="form-check-label" for="winner_cash_prize">Winner</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="How Much Cash..." name="w_cash_amount" value="" />
										</div>
									</div>
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left pl-0">
												<input type="checkbox" class="form-check-input" id="runner_cash_prize" name="runner_cash_prize" value="yes" >
												<label class="form-check-label" for="runner_cash_prize">Runner</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="How Much Cash..." name="r_cash_amount" value="" />
										</div>
									</div>
									<div class="row my-1">
										<div class="col-md-2">
											<span class="form-check float-left pl-0">
												<input type="checkbox" class="form-check-input" id="semifinalist_cash_prize" name="semifinalist_cash_prize" value="yes" >
												<label class="form-check-label" for="semifinalist_cash_prize">Semifinalist</label>
											</span>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="How Much Cash..." name="s_cash_amount"  value="" />
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-row">
								<div class="form-group col-md-12 col-ms-12">
									<label>Details:</label>
									<textarea placeholder=" " style="height:100px" name="other_details"></textarea>
									<hr />
								</div>
								<div class="form-group col-md-6 col-ms-6">
									<label>Upload Image:</label>
									<div class="form-group col-md-12">
										<input type="file" id="myFile" name="image" id1="img_prvw" value="" />
									</div>
								</div>
								<div class="form-group col-md-6 col-ms-6 ">
									<div class="float-right"><span>Ex: </span><img src="images/play_tournament_ex_img.jpeg" alt="" height="70" width="70" id="ex_img"></div>
								</div>
								<hr />
							</div>
						<?php } ?>
						<div class="row">
							<div class="offset-md-10 col-md-2 float-right text-right"><input type="submit" title="Categories" class="btn btn-sm btn-default text-white" value="Save & Next"></div>
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
	$("#ex_img").on("click", function() {
	   $('#imagepreview').attr('src', $(this).attr('src')); // here asign the image to the modal when the user click the enlarge link
	   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
	});
});
</script>