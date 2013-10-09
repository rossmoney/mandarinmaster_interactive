<?php
$pos = block_config_val('sound_block', $block_id, 'block_pos', $sub_block_id); 
?>
<div id="sb<?php echo $block_id; ?>_<?php echo $sub_block_id; ?>" class="sound_block" style="position: absolute; top: <?php echo $pos['y']; ?>px;
 left: <?php echo $pos['x']; ?>px;">
	<ul class="controls">
        <li><a id="sb_file<?php echo $block_id; ?>_<?php echo $sub_block_id; ?>" class="audioButton" href="sounds/vocab/<?php 
        echo block_config_val('sound_block', $block_id, 'file', $sub_block_id);  ?>.mp3"></a></li>
    </ul>
</div>

