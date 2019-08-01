<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);
include "function.php";

?>

<!DOCTYPE html>
<html>
<head>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
	<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

  	<style type="text/css">
  	body {
		background-color:#1d1d1d !important;
		font-family: "Asap", sans-serif;
		color:#989898;
		margin:10px;
		font-size:16px;
	}

	#demo {
	  height:100%;
	  position:relative;
	  overflow:hidden;
	}


	.green{
	  background-color:#6fb936;
	}
    .thumb{
	    margin-bottom: 30px;
	    }
	        
    .page-top{
	    margin-top:85px;
    }

   
	img.zoom {
	    width: 100%;
	    height: 200px;
	    border-radius:5px;
	    object-fit:cover;
	    -webkit-transition: all .3s ease-in-out;
	    -moz-transition: all .3s ease-in-out;
	    -o-transition: all .3s ease-in-out;
	    -ms-transition: all .3s ease-in-out;
	}
        
 
	.transition {
	    -webkit-transform: scale(1.2); 
	    -moz-transform: scale(1.2);
	    -o-transform: scale(1.2);
	    transform: scale(1.2);
	}
    .modal-header {
    	border-bottom: none;
	}
    .modal-title {
        color:#000;
    }
    .modal-footer{
      display:none;  
    }
  	</style>
</head>

<body>
	</table>
  	<div class="container page-top">
        <?php
        include "gallery-content.php";
        ?> 
    </div>
    <form method="post" action="" enctype="multipart/form-data" id="form1" name="form1">
        <input type="file" name="image" id="image">
        <button type="button" name="add" id="add">Add</button>	
    </form>
<hr>	

</div>
</body>

<script type="text/javascript">
	$("#add").click(function(e){
		var formData = new FormData();
		formData.append('image', $('input[type=file]')[0].files[0]);

		var data3 = 'image='+ image;
		if(image==''){
			alert("empty");
		}else{
			$.ajax({
				processData:false,
				contentType:false,
				type:"post",
				url:"ajax1.php?action=imgdata",
				data:formData,
				success:function(result){
					$(".container").html(result);
				}
			});
		}
	});
	$(document).ready(function(){
  	$(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });
    
    $(".zoom").hover(function(){
		$(this).addClass('transition');
	}, function(){
		$(this).removeClass('transition');
	});
	});
</script>

</html>