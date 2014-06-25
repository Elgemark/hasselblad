<?php

add_action( 'admin_menu', 'hassel_customization_page' );
add_action('admin_init', 'register_hassel_customization');

function hassel_option_page_capability( $capability ) {
  return 'publish_posts';
}
add_filter( 'option_page_capability_hassel_options', 'hassel_option_page_capability' );

function hassel_customization_page() {
  $icon_url = get_bloginfo('template_directory').'/images/hassel.png';
  add_menu_page( 'Hasselblad Customization', 'Hasselblad Options', 'publish_posts', 'hassel_customization', 'hassel_customization_fn',$icon_url,30);
}

function register_hassel_customization(){
  global $user_ID;
  get_currentuserinfo();
  $user_info = get_userdata($user_ID);

	register_setting('hassel_options', 'hassel_options', 'validate_hassel_options');
  add_settings_section('puff_section', 'Cards on front page (Max 3. Check to delete).', 'section_hassel_cb', __FILE__);
  add_settings_section('descr_section', 'Header', 'section_hassel_cb', __FILE__);
  add_settings_section('featured_images_fallbacks_section', 'Featured Images Fallback', 'section_hassel_cb', __FILE__);
  add_settings_section('footer_section', 'Footer', 'section_hassel_cb', __FILE__);
  if($user_info->user_level > 9){ // Only Administrator
    add_settings_section('misc_section', 'Administrator Setup', 'section_hassel_cb', __FILE__);
  }
  
	
  //-> Add setting fields
  add_settings_field('hassel_header_image', 'Header Image', 'add_hassel_header_image_field', __FILE__, 'descr_section',$args);
  add_settings_field('hassel_descr_text', 'Description Text', 'add_hassel_descr_text_field', __FILE__, 'descr_section',$args);
  add_settings_field('hassel_descr_thumb', 'Description Thumbnail', 'add_hassel_descr_thumb_field', __FILE__, 'descr_section',$args);
  add_settings_field('hassel_descr_page', 'Description Page ID', 'add_hassel_descr_page_field', __FILE__, 'descr_section',$args);
  add_settings_field('hassel_descr_excerpt', 'Description Excerpt', 'add_hassel_descr_excerpt_field', __FILE__, 'descr_section',$args);
  add_settings_field('hassel_news_letter_id', 'Newsletter Page ID', 'add_hassel_news_letter_id_field', __FILE__, 'descr_section',$args);
  add_settings_field('hassel_contact_text', 'Contact', 'add_hassel_contact_field', __FILE__, 'footer_section',$args);
  add_settings_field('hassel_image_none', 'Default', 'add_hassel_image_none_field', __FILE__, 'featured_images_fallbacks_section',$args);
  add_settings_field('hassel_image_naturalscience', 'Natural Science', 'add_hassel_image_naturalscience_field', __FILE__, 'featured_images_fallbacks_section',$args);
  add_settings_field('hassel_image_photography', 'Photography', 'add_hassel_image_photography_field', __FILE__, 'featured_images_fallbacks_section',$args);

  wp_reset_query();
  $wp_query = new WP_Query(array(
    'post_type' => array('post','page','award_winners_post','award_winner_post','stipend_post','newsletter_post','appropriation_post','exhibition_post'),
    'meta_query' => array(
                     array(
                      'key' => '_hassel_meta_is_card_front',
                      'value' => 'yes'
                      )
                    )
  ));
  //->loop
  if ($wp_query->have_posts()){
      while ($wp_query->have_posts()){
        $wp_query->the_post();
        $postid = get_the_ID();
        $id = 'hassel_puff_' . $postid;
        $args = array(
                'postID' => $postid,
                'id' => $id
          );
        add_settings_field($id, get_the_title($postid), 'add_hassel_puff_field', __FILE__, 'puff_section',$args);
      }
  }
  //<-loop

  //-> loop post types
  if($user_info->user_level > 9){ // Only Administrator
    $post_types = get_post_types(array('menu_position'=>5));
    foreach ($post_types as $post_type) {
      $args = array(
                  'post_type' => $post_type
            );
      add_settings_field('hassel_section_for_' . $post_type, 'Post Type Section for: ' . $post_type, 'add_hassel_post_type_section_field', __FILE__, 'misc_section',$args);
    }
  }
  //<- loop post types

  //<- Add setting fields
}


