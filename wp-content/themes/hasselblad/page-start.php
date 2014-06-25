<?php
/*
Template Name: Start
*/
?>
<?php get_header(); ?>
  

 <div id="hassel-page-wrap">

<?php 

get_template_part('hassel','poster'); 
$poster_post_id = hassel_get_poster_id();
$poster_title_align = get_post_meta($poster_post_id,'_hassel_meta_poster_title_align', true );
$poster_style =  $poster_title_align == "right" ? "float:left;" : "float:right;";
?>
<div class="page-start" id="hassel-card-area" style="<?php echo $poster_style ?>"> <!-- post-area-->
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

    <?php get_template_part("hassel","loop-card"); ?>


</div><!-- Hassel post-area-->
</div><!-- Hassel page-wrap-->
  

    
<?php next_posts_link('<p class="view-older">View Older Entries</p>') ?>
<?php get_footer(); ?>