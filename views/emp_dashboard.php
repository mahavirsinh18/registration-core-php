<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<h4>
	Welcome <?=$this->session->userdata('name')?><br>
	Your information:<br>
	E-mail: <i><?=$this->session->userdata('email')?></i><br>
	Gender: <i><?=$this->session->userdata('gender')?></i><br>
	City: <i><?=$this->session->userdata('city')?></i><br>
	Contact: <i><?=$this->session->userdata('contact')?></i>
</h4>

<form method="post" action="logout" class="form-horizontal">
	<button type="submit" class="btn btn-outline-primary">Log out</button>
</form>

</body>
</html>