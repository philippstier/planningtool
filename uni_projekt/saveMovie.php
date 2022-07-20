<?php

$host_name = 'db5008997918.hosting-data.io';
$database = 'dbs7595365';
$user_name = 'dbu2036219';
$password = 'Uni_projekt2022';

$link = new mysqli($host_name, $user_name, $password, $database);

$json = $_POST["json"];


$tester = true;

$sql = 'INSERT INTO list (name) VALUES ("'.$json[0]["name"].'")';
$result = $link->query($sql);
if ($result != true) {
    $tester = false;
}
$select = 'SELECT list_id FROM list order by list_id DESC LIMIT 1;';
$result = $link->query($select);
$row = mysqli_fetch_row($result);
$last_id = $row[0];
for($i = 1; $i<count($json); $i++) {
    $insert = 'INSERT INTO movie_list_conn (movie_id, list_id) VALUES ('.$json[$i]["movie"].', '. $last_id .')';
    $result_insert = $link->query($insert);
    
    if ($result_insert != true) {
        $tester = false;
    } else {
        $tester = $last_id;
    }
    
}

echo $tester;

?>