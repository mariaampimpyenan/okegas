<?php

$servername = "localhost";
$dbname = "id21605377_okegas";
$username = "id21605377_admingas";
$password = "Admingas12*";

$api_key_value = "okegasmaria1";

$api_key = $lpg = $co = $co2 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if ($api_key == $api_key_value) {
        $lpg = test_input($_POST["lpg"]);
        $co = test_input($_POST["co"]);
        $co2 = test_input($_POST["co2"]);

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO sensor_data (lpg, co, co2)
        VALUES ('" . $lpg . "', '" . $co . "', '" . $co2 . "')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Wrong API Key provided.";
    }
} else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
