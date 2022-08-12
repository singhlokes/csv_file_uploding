<?php 
//Template Name:csv file uploading
get_header();
?>
<!-- multiple="false" -->
<!-- csv data uploade and show insert data on database -->
<div class="container">
	<?php
	if(isset($_POST['submit'])){
		//this getting the csv file	
	    $file = $_FILES['file']['name'];
	    //prefix any name or 
	    $file_data = $_FILES['file']['tmp_name']; 
	    //Open uploaded CSV file with read-only mode
	    $handle = fopen($file_data, "r");
	    // Skip the first line
	    fgetcsv($handle); 
	    while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
	    	//print_r($filesop);
	    	$email = $filesop[3]; 
	    	$checkEmail = $wpdb->get_results("SELECT * FROM `student_file` WHERE `email`='$email'");
	    	// echo "<pre>";
	    	// print_r($checkEmail);
	    	if ($checkEmail) {
	    		$result = $wpdb->update('student_file', array('name'=>$_POST['name'],'password'=>$_POST['password'], 'address'=>$_POST['address'],'email'=>$_POST['email']), array('id' => $id), array('%s','%d', '%s', '%s'),
 				array('%d'));
	    	} else {
	    		// insert
	    		$data = array(	    		
	 	           'name' => $filesop[0],
	 	           'password' => $filesop[1],
		           'address' => $filesop[2],
	 	           'email' => $filesop[3],       
			 	 );		       
			 	$res=$wpdb->insert('student_file' , $data );
	    	} 	
    		
    	}
		fclose($handle);
		if($res==true){
	        echo " csv uploading sucessfully";
        }else{
        	echo "Repeate csv folder .... ";
        }  
	    
	}
	    	
	?>
	<div class="text-center">
    	<form method="post" enctype="multipart/form-data">
    		<input type="file" name="file" id="file"   accept=".csv" />
    		<input type="submit" name="submit" value="import csv" />
		</form>    	
    </div>    
</div>
<hr><br>
<!-- csv data show on front page -->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form method="POST">
				<div class="text-center"><h2>CSV Record Show</h2></div>
			<table border="1">
				<tr>
					<th>Id</th>				
					<th>Name</th>
					<th>password</th>
					<th>Address</th>
					<th>Email</th>			
				
				</tr>
				<?php
					global $wpdb;
					$table= 'student_file';
					$result = $wpdb->get_results("SELECT * FROM $table");			
					if(!empty($result)){
					foreach ( $result as $resultData ) {   //here $result is an array
													// $print variable is for current row		
 				?>
				<tr>
				<td><?php echo $resultData->id ;?></td>
				<td><?php echo $resultData->name; ?></td>
				<td><?php echo $resultData->password ;?></td>
				<td><?php echo $resultData->address; ?></td>
				<td><?php echo $resultData->email ?></td>			
				
				</tr>
				<?php
				}
				} 
				?>
			</table>
			</form>
		</div>
	</div>
</div>	
<!-- end showing data here -->
