<?php 


 function hassel_head(){
   if ($hassel_responsive != 'no') { 
      echo  '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />' ;
      echo '<link rel="stylesheet" type="text/css" media="handheld, only screen and (max-width: 480px), only screen and (max-device-width: 480px)" href="' . get_stylesheet_directory_uri() . '/css/mobile.css" />' ;
    } 
 }
 add_filter("wp_head",'hassel_head',999);


// ********* SlideDeck Fix *********
// makes insterted slidedeck responsive
function hassel_filter_shortcodes($post_id) {
    $edited_post = get_post($my_postid);
    $post_content = $_POST['post_content'] ;
    $post_content = str_replace('[SlideDeck2 id','[SlideDeck2 ress=1 id',$post_content);

    $post_to_filter = array();
    $post_to_filter['ID'] = $post_id;
    $post_to_filter['post_content'] = $post_content;
    // unhook this function so it doesn't loop infinitely
    remove_action('post_updated', 'hassel_filter_shortcodes');
    // update the post, which calls save_post again
    wp_update_post($post_to_filter);
    // re-hook this function
    add_action('post_updated', 'hassel_filter_shortcodes');
}
add_action('post_updated', 'hassel_filter_shortcodes');

  /**
   * Hook-in to slidedeck_after_get filter
   * 
   * @return array
   */
  function hassel_slidedeck_after_get( $slidedeck ) {
      global $SlideDeckPlugin;
      $slidedeck['options']['touch'] = true;
      return $slidedeck;
  }
  add_filter( 'slidedeck_after_get', 'hassel_slidedeck_after_get', 10, 5 );
 
// ToDo  - Dont works
function hassel_custom_excerpt_length($length){
  return 20;
}
remove_filter( 'excerpt_length', 'custom_excerpt_length', 1 );
add_filter('excerpt_length', 'hassel_custom_excerpt_length', 999);


// ********* Search Filters *********
function hassel_search_filter($query) {
  global $user_ID;
  get_currentuserinfo();
  $user_info = get_userdata($user_ID);
  $post_types = hassel_post_types();
  if($user_info->user_level > -1){
    array_push($post_types, 'board_post');
  }

  $post_type = $_GET['type'];
  if (!$post_type) {
    $post_type = 'any';
  }
    if ($query->is_search) {
        $query->set('post_type',$post_types);
    };
    return $query;
};
add_filter('pre_get_posts','hassel_search_filter');

// ********* Adds image sizes *********

if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 50, 50 ); // default Post Thumbnail dimensions   
}

// hassel post thumbnails

add_theme_support( 'post-thumbnails' );
add_image_size('card-image', 320, 240,true);
add_image_size('card-image-small', 62, 46,true);
add_image_size('poster-image', 1200, 1200,true);
   // add_image_size('detail-image', 720, 9999);

add_filter('image_resize_dimensions', 'hassel_image_resize_dimensions', 10, 6);

add_post_type_support('page', 'excerpt');

// add_image_size( $name, $width, $height, $crop );

// ********* Loads JS *********

    if ( !is_admin() ) {
      wp_register_script('hassel.browserDetection', (get_stylesheet_directory_uri()."/js/browserDetection.js"),array('jquery'),false,false);
      wp_register_script('hassel.imagesloaded', (get_stylesheet_directory_uri()."/js/imagesloaded.js"),array('hassel.browserDetection'),false,true);
      wp_register_script('hassel.functions', (get_stylesheet_directory_uri()."/js/functions.js"),array('hassel.imagesloaded'),false,true);
      wp_enqueue_script('hassel.browserDetection');
      wp_enqueue_script('hassel.imagesloaded');
      wp_enqueue_script('hassel.functions');
    }

  if ( is_admin() ) {
   // wp_enqueue_media();
    add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );

    wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

    wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"));
    wp_register_script('hassel.admin-functions', (get_stylesheet_directory_uri()."/js/admin-functions.js"),'jquery',false,true);

    wp_enqueue_script('jquery');
    wp_enqueue_script('hassel.admin-functions');
  }


// ********* Register Sidebar *********
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'Right Sidebar',
            'id'   => 'right_sidebar',
            'description'   => 'Right Sidebar Widget Area',
            'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-copy  sidebar post">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ));
    }

