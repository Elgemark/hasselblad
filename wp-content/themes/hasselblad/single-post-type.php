  
<?php  global $post;?>
<?php get_header(); ?>



    <div id="hassel-page-wrap"> <!-- hassel-page-wrap -->

      <?php get_template_part('hassel','poster'); ?>

      <div id="hassel-page" class="page-post-type"> <!-- hassel-page -->

          <div id="hassel-page-left">

            <?php 

              add_filter('hassel-pagination','hassel_pagination');
                $section_post = get_post(hassel_section_for_post($post),false);
                hassel_loop_post_type_page($section_post);
                remove_filter('hassel-pagination','hassel_pagination');

            echo "</div>";

            echo '<div id="hassel-card-area" class="page-post-type">'; /* hassel-card-area */

              $args = array(
                'post_type'=>'page',
                // 'post_parent'=>$section_post->post_parent,
                'post_parent'=>31,
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
              hassel_make_sticky($section_post->ID, $wp_query);
              get_template_part('hassel','loop-card');
              remove_filter('hassel-sub-loop','hassel_loop_sub_nav_page');
              remove_filter('hassel-pagination','hassel_pagination');
                ?>
      
         </div> <!-- hassel-card-area -->
      </div> <!-- hassel-page -->
    </div> <!-- hassel-page-wrap -->
 


<?php get_footer(); ?>