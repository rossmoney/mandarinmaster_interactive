<?php
	global $vocab_pos;
	global $placed_header;
	if(!$placed_header) 
	{
		/*echo "
		<div style=\"margin: 0 auto; width: 430px;\">
			<p class=\"vocab_header\" id=\"vocab_header_" . $block_id . "\">New Vocabulary</p>
		</div>";*/
		echo "<table class=\"vocab_table\" id=\"vocab_table_" . $block_id . "\" cellpadding=\"0\" cellspacing=\"0\">";
		$placed_header = true;
		$vocab_pos = 0;
	} 
	$english = block_config_val('vocabulary', $block_id, 'english', -1);
	$chinese = block_config_val('vocabulary', $block_id, 'chinese', -1);
	$block_pos = block_config_val('vocabulary', $block_id, 'block_pos', -1);
	echo '<tr>';
	for($i2 = 0; $i2 < $block_pos[$sub_block_id]; $i2++)
	{
		
		echo '<td width="100"><img src="images/plus.png" width="30" /></td>';
		echo '<td width="160">' . $chinese[$vocab_pos+$i2] . '</td>';
		echo '<td width="260">' . $english[$vocab_pos+$i2] . '</td>';
	}
	$vocab_pos = $vocab_pos + $block_pos[$sub_block_id];
	echo '</tr>';
	if($vocab_pos == count($english)) 
	{
		echo '</table>';
		$placed_header = false;
	}
?>