function hassel_right_sidebar($sidebar_id){
  echo "<div id='hassel-newsletter-form'>";
  dynamic_sidebar($sidebar_id);
  echo "</div>";
}
// ********* Remove Meta Boxes for Editor Role *********

    function hassel_remove_meta_boxes(){
      global $user_ID;
      get_currentuserinfo();
      $user_info = get_userdata($user_ID);
      $post_types = hassel_post_types();
      if($user_info->user_level < 8){
        $hassel_post_types = hassel_post_types(array('board_post'));
        foreach ($hassel_post_types as $hassel_post_type) {
          remove_meta_box('commentstatusdiv',$hassel_post_type,'normal');
          remove_meta_box('commentsdiv',$hassel_post_type,'normal');
        }
        
      }

    }
    add_action('add_meta_boxes','hassel_remove_meta_boxes');

// ********* Custumization Meta Box *********

// backwards compatible (before WP 3.0)
add_action( 'admin_init', 'hassel_add_custom_box', 1 );

/* Do something with the data entered */
add_action( 'save_post', 'hassel_save_postdata' );

/* Adds a box to the side column on the Posts (all custom posts, not board) and Page edit screens */
function hassel_add_custom_box() {
    $screens = hassel_post_types();
    foreach ($screens as $screen) {
        add_meta_box(
            'hassel_puff',
            __( 'Customization', 'myplugin_textdomain' ),
            'hassel_inner_custom_box',
            $screen,
            "side"
        );
    }
}

/* Prints the box content */
function hassel_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'nounce_hassel_add_custom_box' );

  //  Area
  $area = get_post_meta($post->ID,'_hassel_meta_area',true);
  $area = $area == "" ? hassel_get_area($post->post_type) : $area;
  echo '<label for="TitleArea">' . _e("Area: ", 'myplugin_textdomain' ) . '</label> <br>';
  echo '<select name="hassel_field_area" id="hassel_field_area">';
  echo '<option value="none"'; if($area == "" || $area == "none"){echo " selected";} echo '>None</option>';
  echo '<option value="photography"'; if($area == "photography"){echo " selected";} echo '>Photography</option>';
  echo '<option value="naturalscience"'; if($area == "naturalscience"){echo " selected";} echo '>Natural Science</option>';
  echo "</select>";
  echo "<br>";


  // Card on front Page
  $value = get_post_meta( $post->ID, '_hassel_meta_is_card_front', true );
  $title = get_post_meta( $post->ID, '_hassel_meta_card_title', true );
  $checked = $value == 'yes' ? 'checked="true"' : '';
  echo '<label for="Puff">';
  echo '</label> <br>';
  echo '<input type="checkbox"  name="hassel_field_is_card_front"' . $checked . 'size="25" />';
  _e(" Card on front page", 'myplugin_textdomain' );
  echo "<br>";
  // Fron Page Card Title
  $title_front = get_post_meta( $post->ID, '_hassel_meta_card_front_title', true );
  _e("Front Page Card Title:", 'myplugin_textdomain' );
  echo '<textarea rows="1" cols="30" type="text"  name="hassel_field_card_front_title">' . $title_front .'</textarea>';
  echo "<br>";
    // Card Title
  _e("Card Title:", 'myplugin_textdomain' );
  echo '<textarea rows="1" cols="30" type="text"  name="hassel_field_card_title">' . $title .'</textarea>';
  echo "<br>";

  // Use as Poster
  $isPoster = get_option('_hassel_meta_is_poster') === $post->ID;
  $title = get_post_meta( $post->ID, '_hassel_meta_poster_title', true );
  $checked = $isPoster == 'yes' ? 'checked="true"' : '';
  echo '<label for="Front">';
  echo '</label> <br>';
  echo '<input type="checkbox"  name="hassel_field_is_poster"' . $checked . 'size="25" />';
  _e(" Use as Poster*", 'myplugin_textdomain' );
  echo "<br>";

  // Poster Title
  _e("Poster Title:", 'myplugin_textdomain' );
  echo '<textarea rows="1" cols="30" type="text"  name="hassel_field_poster_title">' . $title . '</textarea>';
  echo "<br>";
  echo "<br>";




  // Poster Title Align
  $poster_title_align = get_post_meta($post->ID,'_hassel_meta_poster_title_align',true);
  $poster_title_align = $poster_title_align == "" ? "left" : $poster_title_align;
  echo '<label for="TitleAlign">' . _e("Title Align: ", 'myplugin_textdomain' ) . '</label> <br>';
  echo '<select name="hassel_field_poster_title_align" id="hassel_field_poster_title_align">';
  echo '<option value="left"'; if($poster_title_align == "left"){echo " selected";} echo '>Left</option>';
  echo '<option value="right"'; if($poster_title_align == "right"){echo " selected";} echo '>Right</option>';
  echo "</select>";
  echo "<br>";
  echo "<br>";


  // Poster Title Color
  $poster_title_color = get_post_meta($post->ID,'_hassel_meta_poster_title_color',true);
  $poster_title_color = $poster_title_color == "" ? "#FFFFFF" : $poster_title_color;
  echo '<label for="TitleColor">' . _e("Title Color: ", 'myplugin_textdomain' ) . '</label> <br>';
  echo '<input type="text" value="' .  $poster_title_color . '" class="hassel_color_picker" name="hassel_field_poster_title_color"/>';
  echo "<br>";
  echo "<br>";


  // Current From/To
  //From
  $poster_current_from = get_post_meta($post->ID,'_hassel_meta_current_from',true); 
  $poster_current_to = get_post_meta($post->ID,'_hassel_meta_current_to',true); 
  echo '<label for="TitleCurrentFrom">' . _e("Current From: ", 'myplugin_textdomain' ) . '</label> <br>';
  echo '<input type="text" class="hassel_date_picker" name="hassel_field_current_from" value="' .  $poster_current_from . '"/>';
  echo "<br>";
  // To
  echo '<label for="TitleCurrentTo">' . _e("Current To: ", 'myplugin_textdomain' ) . '</label> <br>';
  echo '<input type="text" class="hassel_date_picker" name="hassel_field_current_to" value="' .  $poster_current_to . '"/>';

  echo "<br>";
  echo "<br>";
  _e("* A poster covers the front page. The checkbox can not be uncehcked. To choose anoter post as a Poster please check the chckbox in another post", 'myplugin_textdomain' );

  // Override Post
  $override_post = get_post_meta( $post->ID, '_hassel_meta_override_post', true );
  echo "<br>";
  echo "<br>";
  _e("Override Post/Page (paste ID):", 'myplugin_textdomain' );
  echo '<input type="text"  name="hassel_field_override_post" value="' .  $override_post . '"/>';
  echo "<br>";
  }

