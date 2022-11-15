<?php
$config_path=$_SERVER['DOCUMENT_ROOT'];
include_once($config_path.'/msa/sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location:'. $config_path.'/msa/sportsbook/index.php');
}

$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$admin = new admin($dbo);


$firstname = auth::getCurrentUsername();
$id="";
$error="";
$tournaments=$account->getTournamentLists();


$t_id='';$cat_id='';

if (!empty($_POST)){
	$tournament_id = isset($_POST['tournament_id']) ? $_POST['tournament_id'] : '';	
	$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';	
	$player_id = isset($_POST['player_id']) ? $_POST['player_id'] : '';	
	$player_email = isset($_POST['player_email']) ? $_POST['player_email'] : '';	

	if($tournament_id!="" && $category_id!="" && ($player_id!="" && $player_id!=0) && $player_email!=""){

		$result=$admin->setTournamentRegistration($tournament_id,$category_id,$player_id,0,$account);
			
		
	}
	
	header("Location: tournament_reg.php");
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
						<a class="nav-link active black-text my-2" id="" href="tournament_reg.php" aria-selected="false">Registrations</a>
						<a class="nav-link black-text my-2" id="" href="fixtures.php" aria-selected="false">Fixtures</a>
						<a class="nav-link black-text my-2" id="" href="spot_registrations.php" aria-selected="false">Spot Registration</a>
					</div>
				</div>
				<div class="col-md-10 ">
					<div class="table-responsive">
						<table class="table" id="table1">
							<thead class="bg-info text-white">
								<tr>
									<th>#</th>
									<th>Tournament_name</th>
									<th>Start date</th>
									<th>End date</th>
									<th>Category</th>
									<th>No of Registrations</th>
									<th>Amount Earned</th>
									<th>Update ranks</th>
									<th>Register player</th>
								</tr>
							</thead>
							<tbody id="user_details">
								<?php $i=1;foreach($tournaments as $key=>$val){
									$users_list=$account->getRegUsers($val['id'],$val['cat_id']);
									$reg_users='';
									$j=1;
									foreach($users_list as $k=>$v){
										$reg_users.=''.$j++.'. '.$v['name'].'['.$v['payment_id'].'], Ph: '.$v['phone'].', Email: '.$v['email'].''.'<br/>';
									}
									if($val['no_registration']!=0){
										echo '<tr>
											<td>'.$i++.'</td>
											<td>'.$val['tournament_name'].'</td>
											<td>'.$val['start_date'].'</td>
											<td>'.$val['end_date'].'</td>
											<td>'.$val['category'].'</td>
											<td class="no_reg" data-target="#show_more" aria-expanded="false" title="Click Me" id1="'.$reg_users.'">'.$val['no_registration'].'(Click here to know the participant)</td>
											<td>'.$val['earned_amount'].'</td>
											<td><a href="update_ranks.php?t_id='.$val['id'].'&cat_id='.$val['cat_id'].'">Update Ranks</a></td>
											<td><input type="button" class="btn btn-default btn-sm register m-1 p-1" id="'.$val['id'].'" id1="'.$val['cat_id'].'" value="Register" data-toggle="modal" data-target="#register"></td>
										</tr>';
									}else{
										echo '<tr>
											<td>'.$i++.'</td>
											<td>'.$val['tournament_name'].'</td>
											<td>'.$val['start_date'].'</td>
											<td>'.$val['end_date'].'</td>
											<td>'.$val['category'].'</td>
											<td>'.$val['no_registration'].'</td>
											<td>'.$val['earned_amount'].'</td>
											<td><a href="#">Update Ranks</a></td>
											<td><input type="button" class="btn btn-default btn-sm register m-1 p-1" id="'.$val['id'].'" id1="'.$val['cat_id'].'" value="Register" data-toggle="modal" data-target="#register"></td>
										</tr>';
									}
								} ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal fade" id="show_more" tabindex="-1" role="dialog" aria-labelledby="show_more" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
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
				
				<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<form action="tournament_reg.php" method="post" id="">
								<div class="modal-body">
									<input autocomplete="off" type="hidden" id="tournament_id" name="tournament_id">
									<input autocomplete="off" type="hidden" id="category_id" name="category_id">
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="md-form">
												<!--<select class="browser-default custom-select" name="player_id" id="player_list" searchable="Search here..">
												</select>-->
												<input type="text" id="new_user_name" class="form-control form-control-lg" name="player_email" autocomplete="off" required id1="" id2="">
												<input type="hidden" id="player_id" name="player_id" autocomplete="off" value="0">
												<span id="err_msg">Please enter users email address</span>
											</div>
										</div>
									</div>
								</div>	
								<div class="modal-footer">
									<div class="row">
										<div class="col-md-12">
											<ul class="bio1 pl-0">
												<li><button type="button" class="btn btn-secondary btn-sm clear" data-dismiss="modal">Close</button></li>
												<li><button type="submit" id="final_submit" class="btn btn-primary btn-sm">Register</button></li>
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<script>
$(document).on("click",".register",function(){
		var t_id=$(this).attr('id');
		var cat_id=$(this).attr('id1');
		$("#tournament_id").val(t_id);
		$("#category_id").val(cat_id);
		$("#new_user_name").attr('id1',t_id);
		$("#new_user_name").attr('id2',cat_id);
				
		
	});
$(function(){
	 $(".date" ).datepicker({
        changeMonth:true,
        changeYear:true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1970:2019',
    });	
	$(".del_tournament").click(function(){
		var id=$(this).attr('id1');
		$("#t_del_id").val(id);
	});
	$('#table1').DataTable();
	$("#table1_wrapper select").addClass("browser-default custom-select");
	$(".custom-select").css("width", "40%" );
	
	
	$('#new_user_name').keyup(function(e){
			var new_user_email=$("#new_user_name").val();
			var t_id=$(this).attr('id1');
			var cat_id=$(this).attr('id2');
			$.ajax({
					type:"post",
					url:"../sportsbook/process/ajax/validateNewUserEmail.php",
					data:{new_user_email:new_user_email,t_id:t_id,cat_id:cat_id},
					dataType: 'json',
					success:function(data){
						if(data[0]==1){
							$("#err_msg").html(data[1]);
							$("#err_msg").css('color','red');
							e.preventDefault();
						}else{
							$("#err_msg").html("");
							$("#player_id").val(data[2]);
						}
					}
			});
	});
});

$(document).on('click','.no_reg',function(){
		$("#show_more").modal('show');
		var users_list=$(this).attr('id1');
		$(".users_list").html(users_list);
	});
</script>