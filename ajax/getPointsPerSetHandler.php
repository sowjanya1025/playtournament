<?php	
	require 'db.php';
	$con=Connect();
	
//	if(isset($_POST['point_type_id'],$_POST['no_sets_id'])) {
		$point_list="";
		$point_type_id=$_POST['point_type_id'];
		$no_sets_id=$_POST['no_sets_id'];
		$point_list = '<option value="" selected disabled><strong>Points per sets</strong></option>';
        $stmt = "SELECT * FROM `points_mins_per_set` where set_types_id='".$no_sets_id."' and point_types_id='".$point_type_id."' ";
		$result=mysqli_query($con,$stmt);
		/* $stmt->bindParam(":point_type_id", $point_type_id, PDO::PARAM_INT);
		$stmt->bindParam(":no_sets_id", $no_sets_id, PDO::PARAM_INT); */
        if ($result) {
				while ($row=mysqli_fetch_assoc($result)){
					$point_list.= '<option value="'.$row['id'].'">'.$row['points'].'</option>';
				}
       
        }
		echo $point_list;
	//}		
	
?>