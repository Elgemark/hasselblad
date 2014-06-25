<!-- -> The Loop -->
  <?php if ($wp_query->have_posts()) : ?>
  <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?> 
        
        <?php if( apply_filters('hassel_loop_conditional','') != 'no'){ ?>
        <?php 
          global $poster_title_align;
          $poster_post_id = hassel_get_poster_id();
          $poster_title_align = get_post_meta($poster_post_id,'_hassel_meta_poster_title_align', true );
          $post_style =  $poster_title_align == "right" ? "float:right;" : "float:left;";
        ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class("post"); ?> style="<?php echo $post_style ?>">
          
          <div class="hassel-copy" >
          <!-- TITLE -->
          <h2><a href="<?php the_permalink() ?>">
            <?php 
            $title = get_post_meta($post->ID,'_hassel_meta_card_title', true );
            $title_original = the_title('','',false);
            $title_top = $title == "" ? $title_original : $title;
            echo mb_strtoupper($title_top); 
            ?></h2><?php
            echo "<p>";
            the_date();
            echo "</p>";
            ?>
          </a>

           <?php apply_filters('hassel-sub-loop',$post);?>
              
           </div>
         </div>

         <?php }?>
         
  <?php endwhile; ?>
  <?php else : ?>
  <?php endif; ?>
  <?php wp_reset_query() ?> 
<!-- <- The Loop -->