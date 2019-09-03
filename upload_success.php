<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<h3>File uploaded successfully!</h3>

<ul>
	<?php foreach($upload_data as $item => $value): ?>
	<li><?php echo $item; ?>: <?php echo $value; ?></li>
	<?php endforeach; ?>
</ul>

<p><?php echo anchor('upload','Upload another file'); ?></p>

</body>
</html>