<?php
$pos = block_config_val('multiple_choice', $block_id, 'block_pos', -1); 
?>
<div id="answer" style="display: none;"></div>
<div id="mc<?php echo $block_id; ?>_<?php echo $sub_block_id; ?>" mcSnippetBlock="<?php echo $block_id; ?>" 
	class="multiple_choice" style="top: <?php echo $pos['y']; ?>px; left: <?php echo $pos['x']; ?>px;" 
	choiceCount="<?php echo block_config_val('multiple_choice', $block_id, 'answer_num', -1); ?>" 
	insID="<?php echo $sub_block_id; ?>">
 	<?php 
 	for($i = 0; $i < block_config_val('multiple_choice', $block_id, 'answer_num', -1); $i++)
 	{
 		?>
 		<div id="choice<?php echo $i+1; ?>" class="choice" choice="<?php echo $i+1; ?>">
 			<div class="numberchoice"><?php echo $i+1; ?></div>
			<div class="mc_pronounciation" id="mc_pronounciation_<?php echo $i+1; ?>">
				<?php echo block_config_val('multiple_choice', $block_id, 'block_pronoun', $i); ?></div>
 		</div>
 		<?php
 	}
 	?>
</div>