/* When the post is saved, saves our custom data */
function hassel_save_postdata( $post_id ) {

  // Check if the current user is authorised to do this action. 
  if ( 'page' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return;
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // Check if the user intended to change this value.
  if ( ! isset( $_POST['nounce_hassel_add_custom_box'] ) || ! wp_verify_nonce( $_POST['nounce_hassel_add_custom_box'], plugin_basename( __FILE__ ) ) )
      return;

  $post_ID = $_POST['post_ID'];

  // -> Save - Area
  if(isset($_POST['hassel_field_area'])){
      $area = $_POST['hassel_field_area'];
    }else{
      $area = '';
    }
    // save
    if(add_post_meta($post_ID, '_hassel_meta_area', $area, true)){
    }else{
      update_post_meta($post_ID, '_hassel_meta_area', $area);
    };
  // <- Save - Area

  //-> save - is card front
  if(isset($_POST['hassel_field_is_card_front'])){
    $is_card_front = $_POST['hassel_field_is_card_front'];
  }else{
    $is_card_front = false;
  }
  $newdata = $is_card_front ? "yes" : "no";
  // save
  if(add_post_meta($post_ID, '_hassel_meta_is_card_front', $newdata, true)){
  }else{
    update_post_meta($post_ID, '_hassel_meta_is_card_front', $newdata);
  };
  if($newdata == "no"){
    if(add_post_meta($post_ID, '_hassel_meta_is_card_permanent', 'no', true)){
      }else{
      update_post_meta($post_ID, '_hassel_meta_is_card_permanent', 'no');
    };
  }
  //<- save - is card front

  //-> save - card  title
  if(isset($_POST['hassel_field_card_title'])){
    $card_title = $_POST['hassel_field_card_title'];
  }else{
    $card_title = "";
  }
  // save
  if(add_post_meta($post_ID, '_hassel_meta_card_title', $card_title, true)){
  }else{
    update_post_meta($post_ID, '_hassel_meta_card_title', $card_title);
  };
  //<- save - is card  title

    //-> save - card  front title
  if(isset($_POST['hassel_field_card_front_title'])){
    $card_front_title = $_POST['hassel_field_card_front_title'];
  }else{
    $card_front_title = "";
  }
  // save
  if(add_post_meta($post_ID, '_hassel_meta_card_front_title', $card_front_title, true)){
  }else{
    update_post_meta($post_ID, '_hassel_meta_card_front_title', $card_front_title);
  };
  //<- save - is card front title

  //-> save - is poster
  if(isset($_POST['hassel_field_is_poster'])){
    $is_poster = $_POST['hassel_field_is_poster'];
  }else{
    $is_poster= false;
  }
  // save
  if($is_poster){
    if(add_option("_hassel_meta_is_poster",$post_ID)){
    }else{
      update_option("_hassel_meta_is_poster",$post_ID);
    }
  }
  //<- save - is poster

  //-> save - poster title
  if(isset($_POST['hassel_field_poster_title'])){
    $card_poster_title = $_POST['hassel_field_poster_title'];
  }else{
    $card_poster_title = "";
  }
  // save
  if(add_post_meta($post_ID, '_hassel_meta_poster_title', $card_poster_title, true)){
  }else{
    update_post_meta($post_ID, '_hassel_meta_poster_title', $card_poster_title);
  };
  //<- save - poster title

  // -> Save - Poster Title Align
  if(isset($_POST['hassel_field_poster_title_align'])){
      $field_poster_title_align = $_POST['hassel_field_poster_title_align'];
    }else{
      $field_poster_title_align = 'left';
    }
    // save
    if(add_post_meta($post_ID, '_hassel_meta_poster_title_align', $field_poster_title_align, true)){
    }else{
      update_post_meta($post_ID, '_hassel_meta_poster_title_align', $field_poster_title_align);
    };
  // <- Save - Poster Title Align

  // -> Save - Poster Title Color
  if(isset($_POST['hassel_field_poster_title_align'])){
      $field_poster_title_color = $_POST['hassel_field_poster_title_color'];
    }else{
      $field_poster_title_color = '#FFFFFF';
    }
    // save
    if(add_post_meta($post_ID, '_hassel_meta_poster_title_color', $field_poster_title_color, true)){
    }else{
      update_post_meta($post_ID, '_hassel_meta_poster_title_color', $field_poster_title_color);
    };
  // <- Save - Poster Title Color

  // -> Save - Current From
  if(isset($_POST['hassel_field_current_from'])){
      $field_current_from = $_POST['hassel_field_current_from'];
    }else{
      $field_current_from = '';
    }
    // save
    if(add_post_meta($post_ID, '_hassel_meta_current_from', $field_current_from, true)){
    }else{
      update_post_meta($post_ID, '_hassel_meta_current_from', $field_current_from);
    };
  // <- Save - Current From

    // -> Save - Current To
  if(isset($_POST['hassel_field_current_to'])){
      $field_current_to = $_POST['hassel_field_current_to'];
    }else{
      $field_current_to = '';
    }
    // save
    if(add_post_meta($post_ID, '_hassel_meta_current_to', $field_current_to, true)){
    }else{
      update_post_meta($post_ID, '_hassel_meta_current_to', $field_current_to);
    };
  // <- Save - Current To

  //-> save - Override Post
  if(isset($_POST['hassel_field_override_post'])){
    $card_title = $_POST['hassel_field_override_post'];
  }else{
    $card_title = "";
  }
  // save
  if(add_post_meta($post_ID, '_hassel_meta_override_post', $card_title, true)){
  }else{
    update_post_meta($post_ID, '_hassel_meta_override_post', $card_title);
  };
  //<- save - Override Post

}

// ********* Customization Settings Page *********

// Hasselblad theme options 
  include 'options/admin-menu.php';
// Hasselblad custom types 
  include 'func/hassel-custom-post-types.php';
  include 'func/hassel-loops.php';

// -> Walkers

// creates a custom menu in header.php
class Walker_hassel_menu extends Walker_page {
  function start_el(&$output, $page, $depth, $args, $current_page) {
    global $post;
    if ( $depth )
      $indent = str_repeat("\t", $depth);
    else
      $indent = '';
 
    extract($args, EXTR_SKIP);



    if(is_page($post)){
      $top_level_post = hassel_get_top_level($post);
    }else{
      $section_post_id = hassel_section_for_post($post,false);
      $top_level_post = hassel_get_top_level(get_post($section_post_id ));
    }

    $curr_page = $top_level_post->ID == $page->ID ? ' current_page_item' : "";

    if(hassel_is_admin()){
      $output .= $indent . '<li><div class="page-item page-item-' . $page->ID . $curr_page  . '"><a href="' . get_page_link($page->ID) . '" title="' . esc_attr( wp_strip_all_tags( apply_filters( 'the_title', $page->post_title, $page->ID ) ) ) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a></div>'; 
    }else{
      if(!(strtolower(get_the_title($page->ID)) == "styrelse" || strtolower(get_the_title($page->ID)) == "board")){
        $output .= $indent . '<li><div class="page-item page-item-' . $page->ID . $curr_page  . '"><a href="' . get_page_link($page->ID) . '" title="' . esc_attr( wp_strip_all_tags( apply_filters( 'the_title', $page->post_title, $page->ID ) ) ) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a></div>'; 
      }
    }
    
  }
}

// <- Walkers

// -> Helpers Functions

function hassel_admin_link(){
  $buttonLabel = "LOGIN";
  echo '<a href="' . get_bloginfo('url') . '/wp-admin"><button type="button">' . $buttonLabel . '</button></a>';
}


function hassel_get_top_level($for_post){
 global $post;
 $top_level_post = $for_post == "" ? $post : $for_post;
 while($top_level_post->post_parent){
    $top_level_post = get_post($top_level_post->post_parent);
 }
 return $top_level_post;
}

function hassel_get_levels(){
  global $post;
  return count(get_post_ancestors($post->ID));
}

/*
* $level  (Num) Menu level
* $bubble (Bool) Iterate up through the menu levels until a post i s found.
*/
function hassel_get_post_for_level($level,$bubble = false){
  global $post;
  $posts = array_reverse(get_post_ancestors($post->ID));

  if($bubble) {
    if(count($posts) > 0){
       $level = count($posts) - 1;
     }else{
      $level = 0;
     }
  }
  $found_post = get_post($posts[$level]);

  return $found_post;
}

/* Makes current card appear on top when in right panel*/
function hassel_make_sticky($postID,$wp_query){

  global $hint_sticky_ID;
  global $hint_posts;
  global $post;

  $hint_posts = array();
  $hint_sticky_ID = $postID;

  if ($wp_query->have_posts()){
    while($wp_query->have_posts()){
      $wp_query->the_post();
      array_push($hint_posts,$post->ID);
    }
  }

  $hint_sticky_pos = array_search($hint_sticky_ID,$hint_posts);
  hassel_move_value($wp_query->posts, $hint_sticky_pos, 0);

}

function hassel_move_value(&$array, $a, $b) {
    $out = array_splice($array, $a, 1);
    array_splice($array, $b, 0, $out);
}

function hassel_get_categories($post){
            $taxs = get_object_taxonomies($post);
            $terms = get_the_terms($post->ID, $taxs[0]);
            if ( $terms && ! is_wp_error( $terms ) ){
            $names = array();
              foreach ( $terms as $term ) {
                $names[] = $term->name;
              }
              return $names;
            }else{
              return array();
            }

}


  function hassel_post_types($additional = null){
    if($additional == null){$additional = array();}
    return array_merge(array('page','post','award_winner_post','stipend_post','newsletter_post','appropriation_post','exhibition_post','research_post','publication_post'),$additional);
  }

 

  function hassel_post_era($the_post){
    global $post;


     if(hassel_is_in_dates(null) == "yes"){
      $page_type = 'current';
     }else if(hassel_is_before_date(null) == "yes"){
       $page_type = 'previous';
     }else if(hassel_is_after_date(null) == "yes"){
        $page_type = 'future';
     }


     $children_args = array( 
            'post_parent' => $the_post->ID,
            'post_type'   => 'any', 
            'numberposts' => -1,
            'post_status' => 'any'
        );
    $children = get_children($children_args);

    foreach ( $children as $child ) {
      $post_page_type_value = get_post_meta($child->ID,'page_type');
      if($post_page_type_value[0] == $page_type){
        return $child->ID;
      }
    }

    return $the_post->ID;
  }

   function hassel_section_for_post($post,$search_era = true){
    $options = get_option('hassel_options');
    $options_key = 'hassel_post_type_' . $post->post_type  . '_section';

     $children_args = array( 
            'post_parent' => $options[$options_key],
            'post_type'   => 'any', 
            'numberposts' => -1,
            'post_status' => 'any'
        );
    // $children = get_children($children_args);
    $children = get_pages(array('child_of'=>$options[$options_key]));
    $post_cats = hassel_get_categories($post);
 
    foreach ( $children as $child ) {
      $post_meta = get_post_meta($child->ID,'category'); /* TO DO - Ingen post meta för stipends! */
      $post_page_cat = $post_meta[0];

      if($post_page_cat == $post_cats[0]){
        
        hassel_post_era($child);
        if($search_era){
          return hassel_post_era($child);
        }else{
          return $child->ID;
        }
      }
    }
    return $options[$options_key];
  }

  function hassel_get_excerpt_by_id($post_id,$excerpt_length = 35){
    $the_post = get_post($post_id); //Gets the post 
    $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);
    if(count($words) > $excerpt_length) :
    array_pop($words);
    array_push($words, '…');
    $the_excerpt = implode(' ', $words);
    endif;
    return $the_excerpt;
  }

  function hassel_trim_string($string,$length,$intact = true,$filler = ' ...'){
      if(strlen($string) < $length){
        return $string;
      }else{
        if($intact){
          while (substr ($string , $length ,1) != " ") {
            $length--;
          }
        }
        $new_string = substr($string,0,$length) . $filler;
        return $new_string;
      }
  }

  function hassel_get_image_size($size){
    global $_wp_additional_image_sizes;

    if (isset($_wp_additional_image_sizes[$size])) {
        $width = intval($_wp_additional_image_sizes[$size]['width']);
        $height = intval($_wp_additional_image_sizes[$size]['height']);
      } else {
        $width = get_option($size.'_size_w');
        $height = get_option($size.'_size_h');
      }

    $image_size = array(
        'width' => $width,
        'height' => $height
      );

    return $image_size;
  }

