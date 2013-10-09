<?php ?>
<div class="levelobjective" id="level<?php echo $level; ?>_<?php echo $sub_level; ?>_objective" 
	<?php if($level == 1 && $sub_level == 1) {} else { echo "style=\"display: none;\""; } ?>>
<?php
    $json = "
    {
        \"image\": {
            \"image_file\": [
                \"images/level-header-panda.png\"
            ],
            \"block_pos\": [
                {
                    \"x\": 10,
                    \"y\": 10
                }
            ],
            \"image_size\": [
                {
                    \"w\": 170,
                    \"h\": \"auto\"
                }
            ]
        }
    }";
	$blocks = inline_blocks_register($json);
	//echo $blocks['js'];
	//echo $blocks['css'];
	echo $blocks['html'][0];
    if(file_exists("levels/level" . $level . "-" . $sub_level . ".json"))
    {
	   $level_data = json_decode(file_get_contents("levels/level" . $level . "-" . $sub_level . ".json"), true);
    }
?>
	<p class="lh_bubble lh_speech"><?php if(isset($level_data)) echo $level_data['level_header']['header_text']; ?></p>
</div>