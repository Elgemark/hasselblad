<!DOCTYPE html>
<!-- hassel WordPress Theme by Eleven Themes (http://www.eleventhemes.com) - Proudly powered by WordPress (http://wordpress.org) -->

	<!-- meta -->
    <html <?php language_attributes();?>> 
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('sitename'); ?> <?php wp_title(); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
    <!-- styles -->
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/reset.css" />

  <!--[if lt IE 7]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
  <![endif]-->

    <?php
      $options = get_option('hassel_options');
      $hassel_logo = $options['hassel_header_image'];
    ?> 
   
      <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css"/> 
    
    <!-- responsive -->
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
        <link rel="stylesheet" type="text/css" media="handheld, only screen and (max-width: 480px), only screen and (max-device-width: 480px)" href="<?php echo get_template_directory_uri(); ?>/css/mobile.css" />
    
 	<!-- wp head -->
	<?php wp_head(); ?>
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php 
  global $post; 
  global $global_page_id;
  global $hassel_is_root;
  $hassel_is_root = true;

  $global_page_id = $post->ID;
?>

</head>

<body <?php body_class(); ?>>

<div id="wrap">
	<div id="header">

    	<div id="logo">
        	<a href="<?php echo home_url( '/' ); ?>"  title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                 <?php if ($hassel_logo != '') {?>
                 	 <img src="<?php echo $hassel_logo; ?>" alt="<?php bloginfo('sitename'); ?>">
                 <?php } ?>
            </a>
            
       </div>

       <div id="delimitter"></div >

      <?php $history_url = get_bloginfo('wpurl') . '?page_id=' . icl_object_id($options['hassel_descr_page'],'page');?>
       <div id="description">
          <div id="text">
              <a href="<?php echo $history_url; ?>">
              <p><?php 
              echo $options['hassel_descr_text']; 
              ?></p></a>
          </div >
          <div id="thumb">
            <a href="<?php echo $history_url; ?>">
              <img src="<?php echo $options['hassel_descr_thumb']; ?>">
            </a>
            <div id="thumb-text"><a href="<?php echo $history_url; ?>"><p><?php echo $options['hassel_descr_excerpt']; ?></p></a></div>
          </div >
       </div>

       <div id="delimitter"></div >

       <div id="misc">
          <div id="hassel-lang"><?php do_action('icl_language_selector'); ?></div>
          <div id="hassel-search"><?php get_search_form(true); ?></div>
           <div id="hassel-share">
             <?php 
             $share_args = array('url'=>get_bloginfo('url'));
             if(function_exists('hint_share')){hint_share($share_args);} 
             $news_letter_url = get_bloginfo('wpurl') . '?page_id=' . icl_object_id($options['hassel_news_letter_id'],'page') ;
             ?>
             <a href="<?php echo $news_letter_url ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/images/mail_16_gold.png'?>"></img></a>
           </div>
        </div>

     <div id="delimitter" class="mobile"></div >

      <!-- Naviagtion -->
       <?php if ( has_nav_menu( 'main_nav' ) ) { ?>
  		 <div id="nav"><?php wp_nav_menu( array( 'theme_location' => 'main_nav' ) ); ?></div>
       <?php } else { ?>
       <?php 
          $walker = new Walker_hassel_menu();
          $list_args = array(
            'depth'=>1,
            'title_li'=>'',
            'walker'=>$walker
            )
        ?>

      <nav id="mobile">
        <div id="toggle-bar">
          <!-- -->
            <a class="navicon mtoggle" href="#"></a>
        </div>
        <div id="nav"><ul id="mmenu"><?php  wp_list_pages($list_args);  ?></ul></div>
      </nav>

	     <?php } ?>
      <!-- Naviagtion -->

   </div>
<!-- // header -->           