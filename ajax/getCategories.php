<?php	
	require 'db.php';
	$con=Connect();
	
    $config_path=$_SERVER['DOCUMENT_ROOT'];
	
	$cat_list="";
	$cat_id=$_POST['cat_id'];
	$subcat_id=$_POST['category'];
	$reporting_time='';
	$min_no_entries=$_POST['min_no_entries'];
	$fee=$_POST['fee'];
	$venue=$_POST['venue'];
	$td_id=$_POST['td_id'];
	$venue_list="";
	$stmt1 = "SELECT id,venue_no,venue_name FROM `tournament_venues` where tournament_details_id='".$td_id."'";
	$res1=mysqli_query($con,$stmt1);
    if($res1){
		if(mysqli_num_rows($res1)>0){
			while ($row=mysqli_fetch_assoc($res1)){
				$venue_list.='<option value="'.$row['id'].'"  selected><strong>'.$row['venue_name'].'</strong></option>';
			}
        }
    }

	$query1="insert into tournament_categories(reporting_time,min_no_entries,fee,tournament_venues_id,subcategory_id,tournament_details_id) values('".$reporting_time."','".$min_no_entries."','".$fee."','".$venue."','".$subcat_id."','".$td_id."')";
	$result1=mysqli_query($con,$query1);
		
	if($result1){
	   /* include($config_path.'/sportsbook/helpers/init.php');  
    	$account = new account($dbo);
		$account->tournament_grade($td_id,$subcat_id);
		$account->close();*/
		$query2="SELECT  tc.*,subcat.subcategory_name,subcat.category_id,tv.venue_no,tv.venue_name FROM `tournament_categories` tc LEFT JOIN tournament_subcategory_master_table subcat on tc.subcategory_id=subcat.id LEFT JOIN tournament_venues tv on tc.tournament_venues_id=tv.id WHERE tc.tournament_details_id='".$td_id."' and subcat.category_id='".$cat_id."' ";
		$result2=mysqli_query($con,$query2);
		if($result2){
			if(mysqli_num_rows($result2)>0){
				while ($row2=mysqli_fetch_assoc($result2)){
					$cat_list.= '<div class="form-row"><div class="form-group col-sm-2"><span class="form-check form-check-inline"><select class="browser-default custom-select" name="category" id="category" readonly><option value="'.$row2['subcategory_id'].'" selected><strong>'.$row2['subcategory_name'].'</strong></option></select></span></div><div class="form-group col-sm-2"><input type="text" class="form-control" name="min_no_entries" id="min_no_entries" placeholder="Min no. of entries" readonly value="'.$row2['min_no_entries'].'"></div><div class="form-group col-sm-2"><input type="text" class="form-control" name="fee" id="fee" placeholder="Fee" value="'.$row2['fee'].'" readonly></div><div class="form-group col-sm-2"><select id="venue" class="browser-default custom-select" name="venue" readonly><option value="'.$row2['tournament_venues_id'].'" selected><strong>'.$row2['venue_name'].'</strong></option></select></div><div class="form-group col-sm-1"><button type="button" class="btn btn-sm bg-default text-white del p-2" id1="'.$cat_id.'" id="'.$row2['id'].'"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>';
				}
			}
		}
		$subcat_list="";
		$stmt = "SELECT * FROM `tournament_subcategory_master_table` where category_id='".$cat_id."'";
		$result=mysqli_query($con,$stmt);
		if ($result) {
			while ($row=mysqli_fetch_assoc($result)){
				$query3="SELECT tc.*,subcat.subcategory_name,subcat.category_id FROM `tournament_categories` tc left JOIN tournament_subcategory_master_table subcat on tc.subcategory_id=subcat.id WHERE tc.subcategory_id='".$row['id']."' and tc.tournament_details_id='".$td_id."'";
				$result3=mysqli_query($con,$query3);
				if($result3){
					if(mysqli_num_rows($result3)<=0){
						$subcat_list.= '<option value="'.$row['id'].'">'.$row['subcategory_name'].'</option>';
					}
				}
			}
		}
		$cat_list.= '<div class="form-row"><div class="form-group col-sm-2"><span class="form-check form-check-inline"><select class="browser-default custom-select" name="'.$cat_id.'category" id="'.$cat_id.'category" required ><option value="" selected><strong>Select Category</strong></option>'.$subcat_list.'</select></span></div><div class="form-group col-sm-2"><input type="text" class="form-control" name="'.$cat_id.'min_no_entries" id="'.$cat_id.'min_no_entries" placeholder="Min no. of entries" required ></div><div class="form-group col-sm-2"><input type="text" class="form-control" name="'.$cat_id.'fee" id="'.$cat_id.'fee" placeholder="Fee" required></div><div class="form-group col-sm-2"><select id="'.$cat_id.'venue" class="browser-default custom-select" name="'.$cat_id.'venue" required >'.$venue_list.'</select></div><div class="form-group col-sm-1"><button type="button" class="btn btn-sm bg-default text-white add p-2" id1="'.$cat_id.'"><i class="fa fa-plus" aria-hidden="true"></i></button><button type="button" class="btn btn-sm bg-default text-white p-2" id="del"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>';
		echo $cat_list;
	}else{
		  echo("Error description: " . mysqli_error($con));
	}
	
	
?>