function hassel_card($post,$show_excerpt = true){

          global $global_page_id;
          global $poster_title_align;
          $curr_page = $global_page_id == get_the_ID() ? " current-page-item" : "" ;
          $poster_post_id = hassel_get_poster_id();
          $poster_title_align = get_post_meta($poster_post_id,'_hassel_meta_poster_title_align', true );
          $post_style =  $poster_title_align == "right" ? "float:left;" : "float:right;";
          $frontpage_id = get_option('page_on_front');
          //echo "string" . $frontpage_id . ":" . $global_page_id ;
          ?>
          <div id="hassel-card" <?php post_class("post"); ?> style="<?php if($frontpage_id == $global_page_id){echo $post_style;}; ?>">
          <!-- TITLE -->
         <?php hassel_card_breadcrumb($post->ID);?>
          <h2><a href="<?php the_permalink() ?>">
            <?php 
            $title_card_front = get_post_meta($post->ID,'_hassel_meta_card_front_title', true );
            $title_card = get_post_meta($post->ID,'_hassel_meta_card_title', true );
            $title_post = the_title('','',false);
            if($title_card == "" ){
              $title_card = $title_post;
              $title_post = "";
            }
            if($frontpage_id == $global_page_id){
              echo mb_strtoupper($title_card_front == "" ? $title_card : $title_card_front); 
            }else{
               echo mb_strtoupper($title_card); 
            }
            ?>
          </a></h2>
           <!-- IMAGE -->
           <div id="hassel-card-image"><a href="<?php the_permalink() ?>">
            <?php 
            if(has_post_thumbnail()){
              the_post_thumbnail( 'card-image' );
            }else{
              $area = get_post_meta($post->ID,'_hassel_meta_area',true);
              $options = get_option('hassel_options');
              $area = $area == "" ? "none" : $area;
              if($area != ''){
                 $image = $options['hassel_image_' . $area];
                 hassel_get_image($image,'card-image',true);
               }
            }  
            ?>
          </a></div>
            <!-- SUB TITLE / ECXERPT -->
            <?php global $hassel_is_root; ?>
            <?php if($hassel_is_root){ ?>
            <div id="hassel-card-copy">
            <?php 
              //$card_sub = $card_sub == "" ? the_title('','',false) : $title;
              $card_excerpt = get_the_excerpt($post->ID);
              if($card_sub != "" || $card_excerpt != ""){
                ?>
                <a href="<?php the_permalink() ?>">
                <?php if($title_post!= ""){ ?>
                <h3><?php echo mb_strtoupper(hassel_trim_string($title_post,50)); ?> </h3>
                <?php }?>
                <?php if($card_excerpt != ""){ ?>
                <p><?php echo hassel_trim_string($card_excerpt,140); ?> <p>
                <?php }?>
                </a>
                <?php
              }
            ?>
          </div>
          <?php }else{echo "<br>";};?>
           <?php apply_filters('hassel-sub-loop',$post);?>
         </div>
      <?php


}

