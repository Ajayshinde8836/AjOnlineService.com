<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['firstname']) && isset($_POST['Lastname']) &&
        isset($_POST['password']) && isset($_POST['Confirm_Password']) &&
        isset($_POST['gender']) && isset($_POST['email']) &&
        isset($_POST['phoneCode']) && isset($_POST['phone'])) {
        
        $firstname = $_POST['firstname'];
        $Lastname = $_POST['Lastname'];
        $password = $_POST['password'];
        $Confirm_Password = $_POST['Confirm_Password'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $phoneCode = $_POST['phoneCode'];
        $phone = $_POST['phone'];

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "Webpage";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM Online WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO Online(firstname,Lastname,password,Confirm_Password,gender,email,phoneCode,phone) values(?, ?, ?, ?, ?, ? , ? ,?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssssss",$firstname, $Lastname, $password, $Confirm_Password, $gender, $email, $phoneCode, $phone);
                if ($stmt->execute()) {
                   
                   

                       header('location: http://localhost/insta%20project/LoginPage.html ');

                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
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