<?php
header("content-type: text/css");
chdir("..");
require("includes/bootstrap.php");
bootstrap();
?>

.current-level {
	width: 200px;
	height: 40px;
	box-shadow: 1px 1px 0px 0px #ccc;
	background-color: #FFF;
	text-align: center;
	display: inline-block;
}

.sublevel {
	width: 40px;
	height: 40px;
	box-shadow: 1px 1px 0px 0px #ccc;
	background-color: #FFF;
	text-align: center;
	display: inline-block;
	margin-right: 5px;
}

.level-progress {
	background-color: #FFF;
	display: inline-block;
	width: 130px;
	height: 130px;
	box-shadow: 1px 1px 0px 0px #ccc;
	float: right;
}

.level-header {
	position: relative;
}

#levelframework {
	width: 800px;
	height: 550px;
  	position: relative;
	background-color: lightgrey;
	border: 1px dashed black;
	font-family: Arial;
	margin-top: 50px;
}

.nav {
	bottom: 5px;
	position: absolute;
	width: 100%;
}

.nextLevel {
	float: right;
}

.prevLevel {
	float: left;
}

<?php 

if(!$cache) block_css(false, true); 
include_once("blocks/level_header.css");

?>