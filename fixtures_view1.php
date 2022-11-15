<?php include_once('../sportsbook/views/sub-views/pt_header.php'); 
	if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {
		header('Location: ../../sportsbook/index.php');
	}
	$accountId = auth::getCurrentUserId();
	$account = new account($dbo, $accountId);
	$admin = new admin($dbo);
	$registeredTournaments=[];
	$result='';
    $error = false;
	$reg_id=0;
	if(isset($_GET['t_id'])){
		$t_id=$_GET['t_id'];
		$cat_id=$_GET['cat_id'];
		$registeredTournaments=$admin->getRegisteredTournaments($t_id,$cat_id);
		$no_players=$account->getNumbOfRegPlayers($registeredTournaments[0]['id'],$registeredTournaments[0]['subcategory_id']);
		$rounds_matches=$admin->generateRoundsMatches($registeredTournaments[0]['id'],$registeredTournaments[0]['subcategory_id'],$no_players[0]['no_players']);
		$rounds_matches_arr=explode("-",$rounds_matches);
		//print_r($rounds_matches_arr);
	}
	
	if(!empty($_POST)){
		$reg_id=isset($_POST['reg_id']) ? $_POST['reg_id'] : '';
		if($reg_id!=""){
			$account->withdrawFromTournament($reg_id);
			header("location: ../home.php");
			exit;
		}
		header("location: ../home.php");
		exit;
	}
