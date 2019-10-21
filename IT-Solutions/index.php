<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<form class="form-horizontal" action="" method="">
		<div class="form-group">
			<br>
			<input type="text" name="search" class="form-control search w-25">
		</div>
		<button type="button" class="btn btn-outline-info" name="searchbtn" id="searchbtn">Search</button>
	</form>
	<br><br>
	<div id="results"></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
		$('body').on('click','#searchbtn',function(e){
		var search=$('.search').val();
		q=search;
		$.ajax({
			url: 'index1.php',
			data: {q:search},
			success: function(data){
				$('#results').html('');
				$('#results').html(data);
		  	}
		});
	});
</script>

</body>
</html>