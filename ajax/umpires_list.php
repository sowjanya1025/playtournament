<?php	
	require 'db.php';
	$con=Connect();
	
//	if(isset($_POST['point_type_id'],$_POST['no_sets_id'])) {
	    $row_id=$_POST['id'];
		$num_rows=0;
		$umpires_list='';
        $stmt = "SELECT * FROM umpires";
		$result=mysqli_query($con,$stmt);
        if ($result) {
			if(mysqli_num_rows($result)>0){
				$i=1;
				while ($row=mysqli_fetch_assoc($result)){
					$id=$row['id'];
					$umpires_list.='<tr><td>'.$i++.'</td><td id="name'.$id.'">'.$row['name'].'</td><td id="email'.$id.'">'.$row['email'].'</td><td id="city'.$id.'">'.$row['city'].'</td><td id="sports_type'.$id.'">'.$row['sports_type'].'</td><td id="cost'.$id.'">'.$row['cost'].'</td><td><button class="btn btn-default py-0 px-1 hire" id="'.$id.'" id1="'.$row_id.'">Hire</button></td></tr>';
				}
			}
        }
		echo $umpires_list;
	//}		
	
?>