<?php
$pos = block_config_val('text', $block_id, 'block_pos', $sub_block_id); 
$text = block_config_val('text', $block_id, 'text', $sub_block_id);
$fontsize = block_config_val('text', $block_id, 'font_size', $sub_block_id);
$id_attr = @block_config_val('text', $block_id, 'id_attr', -1);
$additional = "";
if(isset($id_attr)) $additional = " id=\"" . $id_attr . "\" ";
?>
<div <?php if(isset($additional)) echo $additional; ?> class="textblock" style="position: absolute; font-size: <?php echo $fontsize; ?>px; top: <?php echo $pos['y']; ?>px; left: <?php echo $pos['x']; ?>px;" >
	<?php echo str_replace("|", "<br />", $text); ?>
</div>