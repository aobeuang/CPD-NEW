
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>


<div>
	<?php echo $output; ?>
</div>

<script>
$("#field-passwd").attr("placeholder", "รหัสผ่านจำเป็นต้องมี A-Z อย่างน้อย 1 ตัวอักษร").blur();
</script>