$userDetails=$account->getUsers();
//$gender=$userDetails[0]['sex'];
//$dob=$userDetails[0]['dob'];
$cDate=date('Y-m-d');
$t_id=$registeredTournaments[0]['id'];
$venues=$account->getVenues($t_id);
$no_brackets=FLOOR(POW(2,CEIL(log($no_players[0]['no_players'],2))));
/* auth::newAuthenticityToken();
$page_id = "fixtures"; */
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
				<?php if(($registeredTournaments[0]['entry_end_date']>=$cDate)&&($registeredTournaments[0]['is_withdrawable']=='yes')) { ?>
					<input type="button" class="btn btn-default p-2 m-0" value="Withdraw" id="withdraw" data-toggle="modal" data-target="#withdraw_sec">
				<?php } ?>
				<a href="history.php" class="btn btn-default p-2 m-0">Back</a>
			</div>
		</div>
		<div class="modal fade withdraw_sec" id="withdraw_sec" tabindex="-1" role="dialog" aria-labelledby="withdraw_sec" aria-hidden="true">
			<form method="post" action="fixtures.php">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-body" id="comments">
							<h6 class="h6-responsve">Are you sure that you want to withdraw from this tournament?</h6>
							<input type="hidden" value="<?php echo $reg_id; ?>" name="reg_id" id="reg_id">
						</div>	
						<div class="modal-footer">
							<button type="submit" class="btn btn-default p-2">Submit</button>
							<button type="button" class="btn btn-info p-2" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>	
			</form>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card mt-3">
					<div class="card-header bg-warning text-white">
						<h5 class="h5-responsive"><?php echo "Tournament Name: ".$registeredTournaments[0]['tournament_name'].", Category: ".$registeredTournaments[0]['subcategory_name']."<br/><span id='winner'></span>"; ?></h5>
					</div>
					<div class="card-body">
					<main id="tournament">
						<?php $i=1;$j=1;$m=1; foreach($rounds_matches_arr as $key=>$val){
							$no_brackets=$no_brackets/2;
							$num_brackets=$no_brackets;
							$brackets=$num_brackets-$val;
							echo '<ul class="round round-'.$i.'">';
							if($key!=0 && $val==1){
								$j=0;
							}
							$fixtureDetails=$account->getFixturesDetails($registeredTournaments[0]['id'],$registeredTournaments[0]['subcategory_id'],$j);
							//print_r($fixtureDetails);
							if(!empty($fixtureDetails)){
								$k=0;
								while($val>0){
									
									$match_type=$account->getMatchType($fixtureDetails[$k]['match_type_id']);
									
									//to label semifinalist,winner and runner
										if($fixtureDetails[$k]['match_type_id']==4){
											$winner=$account->getWinner($fixtureDetails[$k]['fix_id'],"winner");
											$runner=$account->getWinner($fixtureDetails[$k]['fix_id'],"runner");
										}
										

										if($fixtureDetails[$k]['match_type_id']==3){
											if($semifinalist1==""){
												$semifinalist1=$account->getWinner($fixtureDetails[$k]['fix_id'],"semifinalist");
											}else{
												$semifinalist2=$account->getWinner($fixtureDetails[$k]['fix_id'],"semifinalist");
											}
										}
									
									$player1_color="black-text";
									$player2_color="black-text";
									if($fixtureDetails[$k]['match_status']==1){
										if($fixtureDetails[$k]['match_winner']==$fixtureDetails[$k]['player1_id']){
											$player1_color="text-default";
											$player2_color="red-text";
										}else if($fixtureDetails[$k]['match_winner']==$fixtureDetails[$k]['player2_id']){
											$player1_color="red-text";
											$player2_color="text-default";
										}else if($fixtureDetails[$k]['player1_result']=='both_absent'){
											$player1_color="red-text";
											$player2_color="red-text";
										}
									}
									
									echo '<li class="spacer">&nbsp;</li>';
									if($fixtureDetails[$k]['player1_name']==NULL){
										echo '<li class="game game-top winner li c'.$fixtureDetails[$k]['player1_id'].' " id="c'.$fixtureDetails[$k]['player1_id'].'">Winner<span><div class="dropdown float-right"><a class="text-black" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span title="Click Me">!</span></a><div class="dropdown-menu blue lighten-5"><p>'.'Venue:'.$fixtureDetails[$k]['venue_name'].'</p><p>Umpire  name: '.$fixtureDetails[$k]['ump_name'].'</p><p>Match Details: M'.$m.', '.$match_type.'</p></div></div></span></li>';
									}else{
										echo '<li class="game game-top winner '.$player1_color.' li c'.$fixtureDetails[$k]['player1_id'].' " id="c'.$fixtureDetails[$k]['player1_id'].'">'.$fixtureDetails[$k]['player1_name'].'<span><div class="dropdown float-right"><a class="text-black" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span title="Click Me">?</span></a><div class="dropdown-menu blue lighten-5"><p>'.$fixtureDetails[$k]['p_result'].'</p></div></div><div class="dropdown float-right"><a class="text-black" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span title="Click Me">!</span></a><div class="dropdown-menu blue lighten-5"><p>'.'Venue:'.$fixtureDetails[$k]['venue_name'].'</p><p>Umpire  name: '.$fixtureDetails[$k]['ump_name'].'</p><p>Match Details: M'.$m.', '.$match_type.'</p></div></div></span></li>';
									}
									
									if($fixtureDetails[$k]['match_date']=='0000-00-00'){
											$date='';
										}else{
											$date=date('d-m-Y', strtotime($fixtureDetails[$k]['match_date'])).', ';
										}
										
										if($fixtureDetails[$k]['match_start_time']=='00:00:00'){
											$time='';
										}else{
											$time=date('g:ia', strtotime($fixtureDetails[$k]['match_start_time'])).', ';
										}
									
									echo '<li class="game game-spacer">'.$date.$time.$fixtureDetails[$k]['court_id'].'</li>';
									if($fixtureDetails[$k]['player2_name']==NULL){
										echo '<li class="game game-bottom li c'.$fixtureDetails[$k]['player2_id'].'"  id="c'.$fixtureDetails[$k]['player2_id'].'">Winner</span></li>';
									}else{
										echo '<li class="game game-bottom '.$player2_color.' li c'.$fixtureDetails[$k]['player2_id'].'"  id="c'.$fixtureDetails[$k]['player2_id'].'">'.$fixtureDetails[$k]['player2_name'].'</li>';
									}
									
									$val--;
									$k++;$m++;
								}
								while($brackets>0){
									/* echo '<li class="spacer">&nbsp;</li>
									<li class="game game-top winner">- <span></span></li>
									<li class="game game-spacer">&nbsp;</li>
									<li class="game game-bottom ">-<span></span></li>';  */
									echo '<li class="spacer">&nbsp;</li>
									<li style="border-bottom:1px solid white;" class="game game-top winner"><span class="text-white">-</span></li>
									<li style="border-right:1px solid white;" class="game game-spacer">&nbsp;</li>
									<li style="border-top:1px solid white;" class="game game-bottom"><span class="text-white">-</span></li>';
									$brackets--;
								}
							}else{
								echo '<p class="text-center">Fixture is not yet generated.</p>';
								break;
							}
							echo '<li class="spacer">&nbsp;</li></ul>';
							$i++;
							$j++;
						} 
						?>
					</main>
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
	var winner='Winner: '+'<?php echo $winner; ?>';
	var runner=', Runner: '+'<?php echo $runner; ?>';
	var semifinalist1=', Semifinalists: '+'<?php echo $semifinalist1; ?>';
	var semifinalist2=', '+'<?php echo $semifinalist2; ?>';
	var semifinalist=semifinalist1+semifinalist2;
	$("#winner").html(winner+runner+semifinalist);
});
</script>