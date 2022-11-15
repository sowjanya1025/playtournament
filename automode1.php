<?php 
$config_path=$_SERVER['DOCUMENT_ROOT'];
	include_once('../sportsbook/views/sub-views/pt_header.php'); 

$result="";
$error = false;
$admin = new admin($dbo);

$t_id='';
if(isset($_GET['t_id'])){
	$t_id=$_GET['t_id'];
}
$no_courts=0;$no_categories=0;
$t_cat_list=$admin->getTournamentCategories($t_id);
//print_r($t_cat_list);
if(!empty($t_cat_list)){
	$no_courts=$t_cat_list[1]['no_courts'];
	$no_categories=count($t_cat_list[0]);
}

$mins=$admin->getMatchTime($t_id);
$no_players=0;
$start_date=$t_cat_list[0][0]['start_date'];
$end_date=$t_cat_list[0][0]['end_date'];
$start_time=$t_cat_list[0][0]['start_time'];
$end_time=$t_cat_list[0][0]['end_time'];
//echo $mins;
//echo $no_categories;
//$tournamentList=$admin->getTournamentList();
//$cat_id='';$tot_players='';$is_power_of_two=0;
if (!empty($_POST)){
	$t_id = isset($_POST['t_id']) ? $_POST['t_id'] : '';
	$no_categories = isset($_POST['no_categories']) ? $_POST['no_categories'] : '';
	
	
	$no_cat=$no_categories;
	$i=1;
	while($no_categories>0){
		
		$subcat_id = isset($_POST['subcat_id'.$i.'']) ? $_POST['subcat_id'.$i.''] : '';
		$priority = isset($_POST['priority'.$i.'']) ? $_POST['priority'.$i.''] : '';
		$tot_players = isset($_POST['no_players'.$i.'']) ? $_POST['no_players'.$i.''] : '';
		$result=$admin->updatePriorities($t_id,$subcat_id,$priority,$tot_players);
		
		$no_categories--;
		$i++;
	}

	//$category = isset($_POST['category']) ? $_POST['category'] : '';	
	//$type_of_opn = isset($_POST['type_of_opn']) ? $_POST['type_of_opn'] : '';	
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
	$reduce_court = 'yes';	
	$reduced_no_courts = 1;	
	//print_r($umpire_list);
	if(!empty($umpire_list)){
		$umpire_list_str=implode(",",$umpire_list);
	}
	$i=1;
	while($no_cat>0){
		
		$cat_id = isset($_POST['subcat_id'.$i.'']) ? $_POST['subcat_id'.$i.''] : '';
		$tot_players = isset($_POST['no_players'.$i.'']) ? $_POST['no_players'.$i.''] : '';
		//if($type_of_opn=="generate"){
		$admin->setCategorywiseDateTime($t_start_date,$t_end_date,$t_start_time,$t_end_time,$no_courts,$no_umpires,$t_id,$cat_id,$court_list_str,$umpire_list_str,$reduce_court,$reduced_no_courts);
		
		$no_cat--;$i++;
	} 
	//$j=1;
	$pr_cat=$admin->getPrioritywiseCategories($t_id);
	//print_r($pr_cat);
	$umpire_list2=$umpire_list;
	foreach($pr_cat as $k=>$v){
			$umpire_list=$umpire_list2;
			$matchStartTime='';$available_courts=[];$matchDate='';
			if($v['fix_priority']>1){
				//last priority data
				$fixTimeCourt=$admin->getFixStartTime($v['tournament_details_id'],$pr_cat[$k-1]['subcategory_id']);
				$no_courts=$fixTimeCourt['no_courts'];
				//print_r($fixTimeCourt);
				//echo $v['fix_priority'];
				
				$busy_courts=$admin->getNotAvailableCourts($v['fix_priority'],$v['tournament_details_id'],$fixTimeCourt['matchStartTime'],$fixTimeCourt['match_date']);
				//print_r($busy_courts);
				
				$t=1;
				while($no_courts>0){
					$court='C'.$t;
					if(!in_array($court, $busy_courts)){
						$available_courts[]=$court;
					}
					$no_courts--;
					$t++;
				} 
				//print_r($available_courts);
				$matchStartTime=$fixTimeCourt['matchStartTime'];
				$matchDate=$fixTimeCourt['match_date'];
				$court_list=$available_courts;
				//print_r($court_list);
				
				$umpire_list1=[];
				$u=0;
				foreach($court_list as $key1=>$val1){
					$c_num=ltrim($val1,'C');
					$umpire_list1[$u++]=$umpire_list[$c_num-1];
				}
				//print_r($umpire_list1);
				$umpire_list=$umpire_list1;
				
			} 
			
		
			$is_power_of_two=$admin->isPowerOfTwo($v['no_players']);
			$new_no_players=$v['no_players'];
			if($is_power_of_two==0){
				$new_no_players=$admin->registerDummyPlayers($v['tournament_details_id'],$v['subcategory_id'],$v['no_players']);
			}
			//echo $new_no_players;
			//print_r($result);
			$rounds_matches=$admin->generateRoundsMatches($v['tournament_details_id'],$v['subcategory_id'],$new_no_players);
			$rounds_matches_arr=explode("-",$rounds_matches);
			//print_r($rounds_matches_arr);
			$round_id=1;
			foreach($rounds_matches_arr as $key=>$val){
				if($key!=0 && $val==1){
					$round_id=0;
				}
				while($val>0){
					$admin->setFixturesRows($v['tournament_details_id'],$v['subcategory_id'],$round_id);
					$val--;
				}
				$round_id++;
			}
			$court_count=count($court_list);
			$admin->getCourtAndMatchDetails1($v['tournament_details_id'],$v['subcategory_id'],$new_no_players,$court_list,$umpire_list,$matchStartTime,$matchDate,$court_count);
			 
			$result=$admin->selectStoredProcBasedOnPoints($v['tournament_details_id'],$v['subcategory_id'],$new_no_players);
			$is_power_of_two=$admin->isPowerOfTwo($new_no_players);
			if($is_power_of_two==0){
				$admin->setByPlayers($v['tournament_details_id'],$v['subcategory_id']);
			}
			$admin->updateFixtureStatus($v['tournament_details_id'],$v['subcategory_id']);
			$admin->setMatchType($v['tournament_details_id'],$v['subcategory_id'],$rounds_matches_arr);    
			
			//reduce court for Quarter, Semi and Final Matches
			$res=$admin->reduceCourt($v['tournament_details_id'],$v['subcategory_id'],$court_list,$umpire_list);  
		
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
    <main>
         <div class="container-fluid">
			<div class="row mt-3">
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
					<p class="text-success"><?php if(isset($result['msg'])){echo $result['msg']; } ?></p>
					<div class="card">
						<div class="card-body">
							<form action="automode.php" method="post">
								<input type="hidden" name="t_id" value="<?php echo $t_id; ?>">
								<input type="hidden" name="no_categories" value="<?php echo $no_categories; ?>">
								<div class="row mt-2">
									<div class="col-md-12">
										<div class="table table-responsive">
											<table class="table">
												<thead class="bg-default text-white">
													<tr>
														<th>#</th>
														<th>Category</th>
														<th>Priority</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														$i=1;
														foreach($t_cat_list[0] as $key=>$val){
															//echo $val['no_players'];
															echo '<tr>
																<td>'.$i.'</td>
																<td>'.$val['subcat'].'<input type="hidden" value="'.$val['subcat_id'].'" name="subcat_id'.$i.'"><input type="hidden" value="'.$val['no_players'].'" name="no_players'.$i.'"></td>
																<td><input type="number" class="form-control priority" name="priority'.$i.'" id="priority'.$i.'"><span class="red-text"></span></td>
															</tr>';
															$i++;
															$no_players+=$val['no_players'];
														}
													?>
													<tr>
													
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									
									
								</div>
								
								<div class="row">
									<div class="col-md-12">
									
										<div class="row mt-2">
										
											<div class="col-md-3">
												<div class="md-form">
													<input type="date" id="t_start_date" class="form-control form-control-lg date" name="t_start_date" autocomplete="off"  required >
													<label for="t_start_date">Category start date</label>
												</div>
											</div>
											
											<div class="col-md-3">
												<div class="md-form">
													<input type="date" id="t_end_date" class="form-control form-control-lg date" name="t_end_date" autocomplete="off" required>
													<label for="t_end_date">Category end date</label>
												</div>
											</div>
											
											<div class="col-md-3">
												<div class="md-form">
													<input type="time" id="t_start_time" class="form-control form-control-lg" name="t_start_time" autocomplete="off" required>
													<label for="t_start_time">Category start time<span class="red-text">[24-hours Format*]</span></label>
												</div>
											</div>
											
											<div class="col-md-3">
												<div class="md-form">
													<input type="time" id="t_end_time" class="form-control form-control-lg" name="t_end_time" autocomplete="off" required>
													<label for="t_end_time">Category end time<span class="red-text">[24-hours Format*]</span></label>
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
													<div class="time_err red-text"></div>
												</div>
											</div>
										</div>
										
										<div class="row mt-2">
										
											<div class="col-md-6">
												<div class="md-form">
													<input type="number" id="no_courts" class="form-control form-control-lg" name="no_courts" autocomplete="off" required>
													<label for="no_courts">Number of courts</label>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="">
													<select class="browser-default custom-select" name="court_names[]" id="court_names" required multiple >
														
													</select>
													<div class="court_names_err red-text" id="court_names_err"></div>
												</div>
											</div>
										</div>
										
										<!--<div class="row my-2">
											<div class="col-md-6">
												<div class="md-form">
													<div class="err red-text" id="err"></div>
												</div>
											</div>
										</div>-->
										
										
										
										<div class="row mt-3">
										
											<div class="col-md-6">
												<div class="md-form">
													<input type="number" id="no_umpires" class="form-control form-control-lg" name="no_umpires" autocomplete="off"  readonly required>
													<label for="no_umpires">Number of umpires</label>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="">
													<select class="browser-default custom-select" name="umpire_names[]" id="umpire_names" required multiple >
														
													</select>
													<div class="umpire_names_err red-text" id="umpire_names_err"></div>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-12 text-center">
												<span class="red-text final_val"></span>
											</div>
										</div>
										
										
										<div class="row">
											<div class="col-md-12 text-center">
												<button type="submit" id="final_submit" class="btn btn-default btn-sm">Submit</button>
											</div>
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
</body>
<?php include_once($config_path.'/sportsbook/views/sub-views/admin_footer.php'); ?>
<script>

	
			
			var t_id='<?php echo $t_id; ?>';
			var no_courts='<?php echo $no_courts; ?>';
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
	
	$("#no_courts").change(function(){
			var no_courts=$(this).val();
			$("#no_umpires").val(no_courts);
		});
		
	
	$(function(){
		
		$(".priority").change(function(){
			var numb_pr='<?php echo $i; ?>';
			var numb_pr=numb_pr-1;
			var pr_val=$(this).val();
			var id=$(this).attr('id');
			//alert(id);
			
			if(pr_val<1 || pr_val>numb_pr){
				
				$("#"+id+"").next().html("Priority should be between 1 and "+numb_pr);
				$("#final_submit").attr('disabled',true);
			}else{
				
				var z=0;
				$(".priority").each(function(){
					var y=$(this).val();
					if(pr_val==y){
						z=z+1;
					}
				});
				
				if(z>1){
					$("#"+id+"").next().html("Please enter unique priority");
					$("#final_submit").attr('disabled',true);
				}else{
					$("#"+id+"").next().html("");
					$("#final_submit").attr('disabled',false);
				}
			}
			
			
			
		});
		
		$('#t_end_date').change(function(){
			var c_start_date=$('#t_start_date').val();
			var c_end_date=$(this).val();
			var t_start_date='<?php echo $start_date; ?>';
			var t_end_date='<?php echo $end_date; ?>';
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
			var t_start_time='<?php echo $start_time; ?>';
			var t_end_time='<?php echo $end_time; ?>';
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
		
		$("#final_submit").click(function(e){
			//e.preventDefault();
			var no_courts=$("#no_courts").val();
			var courts_arr=$("#court_names").val();
			var no_selected_courts=courts_arr.length;
			var no_umpires=$("#no_umpires").val();
			var umpires_arr=$("#umpire_names").val();
			var no_selected_umpires=umpires_arr.length;
			var mins='<?php echo $mins; ?>';
			var no_players='<?php echo $no_players; ?>';
			var start_date=new Date($('#t_start_date').val());
			var end_date=new Date($('#t_end_date').val());
			var diff  = new Date(end_date - start_date);  
			var no_days  = (diff/1000/60/60/24)+1;  
			var start_time=$('#t_start_time').val();
			var end_time=$('#t_end_time').val();
			var time_diff = ( new Date("1-1-1970 " + end_time) - new Date("1-1-1970 " + start_time) ) / 1000 / 60 / 60; 
			var total_no_matches=Math.ceil(((no_days*time_diff*no_courts)*60)/mins);
			//alert(total_no_matches+" "+no_players);
			if(start_time!="" && end_time!="" &&  no_courts!=""){
				if(no_courts!=no_selected_courts){
					$("#court_names_err").text("Selected courts does not match the number of courts");
				}else if(no_umpires!=no_selected_umpires){
					$("#court_names_err").text("");
					$("#umpire_names_err").text("Selected umpires does not match the number of umpires");
				}else if(total_no_matches<no_players-1){
					$("#court_names_err").text("");
					$("#umpire_names_err").text("");
					$(".final_val").html("The date,time and court number will not be allocated to all the matches. Please increase the number of days/time/numb of courts so that all the matches will be allocated with the date,time and court number");
					e.preventDefault();
				}else{
					//$('.err').text("");
					$("#court_names_err").text("");
					$("#umpire_names_err").text("");
					$("#final_submit_form").submit();
				}
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