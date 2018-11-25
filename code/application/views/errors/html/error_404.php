<?php
defined('BASEPATH') OR exit('No direct script access allowed');




?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">
body {
    background: #dedede;
}
.page-wrap {
    min-height: 100vh;
}
</style>
</head>
<body>


	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->

	<div class="page-wrap d-flex flex-row align-items-center">
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12 text-center">
	            <span class="display-1 d-block"><?php echo $heading; ?></span>
	            <div class="mb-4 lead"><?php echo $message; ?></div>
	            <a href="<?php echo site_url('/'); ?>" class="btn btn-link">กลับสู่หน้าหลัก</a>
	        </div>
	    </div>
	</div>
	</div>
</body>
</html>