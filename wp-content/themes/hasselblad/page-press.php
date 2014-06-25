
<?php
/*
Template Name: Press
*/
?>

<?php global $post ?>
<?php get_header(); ?>
  
    <div id="hassel-page-wrap">

      <?php get_template_part('hassel','poster'); ?>

      <div id="hassel-page" class="page-default">
            <?php 

              

              echo "<div id='hassel-posts'>";
              if ($post->post_parent != 0){ 
                add_filter('hassel-loop-sub-page','hassel_loop_sub_page');
              }
              hassel_breadcrumb(); 
              get_template_part('hassel','loop-page');
              remove_filter('hassel-loop-sub-page','hassel_loop_sub_page');
              echo "</div>";

              global $hassel_is_root;
              if ($post->post_parent == 0){ 
                echo '<div id="hassel-card-area" class="page-root">';
              }else{
                $hassel_is_root = false;
                echo '<div id="hassel-card-area" class="page-post">';
              }

              wp_reset_query();
              $first_parent = hassel_get_post_for_level(0);
              $post_parent = $post->post_parent > 0 ?  $post->post_parent  : $post->ID;
              if($first_parent){
                $post_parent = $first_parent->ID;
              }

              $args = array(
                'post_type'=>'press_post',
                'orderby'=>'menu_order',
                'order'=>'ASC',
                'posts_per_page'=>-1
                );
              $wp_query = new WP_Query( $args);
              

              if ($post->post_parent != 0){ 
                 add_filter('hassel-sub-loop','hassel_loop_sub_nav');
              }
              $pass = post_password_required() == 1 ? false : true;
              hassel_make_sticky($post->ID, $wp_query);
              if($pass){ //-> Password Protected
              if($post->post_parent == 0){
                  if(!$wp_query->found_posts < 7){
                        get_template_part('hassel','loop-card'); 
                    }else{
                      get_template_part('hassel','loop-card-small'); 
                    }
                  }else{
                    get_template_part('hassel','loop-card'); 
                  }

              } //<- Password Protected
                remove_filter('hassel-sub-loop','hassel_loop_sub_nav');
                ?>

            </div>


      </div>
    </div>

<?php get_footer(); ?>