<?php $config_path=$_SERVER['DOCUMENT_ROOT'];
include_once($config_path.'/msa/sportsbook/views/sub-views/pt_header.php'); 
	
	

	$result="";
	$error = false;
	$admin = new admin($dbo);
	
	$accountId = 0;
	
	$tournamentDetails=[];
    $account = new account($dbo, $accountId);
	$admin = new admin($dbo);
	
    $error = false;
	$t_date=0;$t_id=0;$tournament_name="";
	if(isset($_GET['t_id'])){
		$t_id=$_GET['t_id'];
		$tournamentDetails1=$admin->getTournamentDetails($t_id);
		$t_start_date=$tournamentDetails1['t_start_date'];
		$t_end_date=$tournamentDetails1['t_end_date'];
		
	}

	
										
	if(!empty($_POST)){
		$t_date=isset($_POST['t_date']) ? $_POST['t_date'] : '';
		$t_id=isset($_POST['t_id']) ? $_POST['t_id'] : '';
		$tournamentDetails=$admin->getTournamentDetails($t_id);
		$tournament_name=$tournamentDetails['tournament_name'];
	} 

	//print_r($tournamentDetails);
	

?>

<body class="fixtures">
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

	<div class="container mt-5 fixtures">
		<div class="row">
			<div class="col-md-12 text-right">
			<a href="fixtures.php" class="btn btn-default p-2 m-0">Back</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card mt-3">
					
					<div class="card-body">
						<form method="post" action="court_calender.php">
							<div class="row">
								<div class="col-md-6">
									<div class="md-form">
										<input type="hidden" name="t_id" value="<?php echo $t_id; ?>">
										<input type="text" name="t_date" class="form-control t_date" autocomplete="off" required>
										<label for="t_date">Select Date</label>
									</div>
								</div>
								<div class="col-md-6">
									<button type="submit" class="btn btn-sm btn-success" id="sub">Submit</button>
								</div>
							</div>
						</form>
						<div class="row">
							<div class="col-md-12">
								<h4 class="h4-responsive">
									<?php echo $tournament_name; 
									if($t_date!=0){
									echo "Date: ".date('d-m-Y',strtotime($t_date)); } ?>
								</h4>
							</div>
						</div>
						<div class="table_responsive">
							<?php if($tournamentDetails!="" && !empty($tournamentDetails)){ ?>
							<table class="table table-bordered" style="overflow-x:scroll;display:block!important;">
								<thead class="bg-dark text-white">
									<tr>
										<th>#</th>
										<?php 
										//date after the date selection from dropdown
										$t_start_date=$tournamentDetails['t_start_date'];
										$t_end_date=$tournamentDetails['t_end_date'];
										
										$no_courts=$tournamentDetails['no_courts'];
										$start_time=$tournamentDetails['start_time'];
										$end_time=$tournamentDetails['end_time'];
										
										
										$endTime=date('H:i:s',strtotime($end_time));
										$startTime=date('H:i:s',strtotime($start_time));
										
										
										$no_time=0;
										
										$time_diff='1:00';
										$hour=date('H',strtotime($time_diff));
										$minutes=date('i',strtotime($time_diff));
										$diff=($hour*60)+$minutes;
										
										while(strtotime($start_time)<strtotime($endTime)){ 
										
											$end_time1=strtotime($diff."minutes", strtotime($start_time));
											$end_time=date('H:i', $end_time1);
											
											$timing_range=date('h:i a',strtotime($start_time)).'-'.date('h:i a',strtotime($end_time));
											echo '<th colspan="12" class="text-center">'.$timing_range.'</th>';
											
											$start_time=$end_time;
											$no_time++;
										
										} 


										?>
										
									</tr>
								</thead>
								<tbody id="tbody">
									<?php 
									echo '<tr class="bg-default text-white">';
									echo '<td>#</td>';
									
										$time_diff='00:05';
										$hour=date('H',strtotime($time_diff));
										$minutes=date('i',strtotime($time_diff));
										$diff=($hour*60)+$minutes;
										
										while(strtotime($startTime)<strtotime($endTime)){ 
										
											$end_time1=strtotime($diff."minutes", strtotime($startTime));
											$end_time=date('H:i', $end_time1);
											
											$timing_range=date('h:i a',strtotime($startTime)).'-'.date('h:i a',strtotime($end_time));
											echo '<td>'.$timing_range.'</td>';
											
											$startTime=$end_time;
											$no_time++;
										
										} 
									echo '</tr>';
									
									
									$i=1;
									
									$startTime=date('H:i:s',strtotime($tournamentDetails['start_time']));
									$endTime=date('H:i:s',strtotime($tournamentDetails['end_time']));
										
									//iterate through no of courts
									while($no_courts>0){ 
									
										$endTime1=date('H:i',strtotime($endTime));
										$startTime1=date('H:i',strtotime($startTime));
										
										//no columns
										$j=$no_time;
											
										echo '<tr>';
													
										$court='C'.$i;
													
										echo '<td class="bg-default text-white">'.$court.'</td>';
													
										//display columns till the no of times
										while($j>0){
														
											while(strtotime($startTime1)<strtotime($endTime1)){ 
											
												$end_time1=strtotime($diff."minutes", strtotime($startTime1));
												$end_time=date('H:i', $end_time1);
														
												$cat_arr=$admin->searchForTime($startTime1,$end_time,$t_id,$court,$t_date);
												
												if(empty($cat_arr)){
																
													echo '<td class="bg-success">Free</td>';
												}else{
																
													if($cat_arr['cat_count']==1){
														
														echo '<td class="bg-warning">'.$cat_arr['category'].'</td>';
													}else{
														echo '<td class="bg-danger" ><div class="dropdown"><a type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">click me</a><div class="dropdown-menu bg-danger text-white">'.$cat_arr['category'].'</div></div></td>';
													}
												}
															
											$startTime1=$end_time;
														
											}
														
											$j--;
										}
										
										echo '</tr>';
										
										$i++;
										$no_courts--;
									} ?>
									
								</tbody>
							</table>
							<?php } ?>
						</div>
					
						<!--------------------modal starts------------------->
						<div class="modal fade" id="view_cat" tabindex="-1" role="dialog" aria-labelledby="show_more" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-body users_list" style="max-height:400px!important;overflow:scroll!important;">
										
									</div>	
									<div class="modal-footer">
										<div class="row">
											<div class="col-md-12">
												<ul class="bio1 pl-0">
													<li><button type="button" class="btn btn-info clear btn-sm" data-dismiss="modal">Close</button></li>
												</ul>
											</div>
										</div>		
									</div>
								</div>
							</div>	
						</div>
						<!--------------------modal ends----------------------->
					
					</div>
				</div>
				
				
				
				
				
			</div>
		</div>
	</div>
</body>
<?php include_once($config_path.'/sportsbook/views/sub-views/admin_footer.php'); ?>
<script>

$(document).on('mouseover','.li',function(){
	var id=$(this).attr('id');  
	//alert(id);
	$('.'+id).css("background-color", "#D9F5F2");
});
$(document).on('mouseout','.li',function(){
	var id=$(this).attr('id');  
	//alert(id);
	$('.'+id).css("background-color", "white");
});
$(function(){
	
	var start_date='<?php echo $t_start_date; ?>';
		var end_date='<?php echo $t_end_date; ?>';
	 $('.t_date').datepicker({
	  dateFormat: "yy-mm-dd",
	  maxDate:end_date,
	  minDate: start_date
	 });
	
	
	
});
	
	
	
	


</script>