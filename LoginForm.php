<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) 
{
        
        $username = $_POST['username'];
        $password = $_POST['password'];


        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "Webpage";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT username FROM LoginPage WHERE username = ? LIMIT 1";
            $Insert = "INSERT INTO LoginPage(username, password) values(?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($resultUsername);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ss",$username, $password);
                if ($stmt->execute()) {
                     
                   
                   header('location: http://localhost/insta%20project/index.html');
                }
                
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this Username.";
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