function hassel_card_small($post){
          global $hassel_is_root;
          global $global_page_id;
          global $poster_title_align;
          $curr_page = $global_page_id == get_the_ID() ? " current-page-item" : "" ;
          $poster_post_id = hassel_get_poster_id();
          $poster_title_align = get_post_meta($poster_post_id,'_hassel_meta_poster_title_align', true );
          $post_style =  $poster_title_align == "right" ? "float:left;" : "float:right;";
          $frontpage_id = get_option('page_on_front');
          
          $post_classes = array(
            'post',
            'small'
          );
          ?>
          <div id="hassel-card" <?php post_class($post_classes); ?> style="<?php if($frontpage_id == $global_page_id){echo $post_style;}; ?>">
          <!-- TITLE -->
         <?php hassel_card_breadcrumb($post->ID);?>
          <h2><a href="<?php the_permalink() ?>">
            <?php 
            $title_card = get_post_meta($post->ID,'_hassel_meta_card_title', true );
            $title_post = the_title('','',false);
            if($title_card == "" ){
              $title_card = $title_post;
              $title_post = "";
            }
            echo mb_strtoupper(hassel_trim_string($title_card,$hassel_is_root ? 24 : 14,false)); 
            ?>
          </a></h2>
           <!-- IMAGE -->
           <div id="hassel-card-image"><a href="<?php the_permalink() ?>">
            <?php 
            if(has_post_thumbnail('card-image')){
              if(has_post_thumbnail('card-image-small')){
                post_thumbnail('card-image-small');
              }else{
                post_thumbnail('card-image');
              }
            }else{
              $area = get_post_meta($post->ID,'_hassel_meta_area',true);
              $area = $area == "" ? "none" : $area;
              $options = get_option('hassel_options');
              if($area != ''){
                 $image = $options['hassel_image_' . $area];
                 hassel_get_image($image,'card-image',true);
               }
            }  
            ?>
          </a></div>

           <!-- SUB TITLE / ECXERPT -->
            <div id="hassel-card-copy">
            <?php 
              $post_section= hassel_section_for_post($post);
              
               $card_excerpt = get_the_excerpt($post->ID);
              if($card_sub != "" || $card_excerpt != ""){
                ?>
                <a href="<?php the_permalink() ?>">
                <?php if($card_excerpt != ""){ ?>

                <p><?php echo hassel_trim_string($card_excerpt, $hassel_is_root ? 45 : 35); ?> <p>
                <?php }?>
                </a>
                <?php
              }
            ?>
          </div>
          <?php hassel_card_breadcrumb($post_section,false,true); ?>
         </div>
      <?php


}




