<?php
// dbs
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "checklists"; 

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST['query'])) {
    $query = $_POST['query'];

    
    $result = $conn->query($query);

    if ($result === false) {
        
        echo "<div class='alert alert-danger' role='alert'>Error: " . $conn->error . "</div>";
    } else {
        
        if ($result->num_rows > 0) {
            
            echo "<table class='table'>";
            $row = $result->fetch_assoc();
            echo "<tr>";
            foreach ($row as $key => $value) {
                echo "<th>$key</th>";
            }
            echo "</tr>";
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            
            echo "<div class='alert alert-info' role='alert'>0 results</div>";
        }
    }
} else {
    echo "<div class='alert alert-info' role='alert'>No query provided</div>";
}

// close connection
$conn->close();
?>