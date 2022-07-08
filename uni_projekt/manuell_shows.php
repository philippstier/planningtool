

<?php
  $host_name = 'db5008997918.hosting-data.io';
  $database = 'dbs7595365';
  $user_name = 'dbu2036219';
  $password = 'Uni_projekt2022';
  
  $link = new mysqli($host_name, $user_name, $password, $database);
  
  $list = file_get_contents('https://imdb-api.com/API/AdvancedSearch/k_5uzf76tt?title_type=tv_series,tv_miniseries&keywords=star%20wars&count=250');
  $list = json_decode($list, true);
  
  
  for ($i = 0; $i<count($list["results"]); $i++) {
      
      $save_response = file_get_contents('https://imdb-api.com/en/API/Title/k_5uzf76tt/'. $list["results"][$i]["id"] .'/');
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
      echo $title.' - ';
      
      
      if ($result == true) {
          echo 'Erfolgreich gespeichert';
      } else {
          echo 'Speichern nicht erfolgreich';
      }
      echo '<br>';
  }
  

  
  //echo $sql;
  
  //$result = $link->query($sql);
  
  //var_dump($result);
  
?>