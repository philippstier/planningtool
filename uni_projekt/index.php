<?php 
$host_name = 'db5008997918.hosting-data.io';
$database = 'dbs7595365';
$user_name = 'dbu2036219';
$password = 'Uni_projekt2022';

$link = new mysqli($host_name, $user_name, $password, $database);

?>
<html>
<head>
<link rel="stylesheet" href="design.css">
</head>
<body>

<?php 

$sql = 'SELECT * FROM movies';
$result = $link->query($sql);
echo '<a href="read.php">Zur Filmsuche</a><br>';
echo 'Bisher eingelesene Filme: ';
echo '<table><tr><th>Titel</th><th>Erscheinungsjahr</th><th>Regisseur</th><th>Dauer(Minuten)</th><th>Keywords</th></tr>';
while($row = mysqli_fetch_assoc($result)) {
    echo '<tr><td>'.$row[title].'</td><td>'.$row[release_year].'</td><td>'.$row[director].'</td><td>'.$row[runtime].'</td><td>'. $row['keywords'] .'</td></tr>';
    // <td><img class="table_image" src="'.$row[image].'"></td>
}
echo '</table>';


$sql = 'SELECT * FROM shows';
$result = $link->query($sql);
echo '<br><br>';
echo 'Bisher eingelesene Serien: ';
echo '<table><tr><th>Titel</th><th>Erscheinungsjahr</th><th>Ersteller</th><th>Staffeln</th><th>Keywords</th></tr>';
while($row = mysqli_fetch_assoc($result)) {
    echo '<tr><td>'.$row[title].'</td><td>'.$row[release_year].'</td><td>'.$row[creator].'</td><td>'.$row[number_of_seasons].'</td><td>'. $row['keywords'] .'</td></tr>';
    // <td><img class="table_image" src="'.$row[image].'"></td>
}
echo '</table>';
?>

</body>
</html>