<?php
$host_name = 'db5008997918.hosting-data.io';
$database = 'dbs7595365';
$user_name = 'dbu2036219';
$password = 'Uni_projekt2022';
$link = new mysqli($host_name, $user_name, $password, $database);

//var_dump($_POST);

$json = $_POST["json"];

$list_id = $json[0];
$start_date = $json[1];
$end_date = $json[2];
$days = $json[3];




$tester = true;

$sql = 'INSERT INTO plan (list_id, start_date, end_date) VALUES ('.$list_id.', "'.$start_date.'", "'.$end_date.'");';
$result = $link->query($sql);

if ($result != true) {
    $tester = false;
}



$select = 'SELECT plan_id FROM plan order by plan_id DESC LIMIT 1;';
$result = $link->query($select);
$row = mysqli_fetch_row($result);
$last_id = $row[0];

 

for ($i=0;$i<count($days); $i++) {
    $sql_days = 'INSERT INTO plan_day (plan_id, day_id) VALUES ('.$last_id.', '.$days[$i].');';
    
    $result_insert = $link->query($sql_days);
    
    if ($result_insert != true) {
        $tester = false;
    }
}

if ($tester == true) {
    echo $last_id;
} else {
    echo 'false';
}


?>