<?php 
$position = block_config_val('image', $block_id, 'block_pos', $sub_block_id); 
$size = block_config_val('image', $block_id, 'image_size', $sub_block_id); 
$file = block_config_val('image', $block_id, 'image_file', $sub_block_id);
?>
<img style="height:auto; width:auto; max-width: <?php echo $size['w']; ?>px; max-height: <?php echo $size['h']; ?>px; 
top: <?php echo $position['y']; ?>px; left: <?php echo $position['x']; ?>px; position: absolute;" 
src="<?php echo $file; ?>">

<?php
/*
	"image": {
        "image_file": [
            "images/woman.png"
        ],
        "block_pos": [
            {
                "x": 320,
                "y": 130
            }
        ],
        "image_size": [
            {
                "w": 150,
                "h": "auto"
            }
        ]
    }
 */
?>