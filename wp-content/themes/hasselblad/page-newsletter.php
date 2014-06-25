<?php
/*
Template Name: Newsletter
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
              add_filter('hassel-before-share','hassel_right_sidebar');
              get_template_part('hassel','loop-page');
              remove_filter('hassel-loop-sub-page','hassel_loop_sub_page');
              remove_filter('hassel-before-share','hassel_right_sidebar');
              

            echo "</div>";

              if ($post->post_parent == 0){ 
                echo '<div id="hassel-card-area" class="page-root">  ';
              }else{
                echo '<div id="hassel-card-area" class="page-post">';
              }


              ?>

              <div id="hassel-card" <?php post_class("post"); ?> style="<?php if($frontpage_id == $global_page_id){echo $post_style;}; ?>">
                <h2>ARKIV NYHETSBREV</h2>
                <!-- IMAGE -->
           <div id="hassel-card-image"><a href="<?php the_permalink() ?>">
            <?php 
            if(has_post_thumbnail()){
              the_post_thumbnail( 'card-image' );
            }else{
              $area = get_post_meta($post->ID,'_hassel_meta_area',true);
              $options = get_option('hassel_options');
              if($area != ''){
                 $image = $options['hassel_image_' . $area];
                 hassel_get_image($image,'card-image',true);
               }
            }  
            ?>
          </a></div>
                <div id="hassel-card-copy">
                

              <style type="text/css">
<!--
.display_archive {font-family: arial,verdana; font-size: 12px;}
.campaign {line-height: 125%; margin: 5px;}
//-->
</style>
<script language="javascript" src="http://us7.campaign-archive2.com/generate-js/?u=49e93a533a5ae9eb08ce1169a&fid=3189&show=10" type="text/javascript"></script>
              


              </div>
              </div>
              <?php

              wp_reset_query();
              $first_parent = hassel_get_post_for_level(0);
              $post_parent = $post->post_parent > 0 ?  $post->post_parent  : $post->ID;
              if($first_parent){
                $post_parent = $first_parent->ID;
              }

              $wp_query = new WP_Query( array(
                'post_type'=>'page',
                'post_parent'=>$post_parent,
                'orderby'=>'menu_order',
                'order'=>'ASC'));
              if ($post->post_parent != 0){ 
                 add_filter('hassel-sub-loop','hassel_loop_sub_nav');
              }
                if($wp_query->found_posts < 5){
                    get_template_part('hassel','loop-card'); 
                  }else{
                    get_template_part('hassel','loop-card-small'); 
                  }
              remove_filter('hassel-sub-loop','hassel_loop_sub_nav');
                ?>
            </div>


      </div>
      
    </div>

<?php get_footer(); ?>