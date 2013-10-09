<?php
$pos = block_config_val('vocab_block', $block_id, 'block_pos', $sub_block_id); 
?>
<div id="vb<?php echo $block_id; ?>_<?php echo $sub_block_id; ?>" class="vocab_block" style="top: <?php echo $pos['y']; ?>px;
 left: <?php echo $pos['x']; ?>px; <?php 
 	if(block_config_val('vocab_block', $block_id, 'block_border', -1) != NULL) 
 		echo "border: ". block_config_val('vocab_block', $block_id, 'block_border', -1) ."; padding: 10px;"; ?>">

	<div class="pronounciation"><?php echo block_config_val('vocab_block', $block_id, 'block_pronoun', $sub_block_id); ?></div>
	<div class="chinese"><?php echo block_config_val('vocab_block', $block_id, 'block_chinese', $sub_block_id); ?></div>
	<?php if(block_config_val('vocab_block', $block_id, 'block_translation', $sub_block_id) != NULL) { ?>
	<div class="translation"><?php echo block_config_val('vocab_block', $block_id, 'block_translation', $sub_block_id); ?></div>
	<?php } if(block_config_val('vocab_block', $block_id, 'block_sound', $sub_block_id) != NULL) { ?>
	<ul class="controls">
        <li><a class="audioButton" href="sounds/vocab/<?php 
        echo block_config_val('vocab_block', $block_id, 'block_sound', $sub_block_id); ?>.mp3"></a></li>
    </ul>
    <?php } ?>
</div>

