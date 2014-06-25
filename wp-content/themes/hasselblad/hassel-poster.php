<?php 
    global $post;
    $postID = hassel_get_poster_id();
    $poster_title_color = get_post_meta($postID,'_hassel_meta_poster_title_color', true );
    $poster_title_color = $poster_title_color == "" ? "#FFFFFF" : $poster_title_color;
    $poster_h_style = "color:" . $poster_title_color . ';';
    $poster_title_align = get_post_meta($postID,'_hassel_meta_poster_title_align', true );
    $poster_title_isRTL =  $poster_title_align == "right" ? "no" : "yes";
    $poster_title_align = $poster_title_align == "" ? "left" : $poster_title_align;
    $poster_header_style = $poster_title_align == "left" ? "left:30px; text-align: left;" : "right:30px; text-align: right;";
    $poster_title = mb_strtoupper(get_post_meta( $postID, '_hassel_meta_poster_title', true ));
?>

<div id="hassel-poster" data-rtl="<?php echo $poster_title_isRTL ?>"> <!-- hassel poster-area-->
    <?php 
        if(is_front_page()){
            
            if(has_post_thumbnail($postID)){
                echo  get_the_post_thumbnail($postID,"poster-image") ; 
            }else{
                 global $sitepress;
                 $poster_post = get_post($postID);
                $icl_id = icl_object_id($postID,$poster_post->post_type,true,$sitepress->get_default_language());
                echo get_the_post_thumbnail($icl_id,"poster-image") ; 
            }

        }else{
            $area = get_post_meta($post->ID,'_hassel_meta_area',true);
            $options = get_option('hassel_options');
           
            if(has_post_thumbnail($post->ID)){
                echo  get_the_post_thumbnail($post->ID,"poster-image") ; 
            }else{ // get fallback image
                $area = "none";
                $image = $options['hassel_image_' . $area];
                $image_url = hassel_get_image($image,'poster-image');
                echo '<img src="' . $image_url . '">'; 
            }
        }
         
    ?>
    <?php if(is_front_page()){ ?>

    <div id="header" style="<?php echo $poster_header_style;?>"><a href="<?php echo get_permalink($postID) ?>" style="color:<?php echo $poster_title_color; ?>"><h style="<?php echo $poster_h_style;?>"><?php echo $poster_title; ?></h></a></div>
    <?php }?>
 </div>
