<?php
add_action('genesis_after_post_content', 'lr_related');

function lr_related(){
  $related_title = genesis_get_custom_field('_lr_related_title');
  $related_image = genesis_get_custom_field('_lr_related_image');
  if ($related_title == '') { ?>
    <!-- no related -->
  <?php } else { ?> 
  <div id="related-content">
    <h3><a href="<?php echo genesis_get_custom_field('_lr_related_link'); ?>"><?php echo genesis_get_custom_field('_lr_related_title'); ?></a></h3>
    <?php if($related_image == '') { ?>
    <!-- no image -->
  <?php } else { ?> 
      <a href="<?php echo genesis_get_custom_field('_lr_related_link'); ?>"><img alt="<?php echo genesis_get_custom_field('_lr_related_title'); ?> Image" src="<?php echo genesis_get_custom_field('_lr_related_image'); ?>"></a>
    <?php } ?>
    <p class="related-description"><?php echo genesis_get_custom_field('_lr_related_description'); ?></p>
  </div>
   <?php  } 
   }
   
genesis();

?>
