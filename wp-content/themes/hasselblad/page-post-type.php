<?php
/*
Template Name: Post Type
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

              echo "</div>";
            
              global $hassel_is_root;
              if ($post->post_parent == 0){ 
                echo '<div id="hassel-card-area" class="page-root">  ';
              }else{
                $hassel_is_root = false;
                echo '<div id="hassel-card-area" class="page-post-type">';
              }

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

              if(hassel_get_levels() > 1){
                hassel_make_sticky(hassel_get_post_for_level(1,true)->ID, $wp_query);
              }else{
                hassel_make_sticky($post->ID, $wp_query);
              }
              
              
              get_template_part('hassel','loop-card');
              remove_filter('hassel-sub-loop','hassel_loop_sub_nav_page');
              remove_filter('hassel-pagination','hassel_pagination');
                ?>
      
      </div>
      </div>
    </div>

<?php get_footer(); ?>