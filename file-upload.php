<?php
$conn = new mysqli("localhost","root","","freethinker");
if(isset($_POST['submit']))
{
	$extension=array('jpeg','jpg','png','gif','pdf');
	foreach ($_FILES['image']['tmp_name'] as $key => $value) {
		$filename=$_FILES['image']['name'][$key];
		$filename_tmp=$_FILES['image']['tmp_name'][$key];
		echo '<br>';
		$ext=pathinfo($filename,PATHINFO_EXTENSION);
		$phone=$_POST['phone'];

		$finalimg='';
		if(in_array($ext,$extension))
		{
			if(!file_exists('images/'.$filename))
			{
			move_uploaded_file($filename_tmp, 'images/'.$filename);
			$finalimg=$filename;
			}else
			{
				 $filename=str_replace('.','-',basename($filename,$ext));
				 $newfilename=$filename.time().".".$ext;
				 move_uploaded_file($filename_tmp, 'images/'.$newfilename);
				 $finalimg=$newfilename;
			}
			$creattime=date('Y-m-d h:i:s');
			//insert
			$insertqry="INSERT INTO `multiple-images`( `image_name`, `image_createtime`,`phone`) VALUES ('$finalimg','$creattime','$phone')";
			mysqli_query($conn,$insertqry);

			header('Location: pay.html');
		}else
		
		{
			//display error
		}
	}
}
?>