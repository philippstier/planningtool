<?php
  $host_name = 'db5008997918.hosting-data.io';
  $database = 'dbs7595365';
  $user_name = 'dbu2036219';
  $password = 'Uni_projekt2022';
  
  $link = new mysqli($host_name, $user_name, $password, $database);
  
  $list = file_get_contents('https://imdb-api.com/API/AdvancedSearch/k_5uzf76tt?title=Transformers&count=250');
  $list = json_decode($list, true);
  
  
  for ($i = 0; $i<count($list["results"]); $i++) {
      
      $save_response = file_get_contents('https://imdb-api.com/en/API/Title/k_5uzf76tt/'. $list["results"][$i]["id"] .'/');
      $save_response = json_decode($save_response, true);
      $runtime = $save_response["runtimeMins"];
      
      
      if ($runtime > 75) {
          $title = $save_response["title"];
          $year = $save_response["year"];
          $director = $save_response["directors"];
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
          //echo '<br>';
          
          $result = $link->query($sql);
          echo $title.' : ';
          var_dump($result);
          echo '<br>';
      }
  }
  

  
  //echo $sql;
  
  //$result = $link->query($sql);
  
  //var_dump($result);
  
?>