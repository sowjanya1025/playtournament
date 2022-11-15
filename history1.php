<?php
include_once('../sportsbook/views/sub-views/pt_header.php'); 
if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
    header('Location: ../../sportsbook/index.php');
}
$accountId = auth::getCurrentUserId();
$account = new account($dbo, $accountId);
$firstname = auth::getCurrentUsername();
$id="";
$error="";
$result=$account->getRegisteredPlayTournaments($id);
//print_r($result);
if (!empty($_POST)) {
	$token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';
	$t_del_id = isset($_POST['t_del_id']) ? $_POST['t_del_id'] : '';
	$reason=isset($_POST['reason']) ? $_POST['reason'] : '';
	
	if (auth::getAuthenticityToken() !== $token) {
        $error = true;
    }	
	if (!$error) {
		if($t_del_id!=""){
			$account->delPlayTournament($t_del_id,$reason);
		}
	}
	header("location: history.php");
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
						<a class="nav-link active black-text my-2" id="" href="history.php" aria-selected="false">History</a>
						<a class="nav-link black-text my-2" id="" href="tournament_reg.php" aria-selected="false">Registrations</a>
					</div>
				</div>
				<div class="col-md-10 ">
					<div class="table-responsive">
						<table class="table" style="overflow-x:auto" id="table1">
							<thead class=" teal lighten-5">
								<tr>
									<th>#</th>
									<th>Tournament Name</th>
									<th>Sprots Type</th>
									<th>Tournament Management Name</th>
									<th>Tournament start date</th>
									<th>Tournament end date</th>
									<th>Tournament Entry start date</th>
									<th>Tournament Entry end date</th>
									<th>Is Withdrawable?</th>
									
									
									<th>Tournament venues</th>
									<th>Categories</th>
									<th class="text-center">Actions</th>
									<th class="text-center"></th>
								</tr>
							</thead>
							<tbody>
								<?php $cDate=date('Y-m-d');$i=1;foreach($result as $key=>$val){
									$w_reason="";
									if($val['withdraw_reason']!=""){
										$w_reason="( ".$val['withdraw_reason']." )";
									}
									echo "<tr>";
									echo "<td>".$i++."</td>";
									echo "<td>".$val['tournament_name']."</td>";
									echo "<td>".$val['sports_type']."</td>";
									echo "<td>".$val['management_name']."</td>";
									echo "<td>".$val['t_start_date']."</td>";
									echo "<td>".$val['t_end_date']."</td>";
									echo "<td>".$val['entry_start_date']."</td>";
									echo "<td>".$val['entry_end_date']."</td>";
									echo "<td>".$val['is_withdrawable']."".$w_reason."</td>";
									
									
									echo "<td>".$val['venue_name']."</td>";
									$categories=$account->getRegCategories($val['id']);
									echo "<td>";
									foreach($categories as $k=>$v){
										if($v['is_fix_published']==1){
											echo '<a href="fixtures_view.php?t_id='.$val['id'].'&cat_id='.$v['category_id'].'" class="btn btn-default btn-sm p-1">'.$v['category_name'].'</a>';
										}else{
											echo "<a type='button' class='btn warning-color-dark btn-sm p-1' title='Fixture is not yet generated'>".$v['category_name']."</a> ";
										}
										//echo $v['category_name'].", ";
									}
									echo "</td>";
									if($val['is_reg_complete']==0){
										echo "<td><a href='t_schedule_details.php?id=".$val['id']."&status=".$val['is_reg_complete']."' class='btn btn-sm btn-default text-white p-2'>Edit</a></td><td></td>";
									}else{
										if($val['entry_end_date']>=$cDate){
											echo "<td><a href='t_schedule_details.php?id=".$val['id']."' class='btn btn-sm btn-default text-white p-2'>Postpone</a></td>";
											echo "<td><button class='btn btn-sm btn-default p-2 del_tournament m-0' id='del_tournament' data-toggle='modal' data-target='#delete_tournament' id1='".$val['id']."'>Cancel</button></td>";
										}else{
											echo "<td></td><td></td>";
										}
									}
									echo "</tr>";
								} ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal fade" id="delete_tournament" tabindex="-1" role="dialog" aria-labelledby="delete_tournament" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form action="history.php" method="post">
									<div class="modal-body">
										<input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo auth::getAuthenticityToken(); ?>">
										<input autocomplete="off" type="hidden" id="t_del_id" name="t_del_id">
										<div class="form-group row">
											<div class="col-sm-12">
												<div class="md-form mt-0">
													<h4 class="h4-responsive">Are you sure that you want to delete this tournament?</h4>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<div class="md-form mt-0">
													<label for="reason">Reason</label>
													<input type="text" id="reason" name="reason" class="form-control" required />
												</div>
											</div>
										</div>
									</div>	
									<div class="modal-footer">
										<div class="row">
											<div class="col-md-12">
												<ul class="bio1 pl-0">
													<li><button type="submit" class="btn btn-default btn-sm">Yes</button></li>
													<li><button type="button" class="btn btn-info clear btn-sm" data-dismiss="modal">Close</button></li>
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<script>
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
});
</script>