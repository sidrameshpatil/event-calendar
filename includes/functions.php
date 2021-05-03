<?php

function getEvents($eventDate){
    global $conn;
    $sql = "SELECT id, eventName, eventDescription, eventDate FROM events WHERE eventDate='$eventDate'";
    $result = $conn->query($sql);
    $events = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($events, $row);
        }
    }
    
    return $events;
}

function addEvent($event){
    global $conn;
    $eventName = $event["eventName"];
    $eventDescription = $event["eventDescription"];
    $eventDate = $event["eventDate"];


    $sql = "INSERT INTO events (eventName, eventDescription, eventDate)
    VALUES ('$eventName', '$eventDescription', '$eventDate')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function removeEvent($id){
    global $conn;
    $sql = "DELETE FROM events WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

?>