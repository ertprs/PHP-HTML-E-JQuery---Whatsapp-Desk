<?php


	session_start();
	
    header("Content-type: text/html; charset=utf-8");
	
	// PROVISÓRIO
	// SERÁ A $_SESSION QUE VIRÁ DO LOGIN
    if ( !isset($_SESSION['email_cli'])) {
	 //   header("Location: index.php");
	}
	// ***********************************
	
	else {
		
		include("../dbcon.php");
		
		$sql = "SELECT * FROM botconfig LIMIT 1";
		
		$result = mysqli_query($con,$sql);
		
		while($rows = mysqli_fetch_assoc($result)){
			
			  $vetor[] = array_map(null, $rows); 
   
		}

					
		echo json_encode($vetor);
				
		mysqli_close($con);
		
	}

?>
