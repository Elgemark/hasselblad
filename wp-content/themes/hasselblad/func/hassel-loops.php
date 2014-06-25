<?php

// link to anchors
function hassel_loop_sub_nav($sub_post){

	$post_parent = $sub_post->ID;
  	global $global_page_id;

  $page_template = get_post_meta($global_page_id, '_wp_page_template', TRUE );
  //echo "Page template: " . $page_template;
   // if($page_template != 'page-news.php' && $page_template != 'page-start.php' && $page_template != 'page-previous-award-winners.php'){
    $wp_sub_query = new wp_query(array('posts_per_page'=>-1,'post_type'=>'page','post_parent'=>$post_parent,'orderby'=>'menu_order','order'=>'ASC'));
     if ( $wp_sub_query->have_posts() ) { 
      $post_num = 0;
       echo  '<nav class="hassel-card-nav"><ul>';

         while ( $wp_sub_query->have_posts() ) { 
            $sub_post = $wp_sub_query->the_post();

              ?>
              <li>
              <div id="test" class="anchor-<?php echo $post_num?> page-item page-item-<?php the_ID(); ?>">
                <a href="<?php echo get_permalink($post_parent) . '#' . $post_num?>">

              <?php 
              $title = get_post_meta($sub_post->ID,'_hassel_meta_card_title', true );
              $title_original = get_the_title($sub_post->ID);
              $title_top = $title == "" ? $title_original : $title;
              echo mb_strtoupper(hassel_trim_string($title_top,30)); 
              ?>

            </a>
          </div>
        </li>

        

        <?php
        $post_num++;
         }

         echo '</ul></nav>';
     }
     wp_reset_postdata();
 // }
}



// links to pages
function hassel_loop_sub_nav_page($sub_post){

  $post_parent = $sub_post->ID;
    global $global_page_id;

  $page_template = get_post_meta($global_page_id, '_wp_page_template', TRUE );
  //echo "Page template: " . $page_template;
   if($page_template != 'page-news.php' && $page_template != 'page-start.php' && $page_template != 'page-previous-award-winners.php'){
    $wp_sub_query = new wp_query(array('posts_per_page'=>-1,'post_type'=>'page','post_parent'=>$post_parent,'orderby'=>'menu_order','order'=>'ASC'));
     if ( $wp_sub_query->have_posts() ) { 
       echo  '<nav class="hassel-card-nav"><ul>';

         while ( $wp_sub_query->have_posts() ) { 
              $sub_post = $wp_sub_query->the_post();
              //$curr_page = $global_page_id == get_the_ID() ? " current-page-item" : "" ;

              ?>
              <li>
              <div class="page-item page-item-<?php the_ID(); ?> <?php echo  $curr_page ?>">
                <a href="<?php echo the_permalink()?>">

              <?php 
              $title = get_post_meta($sub_post->ID,'_hassel_meta_card_title', true );
              $title_original = get_the_title($sub_post->ID);
              $title_top = $title == "" ? $title_original : $title;
              echo mb_strtoupper(hassel_trim_string($title_top,30)); 
              ?>

            </a>
          </div>
        </li>

          <!-- sub sub nav -->
          
        <?php 
          $pages = get_pages(array('child_of'=>get_the_ID()));
          if(count($pages) > 0){
            $wp_sub_query_back = $wp_sub_query;
            hassel_loop_sub_sub_nav_page(get_the_ID()); 
            $wp_sub_query = $wp_sub_query_back;
          }
        ?>
       

        <?php
         }

         echo '</ul></nav>';
     }
     wp_reset_postdata();
 }
}

function hassel_loop_sub_sub_nav_page($sub_post_ID){
   $wp_sub_sub_query = new wp_query(array('posts_per_page'=>-1,'post_type'=>'page','post_parent'=>$sub_post_ID,'orderby'=>'menu_order','order'=>'ASC'));
    
   if ( $wp_sub_sub_query->have_posts() ) { 
        echo '<ul>';
         while ( $wp_sub_sub_query->have_posts() ) { 
            $sub_sub_post = $wp_sub_sub_query->the_post();
              ?>
              <li>
              <div id="test" class="anchor-<?php echo $post_num?> page-item page-item-<?php the_ID(); ?>">
                <a href="<?php echo get_permalink($post_parent) . '#' . $post_num?>">
              <?php 
              $title = get_post_meta($sub_sub_post->ID,'_hassel_meta_card_title', true );
              $title_original = get_the_title($sub_sub_post->ID);
              $title_top = $title == "" ? $title_original : $title;
              echo mb_strtoupper(hassel_trim_string($title_top,30)); 
              ?>
            </a>
          </div>
        </li>
        <?php
         }
     }
     echo '</ul>';
}

function hassel_loop_sub_page($sub_post){
  
  $post_parent = $sub_post->ID;
  $sub_args = array(
              'post_type' => array('page'),
              'post_parent'=>$post_parent,
              'orderby'=>'menu_order',
              'order'=>'ASC'
            );
    $wp_sub_query = new wp_query($sub_args);

     if ( $wp_sub_query->have_posts() ) { 
      $post_num = 0;
      echo '</br>';
         while ( $wp_sub_query->have_posts() ) { 

            $sub_post = $wp_sub_query->the_post();
            echo '<a class="anchor" name="' . $post_num . '"></a>';
            //echo '<a name="' . $post_num . '">';
            //echo '<a name="' . $post_num . '">';
            echo '<h2>';
            $title = the_title('','',false);
            echo mb_strtoupper($title); 
            echo '</h2>';

            the_content();
            //echo '</a>';
            echo '</br>';
          $post_num++;
         } // end while
     } // end if
     wp_reset_postdata();
}

