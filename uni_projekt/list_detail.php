<?php
//Funktion um alle Daten zwischen zwei Datumswerten in einem Array zu bekommen
function getBetweenDates($startDate, $endDate)
{
    $rangArray = [];
    
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);
    
    for ($currentDate = $startDate; $currentDate <= $endDate;
    $currentDate += (86400)) {
        
        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }
    
    return $rangArray;
}

$host_name = 'db5008997918.hosting-data.io';
$database = 'dbs7595365';
$user_name = 'dbu2036219';
$password = 'Uni_projekt2022';
$link = new mysqli($host_name, $user_name, $password, $database);

$id = $_GET["id"];
$mode = $_GET["mode"];

if ($mode == 'plan') {
    

//$sql = "SELECT list.name AS list_name, movies.title AS movie_title FROM movie_list_conn LEFT JOIN list ON movie_list_conn.list_id = list.list_id LEFT JOIN movies ON movie_list_conn.movie_id = movies.movie_id where list.list_id = ".$id;
$sql = 'SELECT * FROM list WHERE list_id = '.$id;
$result = $link->query($sql);

$row = $result->fetch_array();

$list_name = $row["name"];

?>
<html>
<head>

<link rel="stylesheet" href="design.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body style="background-color: #ebebeb">
<div class="topnav">
  <p class="active">Filmplaner</p>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
    <a href="create_list.php">Film-Liste erstellen</a>
    <a href="list.php">Film-Listen ansehen</a>
    <a href="plan_show.php">Serien ansehen</a>
    <a href="read.php">Film/Serien suche</a>
  </div>
  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<div class="plan" id="plan">
<h3>Planung für Liste: <?php echo $list_name; ?></h3>
<p name="saved_text" id="saved_text"></p><br>
<div id="dates" class="dates">
<input type="hidden" id="list_id" value="<?php echo $id; ?>">
<label for="start_date">Start Datum</label> 
<input id="start_date" name="start_date" type="date">
<label for="end_date">End Datum</label> 
<input id="end_date" name="end_date" type="date">
</div>
<div class="days" id="days">
<p>Bevorzugte Tage</p>
<label for="1">Montag</label>
<input type="checkbox" id="monday" name="1"><br>
<label for="2">Dienstag</label>
<input type="checkbox" id="thursday" name="2"><br>
<label for="3">Mittwoch</label>
<input type="checkbox" id="wednesday" name="3"><br>
<label for="4">Donnerstag</label>
<input type="checkbox" id="thursday" name="4"><br>
<label for="5">Freitag</label>
<input type="checkbox" id="friday" name="5"><br>
<label for="6">Samstag</label>
<input type="checkbox" id="saturday" name="6"><br>
<label for="7">Sonntag</label>
<input type="checkbox" id="sunday" name="7">
</div>
<br>
<button  id="savePlan" class="btn-default" onclick="savePlan()">Planen</button>



</div>
<script type="text/javascript">
function savePlan() {  
    jsonObj = [];

	var list_id = $('#list_id').val();
	jsonObj.push(list_id);
    var start_date = $('#start_date').val();
    jsonObj.push(start_date);
    var end_date = $('#end_date').val();
    jsonObj.push(end_date);
    var selected = [];
    $('#plan input:checked').each(function() {
        selected.push($(this).attr('name'));
    });
    jsonObj.push(selected);
    
    console.log(jsonObj);

    $.ajax({  
        url:"save_plan.php",  
        method:"POST",  
        data:{json:jsonObj},  
        success:function(data)  
        {    
			alert(data);
            if (data != 0) {
        		window.location ='list_detail.php?id='+data+'&mode=display'
            } else {
            	$('#saved_text').append("Plan konnte nicht gespeichert werden"); 
            }
        }  
   }); 
    
    
	}


function myFunction() {
	  var x = document.getElementById("myLinks");
	  if (x.style.display === "block") {
	    x.style.display = "none";
	  } else {
	    x.style.display = "block";
	  }
	}
</script>

</body>
</html>

<?php 
} elseif ($mode == 'display') {
    
    ?> 
    <html>
    <head>
    
    <link rel="stylesheet" href="design.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <script>
     function myFunction() {
    	  var x = document.getElementById("myLinks");
    	  if (x.style.display === "block") {
    	    x.style.display = "none";
    	  } else {
    	    x.style.display = "block";
    	  }
    	}
     </script>
    </head>
    <body style="background-color: #ebebeb">
    <div class="topnav">
  <p class="active">Filmplaner</p>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
    <a href="create_list.php">Film-Liste erstellen</a>
    <a href="list.php">Film-Listen ansehen</a>
    <a href="plan_show.php">Serien ansehen</a>
    <a href="read.php">Film/Serien suche</a>
  </div>
  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
    <?php 
    
    $sql = 'SELECT * FROM plan WHERE plan_id = '.$id;
    $result = $link->query($sql);
    
    $row = $result->fetch_array();

    
    $sql_list = 'SELECT * FROM list WHERE list_id = '.$row["list_id"];

    $result_list = $link->query($sql_list);
    
    $row_list = $result_list->fetch_array(); 
    
    $sql_movies = 'SELECT * FROM movie_list_conn WHERE list_id = '.$row["list_id"];
    $result_movies = $link->query($sql_movies);

    $sql_days = 'SELECT day.name AS name FROM `plan_day` LEFT JOIN day on day.day_id = plan_day.day_id WHERE plan_day.plan_id = '.$id;
    $result_days = $link->query($sql_days);
    if (mysqli_num_rows($result_days)==0) {
        $sql_days = 'SELECT * FROM day';
        $result_days = $link->query($sql_days);
    }
    while($row_days = mysqli_fetch_assoc($result_days)) {
        $days[] = $row_days["name"];        
    }
    
    
    
    $dates = getBetweenDates($row["start_date"], $row["end_date"]);     
    

    
    while($row_movies = mysqli_fetch_assoc($result_movies)) {
        
        $sql_movie = 'SELECT * FROM movies WHERE movie_id = '.$row_movies["movie_id"];    
        
        $result_movie = $link->query($sql_movie);
        
        $row_movie = $result_movie->fetch_array();
        
        $movies[] = $row_movie;
     
    }
    
    for ($i = 0; $i<count($dates); $i++) {
        
        $day = date('l', strtotime($dates[$i]));

        if (in_array(strtolower($day), $days)) {
            $real_dates[] = $dates[$i];
        }

        
    }
    
            for ($i = 0; $i<count($movies); $i++) {
                if (isset($real_dates[$i])) {
                    $plan_element["date"] = $real_dates[$i];
                    $plan_element["movie_title"] = $movies[$i]["title"];
                    $plan_element["movie_image"] = $movies[$i]["image"];
                    $plan[] = $plan_element;
                } else {
                    $no_time[] = $movies[$i]["title"];
                }
            }

   
   echo '<table class="table table-dark">';
   echo '<tr><th>Film</th><th>Tag</th><th>Bild</th></tr>';
   for ($i = 0; $i<count($plan); $i++) {
      echo '<tr><td>'.$plan[$i]["movie_title"].'</td><td>'.$plan[$i]["date"].'</td><td><img class="img-thumbnail" style="height: 150px !important; width: auto;" src="'.$plan[$i]["movie_image"].'"></td></tr>';
   }
   echo '</table>';
   
   if (isset($no_time[0])) {
       echo '<br><p>Folgende Filme passen leider nicht in den Zeitplan:</p>';
       echo '<table class="table table-dark">';
       echo '<tr><th>Film</th></tr>';
       for ($i = 0; $i<count($no_time); $i++) {
           echo '<tr><td>'.$no_time[$i].'</td></tr>';
       }
       echo '</table>';
   }
   
   echo '</body>';
   echo '</html>';
} elseif ($mode == 'plan_show') {

    //$sql = "SELECT list.name AS list_name, movies.title AS movie_title FROM movie_list_conn LEFT JOIN list ON movie_list_conn.list_id = list.list_id LEFT JOIN movies ON movie_list_conn.movie_id = movies.movie_id where list.list_id = ".$id;
    $sql = 'SELECT * FROM shows WHERE show_id = '.$id;

    $result = $link->query($sql);
    
    $row = $result->fetch_array();
    
    $show_name = $row["title"];
    
    ?>
<html>
<head>

<link rel="stylesheet" href="design.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body style="background-color: #ebebeb">
<div class="topnav">
  <p class="active">Filmplaner</p>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
    <a href="create_list.php">Film-Liste erstellen</a>
    <a href="list.php">Film-Listen ansehen</a>
    <a href="plan_show.php">Serien ansehen</a>
    <a href="read.php">Film/Serien suche</a>
  </div>
  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<div class="plan" id="plan">
<h3>Planung für Serie: <?php echo $show_name; ?></h3>
<p name="saved_text" id="saved_text"></p><br>
<div id="dates" class="dates">
<input type="hidden" id="show_id" value="<?php echo $id; ?>">
<label for="start_date">Start Datum</label> 
<input id="start_date" name="start_date" type="date">
<label for="end_date">End Datum</label> 
<input id="end_date" name="end_date" type="date">
</div>

<div class="days" id="days">
<p>Bevorzugte Tage: </p>
<label for="1">Montag</label>
<input type="checkbox" id="monday" name="1"><br>
<label for="2">Dienstag</label>
<input type="checkbox" id="thursday" name="2"><br>
<label for="3">Mittwoch</label>
<input type="checkbox" id="wednesday" name="3"><br>
<label for="4">Donnerstag</label>
<input type="checkbox" id="thursday" name="4"><br>
<label for="5">Freitag</label>
<input type="checkbox" id="friday" name="5"><br>
<label for="6">Samstag</label>
<input type="checkbox" id="saturday" name="6"><br>
<label for="7">Sonntag</label>
<input type="checkbox" id="sunday" name="7">
</div>
<br>
<button  id="savePlan" class="btn-default" onclick="savePlan()">Planen</button>



</div>
<script type="text/javascript">
function savePlan() {  
    jsonObj = [];

	var list_id = $('#show_id').val();
	jsonObj.push(list_id);
    var start_date = $('#start_date').val();
    jsonObj.push(start_date);
    var end_date = $('#end_date').val();
    jsonObj.push(end_date);
    var selected = [];
    $('#plan input:checked').each(function() {
        selected.push($(this).attr('name'));
    });
    jsonObj.push(selected);
    
    console.log(jsonObj);

    $.ajax({  
        url:"save_plan.php",  
        method:"POST",  
        data:{json:jsonObj},  
        success:function(data)  
        {    
			alert(data);
            if (data != 0) {
        		window.location ='list_detail.php?id='+data+'&mode=display_show'
            } else {
            	$('#saved_text').append("Plan konnte nicht gespeichert werden"); 
            }
        }  
   }); 
    
    
	}


function myFunction() {
	  var x = document.getElementById("myLinks");
	  if (x.style.display === "block") {
	    x.style.display = "none";
	  } else {
	    x.style.display = "block";
	  }
	}
</script>

</body>
</html>
    
    

<?php 
} elseif ($mode == 'display_show') {
    ?>
    <html>
    <head>
    
    <link rel="stylesheet" href="design.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <script>
     function myFunction() {
    	  var x = document.getElementById("myLinks");
    	  if (x.style.display === "block") {
    	    x.style.display = "none";
    	  } else {
    	    x.style.display = "block";
    	  }
    	}
     </script>
    </head>
    <body style="background-color: #ebebeb">
    <div class="topnav">
  <p class="active">Filmplaner</p>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
    <a href="create_list.php">Film-Liste erstellen</a>
    <a href="list.php">Film-Listen ansehen</a>
    <a href="plan_show.php">Serien ansehen</a>
    <a href="read.php">Film/Serien suche</a>
  </div>
  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
    <?php 
    
    $sql = 'SELECT * FROM plan WHERE plan_id = '.$id;
    $result = $link->query($sql);
    
    $row = $result->fetch_array();

    
    $sql_list = 'SELECT * FROM shows WHERE show_id = '.$row["list_id"];

    $result_list = $link->query($sql_list);
    
    $row_list = $result_list->fetch_array(); 
    
    $sql_episodes = 'SELECT * FROM episode WHERE show_id = '.$row["list_id"];
    $result_episodes = $link->query($sql_episodes);

    $sql_days = 'SELECT day.name AS name FROM `plan_day` LEFT JOIN day on day.day_id = plan_day.day_id WHERE plan_day.plan_id = '.$id;
    $result_days = $link->query($sql_days);
    if (mysqli_num_rows($result_days)==0) { 
        $sql_days = 'SELECT * FROM day';
        $result_days = $link->query($sql_days);
    }
    while($row_days = mysqli_fetch_assoc($result_days)) {
        $days[] = $row_days["name"];        
    }
    
    
    
    $dates = getBetweenDates($row["start_date"], $row["end_date"]);     
    

    
    while($row_episodes = mysqli_fetch_assoc($result_episodes)) {
        
        
        $episodes[] = $row_episodes;
     
    }
    
    for ($i = 0; $i<count($dates); $i++) {
        
        $day = date('l', strtotime($dates[$i]));

        if (in_array(strtolower($day), $days)) {
            $real_dates[] = $dates[$i];
        }

        
    }
    
            for ($i = 0; $i<count($episodes); $i++) {
                if (isset($real_dates[$i])) {
                    $plan_element["date"] = $real_dates[$i];
                    $plan_element["episode_title"] = $episodes[$i]["title"];
                    $plan_element["episode_number"] = $episodes[$i]["episode_number"];
                    $plan[] = $plan_element;
                } else {
                    $no_time[] = $episodes[$i]["title"];
                }
            }

   
   echo '<table class="table table-dark">';
   echo '<tr><th>Film</th><th>Tag</th><th>Folgennummer</th></tr>';
   for ($i = 0; $i<count($plan); $i++) {
      echo '<tr><td>'.$plan[$i]["episode_title"].'</td><td>'.$plan[$i]["date"].'</td><td>'.$plan[$i]["episode_number"].'</td></tr>';
   }
   echo '</table>';
   if (isset($no_time[0])) {
       echo '<br><p>Folgende Folgen passen leider nicht in den Zeitplan:</p>';
       echo '<table class="table table-dark">';
       echo '<tr><th>Folge</th></tr>';
       for ($i = 0; $i<count($no_time); $i++) {
           echo '<tr><td>'.$no_time[$i].'</td></tr>';
       }
       echo '</table>';
   }
   echo '</body>';
   echo '</html>';
}
?>