function hassel_customization_fn() {
  if($_REQUEST['settings-updated']){
    echo "<div class='updated'><p>Updated</p></div>";
  }
?>
   <div id="theme-options-wrap" class="widefat">
      <div class="icon32" id="icon-tools"></div>
      <h2>Hasselblad Customization</h2>
      <p>Take control of your theme, by overriding the default settings with your own specific preferences.</p>

      <form method="post" action="options.php" enctype="multipart/form-data">
         <?php settings_fields('hassel_options'); ?>
         <?php do_settings_sections(__FILE__); ?>
         <p class="submit">
            <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
         </p>
   </form>
</div>

<?php
}

function add_hassel_post_type_section_field($args){
  $post_type = $args['post_type'];
  $options = get_option('hassel_options');
  $options_key = 'hassel_post_type_' . $post_type  . '_section';
  $section = $options[$options_key];
  $name = 'hassel_options[' . $options_key .']';
  $args = array(
    'post_type' => 'page',
    'hierarchical'=>0,
    'parent'=>0,
    'sort_column'=>'menu_order'
    );
  $pages = get_pages($args);

  echo "$options_key: " . $section;
  echo "<select name='" . $name . "' id='" . $name  ."'>";
  foreach ($pages as $page) {
    $selected = (string) $page->ID == $section ? "selected" : "" ;
    echo '<option ' . $selected .' value="' . $page->ID . '">' . $page->post_title . '</option>';
  }
  echo "/<select>";
}

function add_hassel_puff_field($args){
    $postid = $args['postID'];
    $id = $args['id'];

    $puff_permanent = get_post_meta($postid, '_hassel_meta_is_card_permanent', true);
    $puff_permanent = $puff_permanent === "yes" ? "yes" : "no" ;
    //$selected = $puff_permanent == 'yes' ? 'checked="true"' : '';
    $selected = $puff_permanent == 'yes' ? 'checked' : '';
    $input_name =  'hassel_options[' . $id . ']';
    $path = "wp-admin/post.php?post=" . $postid ."&action=edit";

    echo "<label>Delete </label><input type='checkbox'  name='" . $input_name  . "' value='$item'>$item</input>";
    echo "<br><br><a href='" . home_url($path) . "'>Edit Post</a>";
}

function add_hassel_descr_text_field(){
  $options = get_option('hassel_options');
  echo '<textarea rows="5" cols="60" type="text"  name="hassel_options[hassel_descr_text]">' . $options['hassel_descr_text'].'</textarea>';
}


function add_hassel_header_image_field(){
  echo '<input type="file" name="hassel_header_image" />';
  $options = get_option('hassel_options');
  if($options['hassel_header_image'] != ''){
    echo "<br/><img src='{$options['hassel_header_image']}' />";
  }
}

function add_hassel_descr_thumb_field(){
  echo '<input type="file" name="hassel_descr_thumb" />';
  $options = get_option('hassel_options');
  if($options['hassel_descr_thumb'] != ''){
    echo "<br/><img src='{$options['hassel_descr_thumb']}' />";
  }
}

function add_hassel_image_none_field(){
  $options = get_option('hassel_options');
  $image = $options['hassel_image_none'];
?>
  <label for="upload_image">
    Enter a URL or upload an image
    <input id="upload_image_none" type="text" size="60" name="hassel_options[hassel_image_none]" value="<?php echo $image ?>" /> 
    <br>
    <input id="upload_image_button" data-target="upload_image_none"  data-preview="upload_image_none_preview" class="button" type="button" value="Upload Image" />
  </label>
  <?php
  
    echo "<br/><img id='upload_image_default_preview' style='width:200px;height:auto' src='{$image}' />";
}

