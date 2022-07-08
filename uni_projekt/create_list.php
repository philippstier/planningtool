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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  

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

           <br /><br />  
           <div align="center">
           <h3 >Watchlist erstellen</h3><br />
           <p name="saved_text" id="saved_text"></p>
           <input type="text" id="listName" name="listName" style="width: 250px;" class="form-control" placeholder="Name der Liste" />  
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
            if (data == 1) {
        		$('#saved_text').append("Liste gespeichert");  
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