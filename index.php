<?php
include_once 'partials/header.php';
include_once 'includes/Calendar.php';
include_once 'database/config.php';


// get the year from url or take the current year
if(isset($_GET['year']) && $_GET['year'] != ''){
    $year = $_GET['year'];
}else{
    $year = date('Y');
}

// creating calendar class object
$calendar = new Calendar($year);
?>

<div class="container">
    <div class="row mt-3">
        <h1>Calendar <?=$year?></h1>
    </div>
    

    <div class="row">
        <div class="col-6">
            <label>Select the year</label>
            <select class="yearSelector">
            <?php echo $calendar->getYearList(); ?>
            </select>
        </div>

        <div class="col-6 ">

             <!-- Add event section -->
            <div class="addEvent">

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">Add Event</button>

            <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add new Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addEventForm">
                            <div class="form-group">
                                <label>Event Name</label>
                                <input name="eventName" class="form-control"></input>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="eventDescription" class="form-control my-2" placeholder="Event description"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Date</label>
                                <input name="eventDate" class="form-control" type="date"></input>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>


   


    <!-- this section adds all months to calendar -->
    <div class="row">
        <?php
            for($month=1;$month<=12;$month++){
               
        ?>

                <div class="col-md-3 my-5 mx-2">
                    <?php
                        $daysInMonth = $calendar->getDaysInMonth($month);
                        $firstDayOfCurrentMonth = $calendar->firstDayOfMonth($month);

                    ?>  
                        <div class="monthTitle mb-3"><h4><?=$numberToMonth[$month]?></h4></div>
                        <div class="monthBox">
                            <div class="monthItem dayName">Mon</div>
                            <div class="monthItem dayName">Tue</div>
                            <div class="monthItem dayName">Wed</div>
                            <div class="monthItem dayName">Thu</div>
                            <div class="monthItem dayName">Fri</div>
                            <div class="monthItem dayName">Sat</div>
                            <div class="monthItem dayName">Sun</div>

                            <?php
                                for($i=1;$i<$firstDayOfCurrentMonth;$i++){
                                    echo "<div class='monthItem'></div>";
                                }

                                for($i=1;$i<=$daysInMonth;$i++){

                                    // the whichDay() method of calendar object returns
                                    // return 0 if its today
                                    // return 1 if its upcoming day
                                    // returns -1 if its passed day
                                    $whichDay = $calendar->whichDay($month, $i);
                                    $checkEvents = $calendar->checkEvents($month, $i);
                                    $date = $calendar->year."-".$month."-".$i;
                                    $linkToEvents = $ROOT."events.php?date=".$date;



                                    if($whichDay == 0){
                                    ?>
                                        <div class="monthItem bg-danger text-light">
                                            <a href="<?=$linkToEvents?>">
                                                <?=$i?>
                                            </a>
                                        </div>
                                    <?php
                                    }
                                    else if($checkEvents && $whichDay == 1){
                                    ?>
                                        <div class="monthItem bg-primary text-light">
                                            <a href="<?=$linkToEvents?>">
                                                <?=$i?>
                                        </a>
                                        </div>
                                    <?php
                                    }
                                    else if($checkEvents && $whichDay == -1){
                                    ?>
                                        <div class="monthItem bg-secondary text-light">
                                            <a href="<?=$linkToEvents?>">
                                                <?=$i?>
                                        </a>
                                        </div>
                                    <?php
                                    }
                                    else{
                                        echo "<div class='monthItem'>".$i."</div>";
                                    }
                                }
                            ?>
                        </div>
                </div>
        <?php
            }
        ?>
    </div>
<div>

<script>

    // this is the path of the calendar project in server root directory
    const ROOT = "/calendar/";
        
    // selecting the add event form
    let addEventForm = document.getElementById("addEventForm");
    addEventForm.addEventListener('submit', addNewEvent);

    
    // this function makes ajax request with data to add new event
    async function addNewEvent(e){
        e.preventDefault();
        let formData = new FormData(e.target);
        let res = await fetch(ROOT+"addEvent.php",{
            method:"POST",
            body:formData
        });

        if(res.ok){
            alert("Event Added");
            location.reload();
        }
    }



    let yearSelector = document.querySelector('.yearSelector');
    yearSelector.addEventListener('change', changeYear);


    // Function which fires when the user changes the year in dropdown
    function changeYear(e){
        let changedYear = e.target.value;
        window.location.href = ROOT+"index.php?year="+changedYear;
    }
</script>

<?php
include "partials/footer.php";
?>