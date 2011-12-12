<?php
add_action('genesis_after_post_content', 'lr_related');

function lr_related(){
  if(genesis_get_custom_field('_lr_related_title') !== 'none') { ?>
  <div id="related-content">
    <h3><a href="<?php echo genesis_get_custom_field('_lr_related_link'); ?>"><?php echo genesis_get_custom_field('_lr_related_title'); ?></a></h3>
    <?php if(genesis_get_custom_field('_lr_related_image') !== 'none') { ?>
      <a href="<?php echo genesis_get_custom_field('_lr_related_link'); ?>"><img alt="<?php echo genesis_get_custom_field('_lr_related_title'); ?> Image" src="<?php echo genesis_get_custom_field('_lr_related_image'); ?>"></a>
    <?php } ?>
    <p class="related-description"><?php echo genesis_get_custom_field('_lr_related_description'); ?></p>
  </div>
   <?php  } 
   }
   
genesis();

?>
