<?php
$start = microtime(true);
//error_reporting(0);
$framework = FALSE;
require("includes/bootstrap.php");
$_SESSION['current_levels'] = $current_levels = @explode("-", $_GET['level']);
if(isset($current_levels[0]) && isset($current_levels[1]))
{
	bootstrap();
	$framework = TRUE;
	if($current_levels[0] > $_SESSION['level_setup']['total_levels'])
	{
		header("Location: 1-1");
	}
	if($current_levels[1] > $_SESSION['level_setup']['level_structure'][$current_levels[0]-1])
	{
		header("Location: " . $current_levels[0] . "-1");
	}
} else {
	$_SESSION['level_setup'] = json_decode(file_get_contents("levels/level_meta.json"), true);
	$page = @$_GET['level'];
	if($page == "") $page = "home";
	//if($page == "nameconverter") $inline = TRUE;
}
ob_start('minify');
?>
<!DOCTYPE html>
<html>
<head>
	<title>MandarinMaster.net</title>
	<link rel="apple-touch-icon" href="images/ios-icon.png"/>
	<meta name="viewport" content = "width = device-width, maximum-scale = 1" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/font-awesome.css">
	<!--[if IE 7]>
	  <link rel="stylesheet" href="css/font-awesome-ie7.css">
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="css/mm-main.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="js/jquery.ubaplayer.min.js"></script>
	<?php if($framework) { ?> 
		<script src="js/jquery.mousewheel.js"></script>
		<script src="js/jquery.knob.js"></script>
		<script src="js/mm-framework.js.php"></script>
		<script src="js/mm-block.js"></script>
		<link rel="stylesheet" type="text/css" href="css/mm-block.css">
		<link rel="stylesheet" type="text/css" href="css/mm-framework.css.php">
	<?php } ?>
	<script src="js/mm-main.js"></script>
</head>
<body>
<div class="left-menu">
	<div class="logo-bar">
		<img src="images/logo.png" alt="">
	</div>
	<div class="menu-container">
		<div class="search">

		</div>
		<div class="menu-items">
			<ul>
				<li><a href="#logbook"><i class="icon-book"></i> Log Book</a></li>
				<li><a href="#awards"><i class="icon-trophy"></i> Awards</a></li>
				<li>
					<i class="icon-pencil"></i> Lessons</a>
					<ul>
						<?php
						for ($i = 1; $i <= $_SESSION['level_setup']['total_levels']; $i++) {
							echo "<li><a href=\"" . $i . "-1\"><i class=\"icon-chevron-right\"></i> Lesson " . $i . "</a><li>";
						}
						?>
					</ul>
				</li>
			</ul>
			<h4>Tools</h4>
			<ul>
				<li><a href="nameconverter"><i class="icon-refresh"></i> Name Convertor</a></li>
				<li><a href="dictionary"><i class="icon-refresh"></i> Dictionary</a></li>
				<li><a href="memshape"><i class="icon-picture"></i> MemShape</a></li>
			</ul>

			<h4>Fun</h4>
		</div>
	</div>
</div>
<div class="top-menu">
	<div class="user-details">
		<i class="icon-camera-retro"></i> Users Name
	</div>
</div>
<div class="content">

	<?php if($framework) { ?> 
		<div id="framework-header">

			<div class="current-level">
				<i class="icon-pencil"></i> Lesson <span id="curLevel"><?php echo $current_levels[0]; ?></span>
			</div>

			<span id="sublevels" style="margin-left: 5px;">
			<?php
				for ($i = 1; $i <= $_SESSION['level_setup']['level_structure'][$current_levels[0]-1]; $i++) {
					echo "<div class=\"sublevel\"><a id=\"subLevelLink_".$i."\" href=\"javascript:changeSubLevel('" .  $i . "');\">" . $i . "</a></div>";
				}
			?>
			</span>

			<div class="level-progress">
				<input id="level-progress" class="knob" data-fgColor="#FF9900" data-thickness=".4" readonly value="0">
			</div>

			<div id="current-points"></div>

			<div class="level-header">
				<?php render_level_header(TRUE); ?>
			</div>

			<div style="clear: both;"></div>

		</div>

		<div id="levelframework">

			<div id="audio"></div>

			<?php
			for ($i = 1; $i <= $_SESSION['level_setup']['total_levels']; $i++) {
				for ($i2 = 1; $i2 <= $_SESSION['level_setup']['level_structure'][$i-1]; $i2++) {
					if($_SESSION['level_setup']['load_from_cache'][$i-1][$i2-1] )
					{
						if(file_exists("cache/level" . $i . "-" . $i2 . ".html"))
						{
							include_once("cache/level" . $i . "-" . $i2 . ".html");
						} else {
							render_sublevel($i, $i2, true);
						}
					} else {
						render_sublevel($i, $i2);
					}
				}
			}
			?>

			<div id="levels" currentlevel="<?php echo $current_levels[0]; ?>" currentsublevel="<?php echo $current_levels[1]; ?>"></div>

			</div>
		</div>

	<?php } else if($page) { 
			include_once("pages/$page.php");
		 } ?>
</div>

</body>
<?php
if($_SERVER['SERVER_NAME'] == "localhost")
	{
	?>
	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
	<?php
	}
?>
</html>
<?php
echo "Execution Time: " . ( microtime(true) - $start ) . " seconds";

function minify($buffer)
{
	//return str_replace(array("\n", "\t", "\r"), "", $buffer);
	return $buffer;
}
?>