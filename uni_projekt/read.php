<?php
  $host_name = 'db5008997918.hosting-data.io';
  $database = 'dbs7595365';
  $user_name = 'dbu2036219';
  $password = 'Uni_projekt2022';

  $suche = $_GET['suche'];
  $detail = $_GET['detail'];
  
  $suche_show = $_GET['suche_show'];
  $detail_show = $_GET['detail_show'];
  
  $save = $_GET['save'];
  $save_show = $_GET['save_show'];
  
  $link = new mysqli($host_name, $user_name, $password, $database);

  if ($link->connect_error) {
    die('<p>Verbindung zum MySQL Server fehlgeschlagen: '. $link->connect_error .'</p>');
  } else {
   // echo '<p>Verbindung zum MySQL Server erfolgreich aufgebaut.</p>';
  }
/*  
  $sql = "SELECT * FROM movies";
  $result = $link->query($sql);
  
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          echo "id: " . $row["movie_id"]. " - Name: " . $row["title"]. " " . $row["release_date"]. "<br>";
      }
  } else {
      echo "0 results";
  }
  
*/
  
?>

<html>
<head>
<link rel="stylesheet" href="design.css">
<script>

</script>
</head>
<body>
<a href="index.php">Zur Übersicht</a><br>
<?php 

if (isset($save) && $save != '') {
    
    $save_response = file_get_contents('https://imdb-api.com/en/API/Title/k_5uzf76tt/'. $save .'/');
    $save_response = json_decode($save_response, true);
    
    $title = $save_response["title"];
    $year = $save_response["year"];
    $director = $save_response["directors"];
    $runtime = $save_response["runtimeMins"];
    $image = $save_response["image"];
    $id = $save_response["id"];
    $keywords = $save_response["keywords"];
    
    $sql = 'INSERT INTO movies (title, release_year, director, imdb_id, runtime, keywords, image) VALUES ("';
    $sql .= $title.'"';
    $sql .= ', '.$year;
    $sql .= ', "'.$director.'"';
    $sql .= ', "'.$id.'"';
    $sql .= ', '.$runtime;
    $sql .= ', "'.$keywords.'"';
    $sql .= ', "'.$image.'");';
    
    //echo $sql;
    
    $result = $link->query($sql);
    
    //var_dump($result);
}

echo '<form method="get" action="read.php">';

if (isset($suche) && $suche != '') {
    echo 'Suche (Filme): <input name="suche" value="'. $suche .'" type="text" id="suche"> ';
}  else {
    echo 'Suche (Filme): <input name="suche" type="text" id="suche"> ';
}
echo '<input type="submit" value="Suchen"></form>';
if (isset($suche) && $suche != '') {
    $response = file_get_contents('https://imdb-api.com/en/API/SearchMovie/k_5uzf76tt/'.$suche);
    $response = json_decode($response, true);
    //var_dump($response);
    
    for ($i = 0; $i<count($response["results"]); $i++) {
        echo '<br>Titel: '.$response["results"][$i]["title"].' '.$response["results"][$i]["description"] ;
        echo '<br>IMDB ID: '.$response["results"][$i]["id"];
        echo '<br><img class="imdb_picture" src="'. $response["results"][$i]["image"] .'"><br>'; 
        
        echo '<form method="get" action="read.php">';
        echo '<br><input type="hidden" name="detail" value="'.$response["results"][$i]["id"].'">';
        echo '<input type="submit" value="Detailierte Informationen"></form>';
        
    }
    
    
} 

