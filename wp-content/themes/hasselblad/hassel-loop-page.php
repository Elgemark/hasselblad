
 <?php 
  $override_post = get_post_meta( $post->ID, '_hassel_meta_override_post', true );
  if($override_post){
    wp_reset_query();
     $args = array(
                'post_type'=>'any',
                'page_id' => $override_post
                 );
      $wp_query = new WP_Query( $args);

  }
 
  
 ?>
<?php if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
      <?php if( apply_filters('hassel_loop_conditional','') != 'no'){ ?>
      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="hassel-copy hassel-post-wrap">
        <h1><?php 
        $title = the_title('','',false);
        echo mb_strtoupper($title); 
        ?></h1>
               <?php 


               the_content(); 

               ?> 
               <?php apply_filters('hassel-loop-sub-page',$post); ?>
               <?php apply_filters('hassel-before-share','right_sidebar'); ?>
              
                <?php if(function_exists('hint_share')){hint_share();} ?>
              
              
              <div class="clear"></div>
                <?php comments_template(); ?> 
              </div>        
       </div>
<?php } ?>
<?php endwhile; endif; ?>
<?php wp_reset_query(); ?>

       
