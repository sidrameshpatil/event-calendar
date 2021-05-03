<?php
include "database/config.php";
include "includes/functions.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $eventId = $conn->real_escape_string($_POST["id"]);
    

    // calling the remove element defined in functions.php
    if(removeEvent($eventId)){
        echo true;
    }else{
        echo false;
    }
}
?>