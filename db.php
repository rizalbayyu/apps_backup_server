<?php 

if($_POST["action"] == "database")
{
    $string = $_POST["folder_name"];
    $prefix = '/home/';
    $index = strpos($string, $prefix) + strlen($prefix);
    $fixWord = substr($string, $index);

    $servername = "localhost";
    $username = "devops";
    $password = "devops!@#";
    $dbname = "repo";
   
// Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    } else {


        $date = date("Y-m-d");
        $timestamp = date("H:i:s");

        // $result = mysqli_query($conn, "SELECT repo_id FROM nama_repo WHERE repo_id = '$fixWord'");

        // $num_rows = mysql_num_rows($result);
    
        if (mysqli_query($conn, "INSERT INTO nama_repo VALUE ('$fixWord', '$date', '$timestamp', ' ')") === true ) {

            echo "Repo_id ", $fixWord ," sudah disimpan pada database";
        
        } elseif (mysqli_query($conn, "SELECT repo_id FROM nama_repo WHERE repo_id='$fixWord'")) {
            mysqli_query($conn, "UPDATE nama_repo SET `date`='$date' WHERE repo_id='$fixWord'");
            mysqli_query($conn, "UPDATE nama_repo SET `time`='$timestamp' WHERE repo_id='$fixWord'");
            echo "Update backup berhasil";

        } else {

            echo "Error: ", mysqli_query($conn, "INSERT INTO nama_repo VALUE ('$fixWord')"), " itu errornya";

        }

    }

}

?>