<?php 
	$config_path=$_SERVER['DOCUMENT_ROOT'];
include_once($config_path.'/msa/sportsbook/views/sub-views/pt_header.php'); 
	
	$result="";
	$error = false;
	$admin = new admin($dbo);
	//$tournamentList=$admin->getTournamentList();
	//print_r($tournamentList);

	$t_id=0;$cat_id=0;
	if(isset($_GET['t_id'])){
		$t_id=$_GET['t_id'];
	}
	if(isset($_GET['cat_id'])){
		$cat_id=$_GET['cat_id'];
	}

	if($t_id!=0 && $cat_id!=0){
		//get no of rows that contains tbd
		$no_tbd_rows=$admin->getNoTBDRows($t_id,$cat_id);
		$no_tbd_rows1=$no_tbd_rows;
		while($no_tbd_rows>0){
			//get all the rows after tbd
			$result=$admin->optimizeCourtTime($t_id,$cat_id);
			
			$no_matches=count($result);
			$count=$no_matches;
			$match_id_initial=$result[$count-1]['match_id'];

			$i=0;$j=1;
			
			$match_id1=$result[$i]['match_id'];
	
		
		
			while($no_matches>0){
				
				if($j<$count){
					$match_id2=$result[$j]['match_id'];
					$match_start_time2=$result[$j]['match_start_time'];
					$match_end_time2=$result[$j]['match_end_time'];
					$match_date2=$result[$j]['match_date'];
					$court_id2=$result[$j]['court_id'];
					$umpire_id2=$result[$j]['umpire_id'];
				}
				
				$admin->updateNextMatchCourtTime($match_id1,$match_start_time2,$match_end_time2,$match_date2,$court_id2,$umpire_id2);
				
				
				$match_id1=$match_id2;
				
				
				
				
				$i++;$j++;
				$no_matches--;
			}

			$admin->updateCurMatchCourtTime($match_id_initial);
			$no_tbd_rows--;
		} 
		
		if($no_tbd_rows1>0){
			$admin->pushTBDPlayers($t_id,$cat_id);
		}
		
	}

	
	

	
	
//print_r($result);

	header("Location: fixtures.php");
	exit; 

?>