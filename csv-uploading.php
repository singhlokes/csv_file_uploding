<?php 
//Template Name:csv file uploading
get_header();
?>
<!-- multiple="false" -->
<div class="container">
    <div class="text-center">
    	<form method="post" enctype="multipart/form-data">
    		<input type="file" name="file" id="file"   accept=".csv" />
    		<input type="submit" name="submit" value="Upload" />
		</form>    	
    </div>		

	<?php
	if(isset($_POST['submit'])){
		
		//this getting the csv file	
	    $file = $_FILES['file']['name'];

	    //prefix any name or 
	    $file_data = $_FILES['file']['tmp_name'];  

	    // Open uploaded CSV file with read-only mode
	    $handle = fopen($file_data, "r");

	    // Skip the first line
	    fgetcsv($handle); 

	    while(($filesop = fgetcsv($handle, 1000, ",")) !== false){	    
	        // $name = $filesop[0];  
	        // $password = $filesop[1];     
	        // $address = $filesop[2];     
	        // $email = $filesop[3]; 
	        $data = array(
	        	// 'name' => $name,
	            'name' => $filesop[0],
	            'password' => $filesop[1],
	            'address' => $filesop[2],
	            'email' => $filesop[3],       
	        );
	        // Insert member data in the database
	        $res=$wpdb->insert('student_file' , $data );

	    }
	    if($res==true){
	        	echo " csv uploading sucessfully";
	        }else{
	        	echo "data not found ? ";
	        }
	    // Close opened CSV file
	    fclose($handle);
	}
	?>
</div>
<?php  
get_footer();
?>

