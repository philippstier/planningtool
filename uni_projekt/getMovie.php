<?php
$host_name = 'db5008997918.hosting-data.io';
$database = 'dbs7595365';
$user_name = 'dbu2036219';
$password = 'Uni_projekt2022';

$link = new mysqli($host_name, $user_name, $password, $database);

$output = '';
$sql = "SELECT * FROM movies WHERE title LIKE '%".$_POST["query"]."%' LIMIT 7";
$result = $link->query($sql);
$output = '<ul class="list-unstyled">';
if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_array($result))
    {
        $output .= '<li>'.$row["title"].'<input type="hidden" value="'. $row["movie_id"] .'"></li>';
    }
}
else
{
    $output .= '<li>Film nicht gefunden</li>';
}
$output .= '</ul>';


echo $output;  
?>