function add_hassel_image_naturalscience_field(){
  $options = get_option('hassel_options');
  $image = $options['hassel_image_naturalscience'];
?>
  <label for="upload_image">
    Enter a URL or upload an image
    <input id="upload_image_natural" type="text" size="60" name="hassel_options[hassel_image_naturalscience]" value="<?php echo $image ?>" /> 
    <br>
    <input id="upload_image_button_b" data-target="upload_image_natural"  data-preview="upload_image_natural_preview" class="button" type="button" value="Upload Image" />
  </label>
  <?php
  
    echo "<br/><img id='upload_image_natural_preview' style='width:200px;height:auto' src='{$image}' />";
}

function add_hassel_image_photography_field(){

  
    $options = get_option('hassel_options');
  $image = $options['hassel_image_photography'];
?>
  <label for="upload_image">
    Enter a URL or upload an image
    <input id="upload_image_photography" type="text" size="60" name="hassel_options[hassel_image_photography]" value="<?php echo $image ?>" /> 
    <br>
    <input id="upload_image_button_c" data-target="upload_image_photography" data-preview="upload_image_photography_preview"  data="" class="button" type="button" value="Upload Image" />
  </label>
  <?php
  
    echo "<br/><img id='upload_image_photography_preview' style='width:200px;height:auto' src='{$image}' />";

}

function add_hassel_descr_page_field(){
  $options = get_option('hassel_options');
  echo '<textarea rows="1" cols="60" type="text"  name="hassel_options[hassel_descr_page]">' . $options['hassel_descr_page'].'</textarea>';
}

function add_hassel_news_letter_id_field(){
  $options = get_option('hassel_options');
  echo '<textarea rows="1" cols="60" type="text"  name="hassel_options[hassel_news_letter_id]">' . $options['hassel_news_letter_id'].'</textarea>';
}

function add_hassel_descr_excerpt_field(){
    $options = get_option('hassel_options');
    echo '<textarea rows="1" cols="60" type="text"  name="hassel_options[hassel_descr_excerpt]">' . $options['hassel_descr_excerpt'].'</textarea>';
}

function add_hassel_contact_field(){
  $options = get_option('hassel_options');
  echo '<textarea rows="5" cols="60" type="text"  name="hassel_options[hassel_contact_text]">' . $options['hassel_contact_text'].'</textarea>';
}




function validate_hassel_options($hassel_options){

//-> images
  $keys = array_keys($_FILES);
  $i = 0;

  foreach ($_FILES as $image) {
  // if a files was upload
    if ($image['size']) {
      // if it is an image
      //  echo "<script type='text/javascript'>alert('" . $image['type'] . "')</script>";
      if (preg_match('/(jpg|jpeg|png|gif)$/', $image['type'])) {
        $override = array('test_form' => false);
        $file = wp_handle_upload($image, $override);

        $hassel_options[$keys[$i]] = $file['url'];
      } else {
        $options = get_option('hassel_options');
        $hassel_options[$keys[$i]] = $options[$descr_thumb];
        wp_die('No image was uploaded.');
      }
    } else {
      // else, retain the image that's already on file.
      $options = get_option('hassel_options');
      $hassel_options[$keys[$i]] = $options[$keys[$i]];
    }
    $i++;
  }
  //<- images

foreach( $hassel_options as $key => $value){
  if(strrpos($key, "hassel_puff_") > -1){
    $postid = str_replace("hassel_puff_", "", $key);
    //echo $postid;
      if(add_post_meta($postid, '_hassel_meta_is_card_front', 'no' , true)){
            }else{
          update_post_meta($postid, '_hassel_meta_is_card_front', 'no' );
      };
    }
  }

  return $hassel_options;
}

function section_hassel_cb(){}

// Add stylesheet
add_action('admin_head', 'admin_register_hassel_head');

function admin_register_hassel_head() {    
	$url = get_stylesheet_directory() . '/options/options_page.css';
	echo "<link rel='stylesheet' href='$url' />\n";
}

?>