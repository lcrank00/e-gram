<?php
if (isset($_POST['submit'])) {
    if ( isset($_POST['state']) && 
        isset($_POST['district'])  && isset($_POST['taluk']) &&
        isset($_POST['village']) && 
        isset($_POST['street']) && isset($_POST['landmark']) &&
        isset($_POST['pincode']) && isset($_POST['number'])) {
        
        $country = $_POST['state'];
        $street = $_POST['district'];
        $landmark = $_POST['taluk'];
        $pincode = $_POST['village'];
        $state = $_POST['street'];
        $district = $_POST['landmark']; 
        $taluk = $_POST['pincode'];
        $village = $_POST['phone'];
                
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "freethinker";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $SELECT = "SELECT phone FROM loader WHERE phone = ?";
            $INSERT = "INSERT INTO loader(state, district, taluk, village, street, landmark, pincode, phone) values(?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("i", $phone);
            $stmt->execute();
            $stmt->bind_result($resultphone);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("sssssii",$state, $district , $taluk , $village ,  $street, $landmark, $pincode, $phone);
                echo "<script> location.href='document.html'; </script>";
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this phone.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>