if (isset($detail) && $detail != '') {
    $detail_response = file_get_contents('https://imdb-api.com/en/API/Title/k_5uzf76tt/'. $detail .'/');
    $detail_response = json_decode($detail_response, true);
    //var_dump($detail_response);
    
    echo '<br>Titel: '.$detail_response["title"].' ('.$detail_response["year"] .')';
    echo '<br>IMDB ID: '.$detail_response["id"];
    echo '<br>Directors: '.$detail_response["directors"];
    echo '<br>Stars: '.$detail_response["stars"];
    echo '<br>Laufzeit (Minuten): '.$detail_response["runtimeMins"];
    echo '<br><img class="imdb_picture" src="'. $detail_response["image"] .'"><br>';
    
    echo '<form method="get" action="read.php">';
    echo '<br><input type="hidden" name="save" value="'.$detail_response["id"].'">';
    echo '<input type="submit" value="Speichern"></form>';
    
}


//Shows

echo '<form method="get" action="read.php">';

if (isset($suche_show) && $suche_show != '') {
    echo 'Suche (Serien): <input name="suche_show" value="'. $suche_show .'" type="text" id="suche"> ';
}  else {
    echo 'Suche (Serien): <input name="suche_show" type="text" id="suche"> ';
}
echo '<input type="submit" value="Suchen"></form>';
if (isset($suche_show) && $suche_show != '') {
    $response = file_get_contents('https://imdb-api.com/en/API/SearchSeries/k_5uzf76tt/'.$suche_show);
    $response = json_decode($response, true);
    //var_dump($response);
    
    for ($i = 0; $i<count($response["results"]); $i++) {
        echo '<br>Titel: '.$response["results"][$i]["title"].' '.$response["results"][$i]["description"] ;
        echo '<br>IMDB ID: '.$response["results"][$i]["id"];
        echo '<br><img class="imdb_picture" src="'. $response["results"][$i]["image"] .'"><br>';
        
        echo '<form method="get" action="read.php">';
        echo '<br><input type="hidden" name="detail_show" value="'.$response["results"][$i]["id"].'">';
        echo '<input type="submit" value="Detailierte Informationen"></form>';
        
    }
    
    
}

if (isset($detail_show) && $detail_show != '') {
    $detail_response = file_get_contents('https://imdb-api.com/en/API/Title/k_5uzf76tt/'. $detail_show .'/');
    $detail_response = json_decode($detail_response, true);
    //var_dump($detail_response);
    
    echo '<br>Titel: '.$detail_response["title"].' ('.$detail_response["year"] .')';
    echo '<br>IMDB ID: '.$detail_response["id"];
    echo '<br>Directors: '.$detail_response["creators"];
    echo '<br>Stars: '.$detail_response["stars"];
    echo '<br>Staffeln: '.count($detail_response["seasons"]);
    echo '<br><img class="imdb_picture" src="'. $detail_response["image"] .'"><br>';
    
    echo '<form method="get" action="read.php">';
    echo '<br><input type="hidden" name="save_show" value="'.$detail_response["id"].'">';
    echo '<input type="submit" value="Speichern"></form>';
    
}


if (isset($save_show) && $save_show != '') {
    
    $save_response = file_get_contents('https://imdb-api.com/en/API/Title/k_5uzf76tt/'. $save_show .'/');
    $save_response = json_decode($save_response, true);
    
    $title = $save_response["title"];
    $year = $save_response["year"];
    $creator = $save_response["tvSeriesInfo"]["creators"];
    $seasons = count($save_response["tvSeriesInfo"]["seasons"]);
    $image = $save_response["image"];
    $id = $save_response["id"];
    $keywords = $save_response["keywords"];
    
    $sql = 'INSERT INTO shows (title, number_of_seasons, release_year, creator, imdb_id, keywords, image) VALUES ("';
    $sql .= $title.'"';
    $sql .= ', '.$seasons;
    $sql .= ', '.$year;
    $sql .= ', "'.$creator.'"';
    $sql .= ', "'.$id.'"';
    $sql .= ', "'.$keywords.'"';
    $sql .= ', "'.$image.'");';
    
    //echo $sql;
    
    $result = $link->query($sql);
    
    //var_dump($result);
    
    if ($result == true) {
        echo 'Erfolgreich gespeichert';       
    } else {
        echo 'Speichern nicht erfolgreich';
    }
}

?>


</body>
</html>