/*
$post_type : [post type]
$page_type : [page type] current,previous,category

*/
function hassel_loop_post_type_page($post){
  $page_type = get_post_meta($post->ID,'page_type', true);

  $post_type = get_post_meta($post->ID,'post_type',true);
  $category = get_post_meta($post->ID,'category', true);

  $post_tax = get_object_taxonomies($post_type,'names');
  $post_tax = $post_tax[0]; 

  switch ($page_type) {

    case 'current': /******* CURRENT *******/
    echo '<div id="hassel-posts">';
    hassel_breadcrumb($post); 
    $args = array(
      'post_type'=>$post_type,
      $post_tax => $category,
      'orderby'=>'menu_order',
      'order'=>'ASC',
      'posts_per_page' => -1
    );
    $wp_query = new WP_query($args);
        ?>
        <?php if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            <?php if( hassel_is_in_dates("") != 'no'){ ?>
            <div id="page type-page post-<?php the_ID(); ?>" <?php post_class(); ?>>
              <div class="hassel-copy hassel-post-wrap">
              <h1><?php 

              $title = the_title('','',false);
              echo mb_strtoupper($title); 
              ?></h1>
                    <?php the_content(); ?> 
                    <div id="hassel-share">
                      <?php if(function_exists('hint_share')){hint_share();} ?>
                    </div> 
                    <div class="clear"></div>
                      <?php comments_template(); ?> 
                    </div>        
             </div>
      <?php } ?>
      <?php endwhile; endif; ?>
      <?php wp_reset_query(); ?>
      <?php
      echo "</div>";
      break;

    case 'previous': /******* PREVIOUS *******/
          echo "<div id='hassel-posts'>";
          hassel_breadcrumb($post); 
          get_template_part('hassel','loop-page');
          echo "</div>";

          ?>
             <div id="hassel-card-area" class="page-root page-post-type <?php echo $post_type ?>">
          <?php 
              wp_reset_query();
              $args = array(
                'post_type' => $post_type,
                $post_tax => $category,
              'orderby'=>'menu_order',
              'order'=>'ASC',
              'post_meta'=>'_hassel_meta_current_to',
              'posts_per_page' => -1
              //'paged' => get_query_var('paged')
              );
              $wp_query = new WP_Query($args );
        ?>

        <?php if ($wp_query->have_posts()) : ?>

        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?> 
        
        <?php 
          if( hassel_is_before_date("") == 'yes'){
            if($wp_query->found_posts < 7){
                hassel_card($post);
              }else{
                hassel_card_small($post);
              }
           }
        ?>
         
  <?php endwhile; ?>
  <?php else : ?>
  <?php endif; ?>

<?php apply_filters('hassel-pagination',$wp_query);?>

  <?php wp_reset_query() ?> 
       </div>
        <?php
      
      break;
    case 'future': /******* FUTURE *******/
           echo "<div id='hassel-posts'>";
            hassel_breadcrumb($post);
            get_template_part('hassel','loop-page');
          echo "</div>"; 
          ?>
             <div id="hassel-card-area" class="page-root  page-post-type <?php echo $post_type ?>">
              <?php 

                wp_reset_query();
                $args = array(
                'post_type'=>$post_type,
                $post_tax => $category,
                'orderby'=>'menu_order',
                'order'=>'ASC',
                'post_meta'=>'_hassel_meta_current_to',
                'posts_per_page' => -1
                //'paged' => get_query_var('paged')
                );

                $wp_query = new WP_Query( $args );

          
        ?>

        <?php if ($wp_query->have_posts()) : ?>
        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?> 
        
        <?php
         if( hassel_is_after_date("") == 'yes'){ 
            if($wp_query->found_posts < 7){
                hassel_card($post);
              }else{
                hassel_card_small($post);
              }
         }
         ?>
         
  <?php endwhile; ?>
  <?php else : ?>
  <?php endif; ?>

<?php apply_filters('hassel-pagination',$wp_query);?>

  <?php wp_reset_query() ?> 
       </div>
        <?php
      break;
    
    default: /******* DEFAULT *******/

        echo '<div id="hassel-posts">';
          $wp_query = new WP_Query(array('orderby'=>'menu_order','order'=>'DESC'));
          hassel_breadcrumb($post);
          get_template_part('hassel','loop-page');
        echo '</div>';
      break;
  }
    
}


function hassel_loop_categories($args){
  $categories =  get_categories($args); 
  foreach ($categories as $category) {
    
      ?>
      <div <?php post_class("post"); ?> >
          <div class="hassel-copy" >
              <h2><?php echo $category->cat_name ?></h1>

    <?php
    $cat_id = $category->cat_ID;
    $args_sub = array('post_type'=>$args['type'],'cat'=>$cat_id);
    $wp_sub_query = new wp_query($args_sub);
     if ( $wp_sub_query->have_posts() ) { 
       echo  '<hr><nav class="hassel-card-nav"><ul>';
         while ( $wp_sub_query->have_posts() ) { 
            $sub_post = $wp_sub_query->the_post();
              ?>
              <li>
              <div class="page-item page-item-<?php the_ID(); ?>">
              <a href="<?php the_permalink() ?>">
              <?php 
              $title = get_post_meta($sub_post->ID,'_hassel_meta_card_title', true );
              $title_original = get_the_title($sub_post->ID);
              $title_top = $title == "" ? $title_original : $title;
              echo mb_strtoupper($title_top); 
              ?>
            </a>
          </div>
        </li>
        <?php  
         } // end while
         echo '</ul></nav>';
     }
     wp_reset_postdata();
     ?>
          </div>
      </div>

      <?php
  }
}



?>