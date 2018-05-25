<?php if(!defined('BASEPATH')) exit('No direct script access allowed.');

$cssPath = base_url('assets/css').'/';
$imgPath = base_url('assets/images').'/';
$jsPath = base_url('assets/js').'/';
$plugins = base_url('assets/plugins').'/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="" name="description">
	<meta content="" name="keywords">
	<meta content="" name="author">

	<title>Checador</title>

	<link rel="stylesheet" href="<?php echo $cssPath; ?>materialize.css">
	<link rel="stylesheet" href="<?php echo $cssPath; ?>nouislider.css">
	<link rel="stylesheet" href="<?php echo $cssPath; ?>animate.css" />
	<link rel="stylesheet" href="<?php echo $plugins; ?>data_tables/datatables.css" />
	<link rel="stylesheet" href="<?php echo $cssPath; ?>style.css" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<script type="text/javascript" data-pace-options='{ "ajax": false }' src="<?php echo $jsPath; ?>pace.min.js"></script>

</head>

<body>
	<div id="app_container">