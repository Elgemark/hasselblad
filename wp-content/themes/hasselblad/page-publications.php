<?php
/*
Template Name: Publications
*/
?>

<?php global $post ?>
<?php get_header(); ?>
  
    <div id="hassel-page-wrap">

      <?php get_template_part('hassel','poster'); ?>

      <div id="hassel-page" class="page-post-type">
          <div id="hassel-page-left">

            <?php 

              add_filter('hassel-pagination','hassel_pagination');
              hassel_loop_post_type_page($post);
              remove_filter('hassel-pagination','hassel_pagination');
            ?>
                <div id="hassel-card-area" class="page-root">


                  <?php
                  wp_reset_query();
                   $args = array(
                      'post_type'=>'publication_post',
                      'orderby'=>'menu_order',
                      'order'=>'ASC',
                      'posts_per_page'=>-1
                      );
                    $wp_query = new WP_Query($args);
                    if($wp_query->found_posts < 7){
                      get_template_part('hassel','loop-card'); 
                    }else{
                      get_template_part('hassel','loop-card-small'); 
                    }
                  ?>
                </div>
              </div> <!-- hassel-page-left -->
            
              <div id="hassel-card-area" class="page-post-type">
              
              <?php

              wp_reset_query();
              $first_parent = hassel_get_post_for_level(0);
              $post_parent = $post->post_parent > 0 ?  $post->post_parent  : $post->ID;
              if($first_parent){
                $post_parent = $first_parent->ID;
              }
              
              $args = array(
                'post_type'=>'page',
                'post_parent'=>$post_parent,
                'orderby'=>'menu_order',
                'order'=>'ASC',
                'posts_per_page'=>-1
                );
              $wp_query = new WP_Query($args);
              
              if ($post->post_parent != 0){ 
                add_filter('hassel-sub-loop','hassel_loop_sub_nav_page');
              }else{
                add_filter('hassel-pagination','hassel_pagination');
              }
              hassel_make_sticky(hassel_get_post_for_level(1), $wp_query);
              get_template_part('hassel','loop-card');
              remove_filter('hassel-sub-loop','hassel_loop_sub_nav_page');
              remove_filter('hassel-pagination','hassel_pagination');
                ?>
          </div> <!-- hassel-card-area -->

          

      </div> <!-- hassel-page -->
    </div> <!--hassel-page-wrap-->

<?php get_footer(); ?>