function hassel_card_breadcrumb($post_ID,$only_search = true,$show_top_level = false) {

  if (!is_search() && $only_search) { return;};


    global $post;
    $post = $post_ID ? get_post($post_ID): get_post($post->ID); 
 
    echo '<div id="hassel-breadcrumb" class="current_page_item">';

 
    if( $post->post_parent) {
 
            $anc = get_post_ancestors( $post->ID );
            $anc = array_reverse($anc);
 
      foreach($anc as $ancestor) {
        echo '<a href="' . get_permalink($ancestor) . '">';
        echo mb_strtoupper(get_the_title($ancestor));
        echo '</a>';
        echo ' &lt; ';
        // echo ' / ';
      }
        echo '<a href="' . get_permalink($post->ID) . '">';
        echo mb_strtoupper(get_the_title($post->ID));
        echo '</a>';
    }else if($show_top_level){
        echo '<a href="' . get_permalink($post->ID) . '">';
        echo mb_strtoupper(hassel_trim_string(get_the_title($post->ID),40));
        echo '</a>';
    }
    echo "</div>";
  
  
}

function hassel_breadcrumb($for_post = "") {
 
  if (!is_home()) {
    global $post; 
    $the_post = $for_post  == "" ? $post : $for_post;
 
    echo '<div id="hassel-breadcrumb" class="current_page_item">';

 
    if(is_page() && $the_post->post_parent) {
      $anc = get_post_ancestors( $the_post->ID );
      $anc = array_reverse($anc);
 
      foreach($anc as $ancestor) {
        echo '<a href="' . get_permalink($ancestor) . '">';
        echo mb_strtoupper(get_the_title($ancestor));
        echo '</a>';
        echo ' &lt; ';
      }
        echo '<a href="' . get_permalink($the_post->ID) . '">';
        echo mb_strtoupper(get_the_title($the_post->ID));
        echo '</a>';
    }
    elseif (is_page() && !$the_post->post_parent) {
      //echo mb_strtoupper(get_the_title($post->ID));
    }else if($the_post->post_parent){
      $anc = get_post_ancestors( $the_post->ID );
      $anc = array_reverse($anc);
 
      foreach($anc as $ancestor) {
        echo '<a href="' . get_permalink($ancestor) . '">';
        echo mb_strtoupper(get_the_title($ancestor));
        echo '</a>';
        echo ' &lt; ';
      }
        echo '<a href="' . get_permalink($the_post->ID) . '">';
        echo mb_strtoupper(get_the_title($the_post->ID));
        echo '</a>';
    }
   
  }
   echo "</div>";
}

  function hassel_get_area($post_type){
    //'award_winner_post','stipend_post','newsletter_post','appropriation_post','exhibition_post'
    switch ($post_type) {
      case 'award_winner_post':
          return 'photography';
        break;
      default:
         return '';
        break;
    }
  }

  function hassel_image_resize_dimensions($default, $orig_w, $orig_h, $new_w, $new_h, $crop){
    if ( !$crop ) return null; // let the wordpress default function handle this

    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);

    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}

  function hassel_is_in_dates($args) {
    global $post;
    $todays_date = date("Y-m-d");
    $from = strtotime(get_post_meta($post->ID,'_hassel_meta_current_from',yes));
    $to = strtotime(get_post_meta($post->ID,'_hassel_meta_current_to',yes));
    $today = strtotime($todays_date);
    $is_in_date = ($today >= $from && $today <= $to);
    //echo " ID:" . $post->ID . " is in date: t" . $today . " f"  . $from . " t" . $to;
    if($is_in_date ){return "yes";}else{return "no";}
  }

  function hassel_is_before_date($args) {
    global $post;
    $todays_date = date("Y-m-d");
    $from = strtotime(get_post_meta($post->ID,'_hassel_meta_current_from',yes));
    $to = strtotime(get_post_meta($post->ID,'_hassel_meta_current_to',yes));
    $today = strtotime($todays_date);
    $is_in_date = ($today > $to );
    //echo " ID:" . $post->ID . " is in date: t" . $today . " f"  . $from . " t" . $to;
    if($is_in_date ){return "yes";}else{return "no";}
  }

  function hassel_is_after_date($args) {
    global $post;
    $todays_date = date("Y-m-d");
    $from = strtotime(get_post_meta($post->ID,'_hassel_meta_current_from',yes));
    $to = strtotime(get_post_meta($post->ID,'_hassel_meta_current_to',yes));
    $today = strtotime($todays_date);
    $is_in_date = ($today < $from);
    //echo " ID:" . $post->ID . " is in date: t" . $today . " f"  . $from . " t" . $to;
    if($is_in_date ){return "yes";}else{return "no";}
  }

  function hassel_post_is_in_year($args){
    global $post;
    $todays_date = date("Y");
    $from = strtotime(get_post_meta($post->ID,'_hassel_meta_current_from',yes));
    $from_date = date('Y',$from);
    $today_time = strtotime($todays_date);
    $from_time = strtotime($from_date);
    $is_in_date = ($today_time == $from_time );
    if($is_in_date ){return "yes";}else{return "no";}
  }

  function hassel_get_poster_id(){
    // return get_option('_hassel_meta_is_poster');
    if(function_exists('icl_object_id')){
      $poster_ID = get_option('_hassel_meta_is_poster');
      $poster_types = hassel_post_types();
      foreach ($poster_types as $poster_type) {
        $icl_poster_ID = icl_object_id($poster_ID,$poster_type,false);
        if($icl_poster_ID != null){break;}
      }
       if($icl_poster_ID != null){
        return $icl_poster_ID;
       }else{
        return get_option('_hassel_meta_is_poster');
       }
    }
  }


  function hassel_pagination($wp_query){
    ?>
    <div class="navigation">
      <div class="next-posts"><p><?php next_posts_link('&laquo; Older Entries', $wp_query->max_num_pages) ?></p></div>
      <div class="prev-posts"><p><?php previous_posts_link('Newer Entries &raquo;', $wp_query->max_num_pages) ?></p></div>
    </div>
    <?php
  }

