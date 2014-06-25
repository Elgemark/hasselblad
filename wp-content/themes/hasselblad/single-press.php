

<?php 
global $post;
global $hassel_is_root;
?>
<?php get_header(); ?>
  

    <div id="hassel-page-wrap">

      <?php get_template_part('hassel','poster'); ?>

      <div id="hassel-page">

            <div id="hassel-posts">
              <?php get_template_part('hassel','loop-page'); ?>
            </div>

            
            <?php 
            wp_reset_query();
            $section_post = hassel_section_for_post($post);
            $args = array(
                        'post_type' => 'press_post',
                        'post_parent' => $section_post->post_parent,
                        'order_by'=>'page_order',
                        'order' =>'ASC'
                      );
                  $wp_query = new WP_Query( $args );

                  
                  

                  if($wp_query->have_posts()){
                    echo '<div id="hassel-card-area" class="page-post-type ">';
                      add_filter('hassel-sub-loop','hassel_loop_sub_nav_page');
                      if($wp_query->found_posts < 5){
                        get_template_part('hassel','loop-card'); 
                      }else{
                        $hassel_is_root  = false;
                        get_template_part('hassel','loop-card-small'); 
                      }
                          remove_filter('hassel-sub-loop','hassel_loop_sub_nav_page');
                     echo "</div>";
                   }
              ?>
            


      </div>
    </div>  

 


<?php get_footer(); ?>