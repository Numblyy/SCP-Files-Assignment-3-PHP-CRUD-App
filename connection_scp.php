<?php

    include "credentials.php";
    
    // Create an object of the mysql class (this enables conntection to a sql database)
    $connection = new mysqli("localhost", $user, $pw, $db);
    
    // select all records from our table kenworth
    $records = $connection->prepare("select * from scp"); 
    
    // Run the command
    $records->execute();
    
    // Save the results into a variable
    $result = $records->get_result();

?>