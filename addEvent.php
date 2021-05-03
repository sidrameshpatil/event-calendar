<?php
include "database/config.php";
include "includes/functions.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $event = array();
    $event["eventName"] = $conn->real_escape_string($_POST['eventName']);
    $event["eventDescription"] = $conn->real_escape_string($_POST['eventDescription']);
    $event["eventDate"] = $conn->real_escape_string($_POST['eventDate']);
    
    // calling the addevent function defined in functions.php
    if(addEvent($event)){
        echo true;
    }else{
        echo false;
    }
}
?>