function hassel_is_admin(){
   global $user_ID;
   get_currentuserinfo();
  $user_info = get_userdata($user_ID);
  return (($user_info->user_level) > -1);
}


  function hassel_edit_button($content){
      global $user_ID;
      global $post;
      $edithPath = '/wp-admin/post.php?post=' . $post->ID . '&action=edit';
      $editURL = get_site_url( $post->ID, $edithPath, 'admin' ); 
      $buttonLabel = is_page($post->ID) ? 'EDIT PAGE' : 'EDIT POST';
      get_currentuserinfo();
      //echo "editURL:" . $editURL;
      $user_info = get_userdata($user_ID);
      if(hassel_is_admin()){
          return $content . '<p><a href="' . $editURL . '"><button type="button">' . $buttonLabel . '</button></a><p>';
      }else{
        return $content;
      }
      
  }
  add_filter('the_content', 'hassel_edit_button',999);

  function hassel_get_image($url,$size,$echo = false){
    $image_size = hassel_get_image_size($size);
    $image_append = '-' . $image_size['width'] . 'x' . $image_size['height'];
    $str_length = strlen($url);
    $new_url = substr_replace($url,$image_append,$str_length - 4,0);

    if($echo){
      ?>
      <img width="<?php echo $image_size["width"] ?>" height="<?php $image_size["height"] ?>" src="<?php echo $new_url ?>" class="attachment-<?php echo $size ?>" wp-post-image" alt="">
      <?php
    }else{
       return $new_url;
    }
  }



  // <- Helper Functions



?>