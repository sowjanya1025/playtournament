<?php
$config_path=$_SERVER['DOCUMENT_ROOT'];
include_once($config_path.'/msa/sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location:'. $config_path.'/msa/sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$admin = new admin($dbo);

$tournamentList=$admin->getTCTournamentList($accountId);
//print_r($tournamentList);
$t_id='';$cat_id='';$tot_players='';$is_power_of_two=0;

if (!empty($_POST)){
	$category = isset($_POST['category']) ? $_POST['category'] : '';	
	$type_of_opn = isset($_POST['type_of_opn']) ? $_POST['type_of_opn'] : '';	
	$t_start_date = isset($_POST['t_start_date']) ? $_POST['t_start_date'] : '';	
	$t_end_date = isset($_POST['t_end_date']) ? $_POST['t_end_date'] : '';	
	$t_start_time = isset($_POST['t_start_time']) ? $_POST['t_start_time'] : '';	
	$t_end_time = isset($_POST['t_end_time']) ? $_POST['t_end_time'] : '';	
	$no_courts = isset($_POST['no_courts']) ? $_POST['no_courts'] : '';	
	$court_list = isset($_POST['court_names']) ? $_POST['court_names'] : '';	
	//print_r($court_list);
	if(!empty($court_list)){
		$court_list_str=implode(",",$court_list);
	}
	$no_umpires = isset($_POST['no_umpires']) ? $_POST['no_umpires'] : '';	
	$umpire_list = isset($_POST['umpire_names']) ? $_POST['umpire_names'] : '';	
	$reduce_court = isset($_POST['reduce_court']) ? $_POST['reduce_court'] : '';	
	$reduced_no_courts = isset($_POST['reduced_no_courts']) ? $_POST['reduced_no_courts'] : '';	
	//print_r($umpire_list);
	if(!empty($umpire_list)){
		$umpire_list_str=implode(",",$umpire_list);
	}
	if($category!=""){
		$cat_array[]=explode(",",$category);
		foreach($cat_array as $key=>$val){
			$t_id=$val[0];
			$cat_id=$val[1];
			$tot_players=$val[2];
		}
		if($type_of_opn=="generate"){
			 $admin->setCategorywiseDateTime($t_start_date,$t_end_date,$t_start_time,$t_end_time,$no_courts,$no_umpires,$t_id,$cat_id,$court_list_str,$umpire_list_str,$reduce_court,$reduced_no_courts);
			$is_power_of_two=$admin->isPowerOfTwo($tot_players);
			$new_no_players=$tot_players;
			if($is_power_of_two==0){
				$new_no_players=$admin->registerDummyPlayers($t_id,$cat_id,$tot_players);
			}
			//echo $new_no_players;
			//print_r($result);
			$rounds_matches=$admin->generateRoundsMatches($t_id,$cat_id,$new_no_players);
			//print_r($rounds_matches);
			$rounds_matches_arr=explode("-",$rounds_matches);
			//print_r($rounds_matches_arr);
			$round_id=1;
			foreach($rounds_matches_arr as $key=>$val){
				if($key!=0 && $val==1){
					$round_id=0;
				}
				while($val>0){
					$admin->setFixturesRows($t_id,$cat_id,$round_id); // inserting into msa_fixture_dtl (t_id,cat_id and match_league_no)
					$val--;
				}
				$round_id++;
			}
			$court_count=count($court_list);
			$admin->getCourtAndMatchDetails1($t_id,$cat_id,$new_no_players,$court_list,$umpire_list,"","",$court_count);
			$result=$admin->selectStoredProcBasedOnPoints($t_id,$cat_id,$new_no_players);
			//print_r($result);
			//echo "testing";
			//exit;
			$is_power_of_two=$admin->isPowerOfTwo($new_no_players);
			if($is_power_of_two==0){
				$admin->setByPlayers($t_id,$cat_id);
			}
			$admin->updateFixtureStatus($t_id,$cat_id);
			$admin->setMatchType($t_id,$cat_id,$rounds_matches_arr);    
			
			//reduce court for Quarter, Semi and Final Matches
			$res=$admin->reduceCourt($t_id,$cat_id,$court_list,$umpire_list);
			//print_r($res);
		}else if($type_of_opn=="publish"){
			$admin->publishFixture($t_id,$cat_id);
		}else if($type_of_opn=="clear"){
			$result=$admin->clearFixture($t_id,$cat_id);
		}
		
	}
	header("Location: fixtures.php");
	exit; 
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
						<a class="nav-link black-text my-2" id="" href="index.php" aria-selected="false">Host Tournament</a>
						<a class="nav-link black-text my-2" id="" href="history.php" aria-selected="false">History</a>
						<a class="nav-link black-text my-2" id="" href="tournament_reg.php" aria-selected="false">Registrations</a>
						<a class="nav-link active black-text my-2" id="" href="fixtures.php" aria-selected="false">Fixtures</a>
						<a class="nav-link black-text my-2" id="" href="spot_registrations.php" aria-selected="false">Spot Registration</a>
					</div>
				</div>
				<div class="col-md-10 ">
					<div class="table table-responsive subcat">
						<table class="table">
							<thead class="bg-info text-white">
								<tr>
									<th>#</th>
									<th>Tournament Name</th>
								</tr>
							</thead>
							<tbody id="user_details">
								<?php $i=1;  ?>
								<div class="container accordion_container">
									<div class="panel-group accordion" id="accordion">
									<?php foreach($tournamentList as $key=>$value){ ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														  <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $value['id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $value['id']; ?>" class="float-left"><h5><?php echo ucfirst($value['tournament_name'])."[ Date: ".date('d-m-Y',strtotime($value['tournament_start_date']))." to ".date('d-m-Y',strtotime($value['tournament_end_date']))." , Time: ".date('H:i a',strtotime($value['start_time']))." to ".date('h:i a',strtotime($value['end_time']))." ]" ; ?></h5></a><a href="court_calender.php?t_id=<?php echo $value['id']; ?>" class="btn btn-sm btn-default text-white p-2 ml-2"> Court Calender</a><a href="automode.php?t_id=<?php echo $value['id']; ?>" class="btn btn-sm btn-default text-white p-2 ml-2"> Auto mode</a>
														</h4>
													</div>
													<div id="collapse<?php echo $value['id']; ?>" class="panel-collapse collapse in">
														<?php $catList=$admin->getCategoryList($value['id']); 
														//print_r($catList); 
														$mins=$admin->getMatchTime($value['id']);
														//print_r($mins); 
														$j=1;
														echo '<div class="table table-responsive subtab" style="overflow-x:auto;">';
														echo '<table class="table" id="table1">';
														echo '<thead class="bg-info text-white">
															<tr>
																<th>#</th>
																<th>Category</th>
																<th>Generate</th>
																<th>View</th>
																<th>Court Optimize</th>
																<th>Publish</th>
																<th>Clear</th>
																<th>Category start date</th>
																<th>Category end date</th>
																<th>Category start time</th>
																<th>Category end time</th>
																<th>Number of courts</th>
																<th>Number of umpires</th>
															</tr>
														</thead>';
														echo '<tbody>';
														foreach($catList as $k=>$v){	
															//echo $v['total_reg_players'];
															$disabled="";$disabled1="disabled";$disabled3="";
															$text_clr="text-dark";
															if($v['is_fix_generated']==1 && $v['is_fix_published']==0){
																$disabled="disabled";
																$disabled1=" ";
																//$text_clr="text-default";
															}else if($v['is_fix_generated']==1 && $v['is_fix_published']==1){
																$disabled="";
																$disabled1=" ";
																$disabled3="disabled";
															}
															echo '<tr>';
															echo '<td>'.$j++.'</td><td>'.$v['cat_name'].'</td>';
															echo '<td><input type="button" class="btn btn-default btn-sm generate_fixture" id="'.$value['id'].$v['cat_name'].'" id1="'.$value['id'].','.$v['id'].','.$v['total_reg_players'].'" id2="'.$value['no_courts'].'" id3="'.$value['id'].'" id4="'.$value['start_time'].'" id5="'.$value['end_time'].'" id6="'.$value['tournament_start_date'].'" id7="'.$value['tournament_end_date'].'" id8="'.$mins.'" id9="'.$v['total_reg_players'].'" value="generate" '.$disabled.' '.$disabled3.'></td>';
															echo '<td><button type="button" class="btn btn-default btn-sm view_fixture" id="'.$value['id'].$v['cat_name'].'" id1="'.$value['id'].','.$v['id'].','.$v['total_reg_players'].'" '.$disabled1.'><a href="fixtures_view.php?t_id='.$value['id'].'&cat_id='.$v['id'].'" class="text-white">View</a></button></td>';
															echo '<td><button type="button" class="btn btn-default btn-sm optimize_fix" id="'.$value['id'].$v['cat_name'].'" id1="'.$value['id'].','.$v['id'].','.$v['total_reg_players'].'" '.$disabled1.' '.$disabled3.'><a href="optimize.php?t_id='.$value['id'].'&cat_id='.$v['id'].'" class="text-white">Optimize</a></button></td>';
															echo '<td><input type="button" class="btn btn-default btn-sm publish_fixture" id="'.$value['id'].$v['cat_name'].'" id1="'.$value['id'].','.$v['id'].','.$v['total_reg_players'].'" value="publish" '.$disabled1.' '.$disabled3.'></td>';
															echo '<td><input type="button" class="btn btn-default btn-sm clear_fixture" id="'.$value['id'].$v['cat_name'].'" id1="'.$value['id'].','.$v['id'].','.$v['total_reg_players'].'" value="clear" '.$disabled1.'></td>';
															if($v['is_fix_generated']==1){
																echo '<td>'.$v['t_start_date'].'</td><td>'.$v['t_end_date'].'</td><td>'.$v['t_start_time'].'</td><td>'.$v['t_end_time'].'</td><td>'.$v['no_courts'].'</td><td>'.$v['no_umpires'].'</td>';
															}else{
																echo '<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>';
															}
															echo '</tr>';
															//echo "<br/>";
														} 
														echo '</tbody></table>';
														echo '</div>';
														?>
													</div>
												</div>
											</td>
										</tr>
									<?php  $i++;} ?>
									</div>
								</div>
							</tbody>
						</table>
					
					</div>
				</div>
				
				
				<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<form action="fixtures.php" method="post" id="final_submit_form">
								<div class="modal-body">
									<input autocomplete="off" type="hidden" id="category" name="category">
									<input autocomplete="off" type="hidden" name="type_of_opn" value="generate">
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="md-form">
												<input type="text" id="t_start_date" class="form-control form-control-lg date" name="t_start_date" autocomplete="off"  required >
												<label for="t_start_date">Category start date</label>
											</div>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="md-form">
												<input type="text" id="t_end_date" class="form-control form-control-lg date" name="t_end_date" autocomplete="off" required>
												<label for="t_end_date">Category end date</label>
											</div>
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-md-12">
											<div class="md-form">
												<div class="date_err red-text"></div>
											</div>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="md-form">
												<input type="time" id="t_start_time" class="form-control form-control-lg" name="t_start_time" autocomplete="off" required>
												<label for="t_start_time">Category start time<span class="red-text">[24-hours Format*]</span></label>
											</div>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="md-form">
												<input type="time" id="t_end_time" class="form-control form-control-lg" name="t_end_time" autocomplete="off" required>
												<label for="t_end_time">Category end time<span class="red-text">[24-hours Format*]</span></label>
											</div>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="md-form">
												<div class="time_err red-text"></div>
											</div>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="md-form">
												<input type="number" id="no_courts" class="form-control form-control-lg" name="no_courts" autocomplete="off" required>
												<label for="no_courts">Number of courts</label>
											</div>
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-12">
											<div class="md-form">
												<div class="err red-text" id="err"></div>
											</div>
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-12">
											<div class="">
												<select class="browser-default custom-select" name="court_names[]" id="court_names" required multiple >
													
												</select>
												<div class="court_names_err red-text" id="court_names_err"></div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-md-12">
											<div class="md-form">
												<input type="number" id="no_umpires" class="form-control form-control-lg" name="no_umpires" autocomplete="off"  readonly required>
												<label for="no_umpires">Number of umpires</label>
											</div>
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-12">
											<div class="">
												<select class="browser-default custom-select" name="umpire_names[]" id="umpire_names" required multiple >
													
												</select>
												<div class="umpire_names_err red-text" id="umpire_names_err"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<label for="confirm">Do you wish to reduce the number of courts for the Quarter, Semi and Final Matches?</label>
											<div class="form-check form-check-inline">
												<input type="radio" class="form-check-input" id="yes" value="yes" name="reduce_court" required>
												<label class="form-check-label" for="yes">Yes</label>
											</div>
											<div class="form-check form-check-inline">
												<input type="radio" class="form-check-input" id="no" value="no" name="reduce_court" required>
												<label class="form-check-label" for="no">No</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<select class="browser-default custom-select" name="reduced_no_courts" id="reduced_no_courts" required  >
												<option value="0">Select Number of Courts</option>
												<option value="1">One</option>
												<option value="2">Two</option>
												<option value="4">Four</option>
											</select>
										</div>
									</div>
								</div>	
								<div class="modal-footer">
									<div class="row">
										<div class="col-md-12">
											<ul class="bio1 pl-0">
												<li><button type="button" class="btn btn-secondary btn-sm clear" data-dismiss="modal">Close</button></li>
												<li><button type="submit" id="final_submit" class="btn btn-primary btn-sm">Generate</button></li>
											</ul>
										</div>
									</div>		
								</div>
							</form>
						</div>
					</div>	
				</div>
				<div class="modal fade" id="publish" tabindex="-1" role="dialog" aria-labelledby="publish" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<form action="fixtures.php" method="post">
								<div class="modal-body">
									<input autocomplete="off" type="hidden" id="publish_category" name="category">
									<input autocomplete="off" type="hidden" name="type_of_opn" value="publish">
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="md-form">
												<p class="h5">Once the fixture is published all the players can view it. Are you sure that you wanna publish it?</p>
											</div>
										</div>
									</div>
								</div>	
								<div class="modal-footer">
									<div class="row">
										<div class="col-md-12">
											<ul class="bio1 pl-0">
												<li><button type="button" class="btn btn-secondary btn-sm clear" data-dismiss="modal">Close</button></li>
												<li><button type="submit" class="btn btn-primary btn-sm" id="">Publish</button></li>
											</ul>
										</div>
									</div>		
								</div>
							</form>
						</div>
					</div>	
				</div>
				<div class="modal fade" id="clear" tabindex="-1" role="dialog" aria-labelledby="publish" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<form action="fixtures.php" method="post">
								<div class="modal-body">
									<input autocomplete="off" type="hidden" id="clear_category" name="category">
									<input autocomplete="off" type="hidden" name="type_of_opn" value="clear">
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="md-form">
												<p class="h5">Are you sure that you want to delete the fixture that you have generated?</p>
											</div>
										</div>
									</div>
								</div>	
								<div class="modal-footer">
									<div class="row">
										<div class="col-md-12">
											<ul class="bio1 pl-0">
												<li><button type="button" class="btn btn-secondary btn-sm clear" data-dismiss="modal">Close</button></li>
												<li><button type="submit" class="btn btn-primary btn-sm" id="">Clear</button></li>
											</ul>
										</div>
									</div>		
								</div>
							</form>
						</div>
					</div>	
				</div>
				
			</div>
        </div>
    </main>
    <!---------------------------------Footer Section----------------------------------------->
    <!--<footer class="page-footer default-color text-white fixed-bottom text-center">
	
        <div class="footer-copyright text-center py-4">
			<a href="https://www.mysportsarena.com">MySportsArena</a> © <?php echo date('Y'); ?>
		</div>

    </footer>-->
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<script>
$(document).on("click",".generate_fixture",function(){
		//var category=$('input[name="category"]:checked').val();
		var category=$(this).attr('id1');
		var no_courts=$(this).attr('id2');
		var t_id=$(this).attr('id3');
		var start_time=$(this).attr('id4');
		var end_time=$(this).attr('id5');
		var start_date=$(this).attr('id6');
		var end_date=$(this).attr('id7');
		var mins=$(this).attr('id8');
		var no_players=$(this).attr('id9');
		//alert(category);
		if(category){
			$("#category").val(category);
			var courts='<option value="" disabled>Select the court name</option>';var i=1;
			while(no_courts>0){
				courts+='<option value="C'+i+'">C'+i+'</option>';
				i++;no_courts--;
			}
			$("#court_names").html(courts);
			$.ajax({
				type:"post",
				url:"../sportsbook/process/ajax/getUmpireNames.php",
				data:{t_id:t_id},
				success:function(data){
					$("#umpire_names").html(data);
				}
			});
			$('#t_end_date').attr('id4',start_date);
			$('#t_end_date').attr('id5',end_date);
			$('#t_end_time').attr('id4',start_time);
			$('#t_end_time').attr('id5',end_time);
			$('#no_courts').attr('id1',mins);
			$('#no_courts').attr('id2',no_players);
			$('#confirm').modal('toggle');
		}
	});
	$(document).on("click",".publish_fixture",function(){
		var category=$(this).attr('id1');
		if(category){
			$("#publish_category").val(category);
			$('#publish').modal('toggle');
		}
	});
	$(document).on("click",".clear_fixture",function(){
		var category=$(this).attr('id1');
		if(category){
			$('#clear').modal('toggle');
			$("#clear_category").val(category);
		}
	});
	$(function(){
		$(".date" ).datepicker({
			changeMonth:true,
			changeYear:true,
			dateFormat: 'yy-mm-dd',
			yearRange: '1970:'+ new Date().getFullYear().toString()
		});	
		$('#t_end_date').change(function(){
			var c_start_date=$('#t_start_date').val();
			var c_end_date=$(this).val();
			var t_start_date=$(this).attr('id4');
			var t_end_date=$(this).attr('id5');
			//alert(c_start_date+" "+c_end_date+" "+t_start_date+" "+t_end_date);
			if(t_start_date>c_start_date || t_end_date<c_end_date){
				$('.date_err').text("Category date should be between tournament start and end date( "+t_start_date+" - "+t_end_date+" ).");
				return false;
			}else{
				$('.date_err').text("");
				return true;
			}
		});
		$('#t_end_time').change(function(){
			var c_start_time=$('#t_start_time').val();
			var c_end_time=$(this).val();
			var t_start_time=$(this).attr('id4');
			var t_end_time=$(this).attr('id5');
			var diff = ( new Date("1970-1-1 " + c_end_time) - new Date("1970-1-1 " + c_start_time) ) / 1000 / 60 / 60;  
			if(diff<=0){
				$('.time_err').text("End time should be greater than Start Time.");
				return false;
			}else if(t_start_time>c_start_time || t_end_time<c_end_time){
				$('.time_err').text("Category time should be between tournament start and end Time( "+t_start_time+" - "+t_end_time+" ).");
				return false;
			}else{
				$('.time_err').text("");
				return true;
			}
		});
		$("#no_courts").change(function(){
			var no_courts=$(this).val();
			$("#no_umpires").val(no_courts);
		});
		$("#final_submit").click(function(e){
			e.preventDefault();
			var no_courts=$("#no_courts").val();
			var courts_arr=$("#court_names").val();
			var no_selected_courts=courts_arr.length;
			var no_umpires=$("#no_umpires").val();
			var umpires_arr=$("#umpire_names").val();
			var no_selected_umpires=umpires_arr.length;
			var mins=$("#no_courts").attr('id1');
			var no_players=$("#no_courts").attr('id2');
			var start_date=new Date($('#t_start_date').val());
			var end_date=new Date($('#t_end_date').val());
			var diff  = new Date(end_date - start_date);  
			var no_days  = (diff/1000/60/60/24)+1;  
			var start_time=$('#t_start_time').val();
			var end_time=$('#t_end_time').val();
			var time_diff = ( new Date("1-1-1970 " + end_time) - new Date("1-1-1970 " + start_time) ) / 1000 / 60 / 60; 
			var total_no_matches=Math.ceil(((no_days*time_diff*no_courts)*60)/mins);
			//alert(total_no_matches+" "+no_players);
			if(no_courts!=no_selected_courts){
				$("#court_names_err").text("Selected courts does not match the number of courts");
			}else if(no_umpires!=no_selected_umpires){
				$("#court_names_err").text("");
				$("#umpire_names_err").text("Selected umpires does not match the number of umpires");
			}else if(total_no_matches<no_players-1){
				$("#court_names_err").text("");
				$("#umpire_names_err").text("");
				$('.err').text("The date,time and court number will not be allocated to all the matches. Please increase the number of days/time/numb of courts so that all the matches will be allocated with the date,time and court number");
			}else{
				$('.err').text("");
				$("#court_names_err").text("");
				$("#umpire_names_err").text("");
				$("#final_submit_form").submit();
			}
		});
		
		 $('input:radio[name="reduce_court"]').change(
                    function(){
                        if ($(this).is(':checked') && $(this).val() == 'yes') {
                               $("#reduced_no_courts").attr('disabled',false);
                        }else{
                               $("#reduced_no_courts").attr('disabled',true);
                        }
                        
        });
	});
</script>