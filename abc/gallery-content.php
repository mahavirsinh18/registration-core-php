<div class="row">
    <?php
    $sql = "SELECT image FROM gallery";
	$result = $conn->query($sql);
    if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		?>
		<div class="col-lg-3 col-md-4 col-xs-6 thumb">
		<a href="<?php echo $row['image']; ?>" class="fancybox" rel="ligthbox">
			<img  src="<?php echo $row['image']; ?>" class="zoom img-fluid "  alt="">    
		</a>
		</div>
		<?php
		}
	}
    ?>
</div>