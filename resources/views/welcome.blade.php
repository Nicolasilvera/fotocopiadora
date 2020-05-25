<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<script>
$(document).ready(function(){
  $("button").click(function(){
    $.getJSON("http://jsonplaceholder.typicode.com/todos",function(result){
      $.each(result, function(i, field){
        $("#contenedor").append("<div style='background-color: red; color: white; margin-left:30%; width: 40%;'><h3>ID:"+field['id']+ "</h3><h1>"+field['title']+"</h1><p>"+field['completed']+"</p></div>");
      });
    });
  });
});
</script>
</head>
<body>
 
<button>Get JSON data</button>
<div id="contenedor">
	
</div>
 
</body>
</html>