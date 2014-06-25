<?php
/*
Template Name: News
*/
?>



<?php global $post; ?>
<?php get_header(); ?>
  
    <div id="hassel-page-wrap">
      	<?php get_template_part('hassel','poster'); ?>
      <div id="hassel-page">
        
          <div id="hassel-posts">
      		  <?php get_template_part('hassel','loop-page'); ?>
           </div>
            
            <div id="hassel-card-area" class="page-root page-news">
             	<?php 
				$args = array(
							'post_type' => array('award_winner_post','stipend_post','newsletter_post','appropriation_post','exhibition_post','post','page'),
              'posts_per_page' => -1
						);
				$wp_query = new WP_Query( $args );
				?>
                <?php add_filter('hassel_loop_conditional','hassel_is_in_dates')?>
                <?php 
                  if($wp_query->found_posts < 5){
                    get_template_part('hassel','loop-card'); 
                  }else{
                    get_template_part('hassel','loop-card-small'); 
                  }
                  
                ?>
                <?php remove_filter('hassel_loop_conditional','hassel_is_in_dates')?>
            </div>

      </div>
    </div>


<?php get_footer(); ?>
