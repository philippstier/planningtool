<?php
$host_name = 'db5008997918.hosting-data.io';
$database = 'dbs7595365';
$user_name = 'dbu2036219';
$password = 'Uni_projekt2022';
$link = new mysqli($host_name, $user_name, $password, $database);

//$sql = "SELECT list.name AS list_name, movies.title AS movie_title FROM movie_list_conn LEFT JOIN list ON movie_list_conn.list_id = list.list_id LEFT JOIN movies ON movie_list_conn.movie_id = movies.movie_id";
$sql = 'SELECT * FROM list';
$result = $link->query($sql);


//var_dump($result);



?>
<html>
<head>
<link rel="stylesheet" href="design.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>





</head>
<style type="text/css">

</style>
<body style="background-color: #ebebeb">
<div align="center">
<h3>Vorhandene Listen</h3>
<?php 
while($row = mysqli_fetch_assoc($result)) {
    $select = "SELECT list.list_id, list.name AS list_name, movies.title AS movie_title FROM movie_list_conn LEFT JOIN list ON movie_list_conn.list_id = list.list_id LEFT JOIN movies ON movie_list_conn.movie_id = movies.movie_id WHERE list.list_id = ".$row['list_id'].' ORDER BY movies.release_year';
    $result_loop = $link->query($select);
    echo '<p>'. $row['name'] .'</p>';
    echo '<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#point_'. $row['list_id'] .'" aria-expanded="false" aria-controls="point_'. $row['list_id'] .'"> Ansehen </button> <a href="list_detail.php?mode=plan&id='. $row['list_id'] .'"><button class="btn btn-primary" type="button">Planen</button></a>';
    echo '<div class="collapse" id="point_'. $row['list_id'] .'">';
    echo '<br><table class="table table-striped">';
    //echo '<tr><th>Liste: '. $row['name'] .'</th></tr>';
    while($row_loop = mysqli_fetch_assoc($result_loop)) {
        echo '<tr><td>'. $row_loop['movie_title'] .'</td></tr>';
    }
    echo '</table></div><br><br>';
    
    
}
?>
</div>

</body>
</html>
<script type="text/javascript">



</script>  