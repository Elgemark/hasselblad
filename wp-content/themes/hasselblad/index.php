
<?php get_header(); ?>
  


<div id="post-area"> <!-- post-area-->
<?php get_template_part('hassel','poster'); ?>
<!-- -> The Query -->
  <?php
  $wp_query = new WP_Query(array(
      'post_type' => array('post','page','award_winner_post','stipend_post','newsletter_post','appropriation_post','exhibition_post'),
      'meta_query' => array(
                       array(
                        'key' => '_hassel_meta_is_card_front',
                        'value' => 'yes'
                        )
                      )
  ));
  ?>
  <!-- <- The Query -->
  <!-- -> The Loop -->
  <?php get_template_part("hassel","loop"); ?>
  <!-- <- The Loop -->
</div><!-- post-area-->
  

    
<?php next_posts_link('<p class="view-older">View Older Entries</p>') ?>
<?php get_footer(); ?>