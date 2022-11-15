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
if(isset($_SESSION['td_id'])){
	$td_id=$_SESSION['td_id'];
}else{
	header("location: t_schedule_details.php");
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
						<a class="nav-link active black-text my-2" id="" href="index.php" aria-selected="false">Registration</a>
						<a class="nav-link black-text my-2" id="" href="history.php" aria-selected="false">History</a>
					</div>
				</div>
				<div class="col-md-10 box-2">
					<h3 class="text-center text-default"><strong>Whatsapp link</strong></h3>
					<h3 class="deepa-6"><strong>Link for Tournament Registration:</strong></h3>
					<div class="form-row">
						<div class="form-group col-md-12">
							<p>https://www.mysportsarena.com/sportsbook/views/profile/cat_selection.php?t_id=<?php echo $td_id; ?></p>
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

<script>
$(function(){
	$("#no_umpires").change(function(){
		var umpires="";
		var no_umpires=$(this).val();
		var no_courts='<?php echo $no_courts; ?>';
		if(parseInt(no_courts)!=parseInt(no_umpires)){
			$("#umpire_err").html("The number of umpires u have choosen is not equal to the number of courts("+no_courts+") you have selected. Please make sure that the number of umpires is equal to the number of courts");
		}else{
			$("#umpire_err").html("");
		}
		var i=1;
		while(no_umpires>0){
			umpires+='<div class="form-row"><div class="form-group col-md-12"><h5 class="deepa-6">Umpire'+i+':</h5></div><div class="form-group col-md-4"><label for="fullname'+i+'">Full name:</label><input type="text" class="form-control" name="fullname'+i+'" id="fullname'+i+'" /></div><div class="form-group col-md-4"><label for="username'+i+'">Username:</label><input type="text" class="form-control" name="username'+i+'" id="username'+i+'"/></div><div class="form-group col-md-4"><label for="password'+i+'">Password:</label><input type="password" class="form-control" name="password'+i+'" id="password'+i+'"/></div></div>';
			no_umpires--;
			i++;
		}
		$("#umpires_details").html(umpires);
	});
	/* $("#submit").click(function(){
		
	}); */
});

</script>