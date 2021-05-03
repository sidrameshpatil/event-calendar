<?php

if(!isset($_GET['date']) && $_GET['date'] == ''){
    header("location:/");
}
include_once "database/config.php";
include_once "partials/header.php";
include_once "includes/functions.php";


$date = $_GET['date'];


// Get events function is defined in includes/functions.php
$events = getEvents($date);

?>


<div class="container">
    <div class="row my-3">
        <h1>Events</h1>
    </div>
    <?php
        if(count($events) == 0){
            echo "<h3>no events</h3>";
        }
        foreach($events as $event){
    ?>
        <div class="row my-2">
            <h4><?=$event["eventDate"]?></h4>
            <h5><?=$event["eventName"]?></h5>
            <p><?=$event["eventDescription"]?></p>
            <div><button data-id="<?=$event["id"]?>" class="removeEventBtn">Remove</button></div>
        </div>
    <?php
        }
    ?>
</div>

<script>
    const ROOT = "/calendar/";
    let removeEventBtn = document.querySelectorAll('.removeEventBtn');

    removeEventBtn.forEach(element => {
        element.addEventListener('click', removeEvent);
    });
   

    async function removeEvent(e){
        let eventId = e.target.getAttribute("data-id");
        let formData = new FormData();
        formData.append("id", eventId);
        let res = await fetch(ROOT+"removeEvent.php",{
            method:"post",
            body:formData
        })

        let result  = await res.json();
        console.log(typeof result)
        if(result == 1){
            location.reload();
        }
    }
</script>
<?php
include_once "partials/footer.php";
?>







