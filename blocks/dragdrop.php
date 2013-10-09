<?php
$position = block_config_val('dragdrop', $block_id, 'block_pos', $sub_block_id); 
$item_count = block_config_val('dragdrop', $block_id, 'item_count', -1);
$vocab = block_config_val('dragdrop', $block_id, 'vocab', $sub_block_id);
$pairs = block_config_val('dragdrop', $block_id, 'pairs', -1);
?>
<div id="<?php echo $block_id; ?>_<?php echo $sub_block_id; ?>dragdrop" class="dragdrop" 
	style="top: <?php echo $position['y'] + 2; ?>px; left: <?php echo $position['x'] + 2; ?>px;" 
	count="<?php echo $item_count; ?>" sBlock="<?php echo $block_id; ?>" word="<?php echo $pairs[$sub_block_id]; ?>"><?php echo $vocab; ?></div>
<div class="dropslot" word="<?php echo $sub_block_id + 1; ?>" style="top: <?php echo $position['y']; ?>px; left: <?php echo $position['x']; ?>px;"></div>
