

<div id="google_element">Choose Language</div>
<?php
	$phone = $_POST['phone'];
	$password = $_POST['password'];

	$conn = new mysqli("localhost","root","","freethinker");
	if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}else{
		$stmt = $conn->prepare("SELECT phone From signup Where phone = ?" );
		$stmt = $conn->prepare("SELECT password From signup Where password =? ");
		
		$stmt->bind_param("i",$phone );
		$stmt->bind_param("s",$password);
		
		$stmt->execute();
		$stmt->bind_result($password);
		$stmt_result = $stmt-> get_result();
		if( $stmt_result ->num_rows > 0){
			$data = $stmt_result->fetch_assoc();
			if($data['password'] == $password)
			{
				echo "<h2>Login Successfully </h2>";
				echo "<script> location.href='loader.html'; </script>";
			
			$stmt = $conn->prepare("INSERT Into login ( phone,password)Values(?,?)");
			$stmt->bind_param("is",$phone,$password);
			$stmt->execute();	 
			}		
		}
			

		else{
			echo "<h2>Invalid Phone no or password</h2>";

		}
	}


