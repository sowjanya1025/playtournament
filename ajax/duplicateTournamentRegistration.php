<?php	
	require 'db.php';
	$con=Connect();
	
//	if(isset($_POST['point_type_id'],$_POST['no_sets_id'])) {
		$num_rows=0;
		$start_date=$_POST['start_date'];
		$end_date=$_POST['end_date'];
       // $stmt = "SELECT * FROM `points_mins_per_set` where set_types_id='".$no_sets_id."' and point_types_id='".$point_type_id."' ";
        $stmt = "SELECT * FROM `tournament_details` where  (t_start_date<='".$start_date."' and t_end_date>='".$end_date."')  OR ('".$start_date."' between t_start_date and t_end_date) OR ('".$end_date."' between t_start_date and t_end_date) OR (t_start_date>='".$start_date."' and t_end_date<='".$end_date."') ";
		$result=mysqli_query($con,$stmt);
		$msg="Someone has already registered the tournament ";
        if ($result) {
			$num_rows=mysqli_num_rows($result);
			while ($row=mysqli_fetch_assoc($result)){
				$msg.= 'from '.$row['t_start_date'].' to '.$row['t_end_date'].' and ';
			}
        }
		$msg.=" If you still want to proceed please click on save button.";
		echo json_encode(array($num_rows,$msg));
	//}		
	
?>