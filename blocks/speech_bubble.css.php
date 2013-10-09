<?php 

function speech_bubble_css($block_id) {

for($i = 0; $i < block_config_val('speech_bubble', $block_id, 'item_count', -1); $i++) {

$bs = block_config_val('speech_bubble', $block_id, 'block_pos', $i); 
$bt = block_config_val('speech_bubble', $block_id, 'bubble_text', $i);

$w = ($bs['fs'] * strlen($bt)) / 3;
if($w > 600) $w = $w / 2;
$h = (((($bs['fs']) * strlen($bt)) / $w) * $bs['fs']);

echo "p.bubble" . $block_id."_".$i . " {\n";
	echo "padding: " . ($bs['fs'] / 1.5) . "px;\n";
	echo "font-size: " . $bs['fs'] . "px;\n";
	echo "top: ". $bs['y'] . "px;\n";
	echo "left: ". $bs['x'] . "px;\n";
	echo "width: ". $w . "px;\n";
	echo "height: " . $h . "px;\n";
	echo "-webkit-border-radius: " . ($bs['fs'] + 10)  . "px;\n";
	echo "-moz-border-radius: ". ($bs['fs'] + 10)  . "px;\n";
	echo "border-radius: " . ($bs['fs'] + 10) . "px;\n";
	echo "max-width: 400px;";
echo "}";

?>

p.speech<?php echo $block_id."_".$i; ?>:before
{
	left: -<?php echo $bs['fs'] - 1; ?>px;
	top: <?php echo $h + ($bs['fs'] / 1.5) - 1; ?>px;
	border: <?php echo ($bs['fs'] * 1.3); ?>px solid;
	border-color: #666 transparent transparent #666;
	transform: rotate(30deg);
	-ms-transform: rotate(30deg); /* IE 9 */
	-webkit-transform: rotate(30deg);
}

p.speech<?php echo $block_id."_".$i; ?>:after
{
	left: -<?php echo $bs['fs'] - 8; ?>px;
	top: <?php echo $h + (($bs['fs'] / 1.5) - 2); ?>px;
	border: <?php echo ($bs['fs'] * 1.3 ) - 5; ?>px solid;
	border-color: #fff transparent transparent #fff;
	transform: rotate(30deg);
	-ms-transform: rotate(30deg); /* IE 9 */
	-webkit-transform: rotate(30deg);
}

<?php } 

}?>