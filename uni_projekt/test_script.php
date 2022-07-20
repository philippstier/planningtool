<?php
$host_name = 'db5008997918.hosting-data.io';
$database = 'dbs7595365';
$user_name = 'dbu2036219';
$password = 'Uni_projekt2022';
$link = new mysqli($host_name, $user_name, $password, $database);


$sql = 'SELECT show_id, imdb_id, number_of_seasons AS seasons FROM shows';
$result = $link->query($sql);

while($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i<= $row["seasons"]; $i++) {
        $save_response = file_get_contents('https://imdb-api.com/en/API/SeasonEpisodes/k_5uzf76tt/'. $row["imdb_id"] .'/'.$i);
        $save_response = json_decode($save_response, true);
        
       // var_dump($save_response);
        
        for ($x = 0; $x<count($save_response["episodes"]); $x++) {
            $insert = 'INSERT INTO episode (title, season, episode_number, show_id, imdb_id) VALUES (';
            $insert .= '"'.$save_response["episodes"][$x]["title"].'"';
            $insert .= ', '.$i;
            $insert .= ', '.$save_response["episodes"][$x]["episodeNumber"];
            $insert .= ', '.$row["show_id"];
            $insert .= ', "'.$save_response["episodes"][$x]["id"].'");';
            
            echo $insert.'<br><br>';
            
            $result_insert = $link->query($insert);

            
            if ($result_insert == true) {
                echo 'Erfolgreich gespeichert';
            } else {
                echo 'Speichern nicht erfolgreich';
            }
            echo '<br> -------------------- <br>';
        }

    }

}




?>