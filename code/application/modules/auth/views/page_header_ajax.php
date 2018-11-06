<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>E-Document</title>
	<link type="text/css" rel="stylesheet" href="/assets/default/css/theme.css" />
	<link type="text/css" rel="stylesheet" href="/assets/default/css/bootstrap.min.css" />
	
	<link type="text/css" rel="stylesheet" href="/assets/grocery_crud/themes/bootstrap/css/font-awesome/css/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="/assets/grocery_crud/themes/bootstrap/css/common.css" />
	<link type="text/css" rel="stylesheet" href="/assets/grocery_crud/themes/bootstrap/css/general.css" />

<!-- 	<script src="/assets/grocery_crud/js/jquery-1.11.1.min.js"></script> -->
	<script src="/assets/grocery_crud/js/jquery-3.3.1.js"></script>
<!--       <script src="https://code.jquery.com/jquery-3.3.1.js"></script>  	 -->
	
	<script src="/assets/default/js/bootstrap.min.js" type="text/javascript"></script>
    <?php if (ENVIRONMENT == 'production'):?>
        <script src="/assets/grocery_crud/themes/bootstrap/build/js/global-libs.min.js"></script>
    <?php else:?>
        <script src="/assets/grocery_crud/themes/bootstrap/js/jquery-plugins/jquery.form.js"></script>
        <script src="/assets/grocery_crud/themes/bootstrap/js/common/cache-library.js"></script>
        <script src="/assets/grocery_crud/themes/bootstrap/js/common/common.js"></script>
    <?php endif?>	
	

	<?php
		// Add any javascripts
		if( isset( $javascripts ) )
		{
			foreach( $javascripts as $js )
			{
				echo '<script src="' . $js . '"></script>' . "\n";
			}
		}

		if( isset( $final_head ) )
		{
			echo $final_head;
		}
	?>
</head>
<body>

<?php $current_url = $_SERVER['REQUEST_URI'];?>



