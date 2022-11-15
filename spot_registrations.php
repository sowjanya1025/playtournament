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
						<a class="nav-link  black-text my-2" id="" href="fixtures.php" aria-selected="false">Fixtures</a>
						<a class="nav-link active black-text my-2" id="" href="spot_registrations.php" aria-selected="false">Spot Registration</a>
					</div>
				</div>
				<div class="col-md-10 ">
					<p class="text-success"><?php if(isset($result['msg'])){echo $result['msg']; } ?></p>
					<div class="table table-responsive">
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
														  <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $value['id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $value['id']; ?>" ><h5><?php echo ucfirst($value['tournament_name'])."[ Date: ".date('d-m-Y',strtotime($value['tournament_start_date']))." to ".date('d-m-Y',strtotime($value['tournament_end_date']))." , Time: ".date('H:i a',strtotime($value['start_time']))." to ".date('h:i a',strtotime($value['end_time']))." ]" ; ?><span class="fa accordion-icon"></span></h5></a>
														</h4>
													</div>
													<div id="collapse<?php echo $value['id']; ?>" class="panel-collapse collapse in">
														<?php $catList=$admin->getCategoryList($value['id']); 
														//print_r($catList); 
														$mins=$admin->getMatchTime($value['id']);
														//print_r($mins); 
														$i=1;
														echo '<div class="table table-responsive subtab" style="overflow-x:auto;">';
														echo '<table class="table" id="table1">';
														echo '<thead class="bg-info text-white">
															<tr>
																<th>#</th>
																<th>Category</th>
																<th>Spot Registration</th>
																
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
															echo '<td>'.$i++.'</td><td>'.$v['cat_name'].'</td>';
															echo '<td><button type="button" class="btn btn-default btn-sm view_fixture" id="'.$value['id'].$v['cat_name'].'" id1="'.$value['id'].','.$v['id'].','.$v['total_reg_players'].'" '.$disabled1.'><a href="spot_reg_fixtures_view.php?t_id='.$value['id'].'&cat_id='.$v['id'].'" class="text-white">Register</a></button></td>';
															
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