<!-- -> The Loop -->
<?php global $post;?>
  <?php if ($wp_query->have_posts()) : ?>
  <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?> 
        
        <?php 
        if( apply_filters('hassel_loop_conditional','') != 'no'){
          hassel_card_small($post);
        }
        ?>
         
  <?php endwhile; ?>
  <?php else : ?>
  <?php endif; ?>

  <?php wp_reset_query() ?> 

<!-- <- The Loop -->