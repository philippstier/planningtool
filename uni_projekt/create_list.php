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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style type="text/css">
           ul{  
                background-color:#eee;  
                cursor:pointer;  
           }  
           li{  
                padding:12px;  
           }  
</style>
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
<br>
           <br /><br />  
           <div align="center">
           <h3 >Watchlist erstellen</h3><br />
           <a href="list.php"><button class="btn-default">Listen ansehen</button></a><br>
           <p name="saved_text" id="saved_text"></p>
           <input type="text" id="listName" name="listName" style="width: 250px;" class="form-control" placeholder="Name der Liste" />  
           <br>
            <button hidden="hidden" id="saveList" class="btn-default" onclick="saveList()">Liste speichern</button>
          
           <br>
           </div>
           <div class="container" style="float: left; width:500px; margin: 20px;">  
                
                <input type="text" name="movie" id="movie" class="form-control" placeholder="Filmname eingeben" />  
                <div id="movieList"></div>  
           </div>          
           <div id="addedMovies" class="container" style="width: 800px; float: right; margin:20px;">
         
           		<table id="addedMovieList" style="width: 650px;" class="table table-striped" hidden="hidden">
           			<tr>
           				<th>Titel</th><th>Entfernen</th>
           			</tr>
           		</table>
           		
           </div>

</body>
</html>
<script type="text/javascript">

function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}

function saveList() {
    jsonObj = [];
    item = {}
    item ["name"] = $("#listName").val();
    jsonObj.push(item);
    $('tr[name="row"]').each(function() {
        var movie = $(this).children().children('input[name="movieId"]').val();

        item = {}
        item ["movie"] = movie;

        jsonObj.push(item);
    });

    console.log(jsonObj);

    $.ajax({  
        url:"saveMovie.php",  
        method:"POST",  
        data:{json:jsonObj},  
        success:function(data)  
        {    
            if (data != 0) {
            	window.location = 'list_detail.php?mode=plan&id='+data;
            } else {
            	$('#saved_text').append("Liste konnte nicht gespeichert werden"); 
            }
        }  
   }); 
    
    
	}


$(document).ready(function(){  

    $("#addedMovieList").on('click', '.btnDelete', function () {
        $(this).closest('tr').remove();
    });


    
  $('#movie').keyup(function(){  
       var query = $(this).val();  
       if(query != '')  
       {  
            $.ajax({  
                 url:"getMovie.php",  
                 method:"POST",  
                 data:{query:query},  
                 success:function(data)  
                 {  
                      $('#movieList').fadeIn();  
                      $('#movieList').html(data);  
                 }  
            });  
       }  
  });  

  
  $(document).on('click', 'li', function(){  
 	   $('#addedMovieList').attr("hidden", false);
  	   $('#saveList').attr("hidden", false);
       $('#movie').val("");
       $('#addedMovieList').append('<tr name="row"><td>'+ $(this).text() +' <input name="movieId" type="hidden" value="'+$(this).children('input').val()+'"></td><td><button class="btn-default btnDelete">X</button></td></tr>') 
       $('#movieList').html('');
       $('#movieList').fadeOut();  
  });  
 });  
</script>  