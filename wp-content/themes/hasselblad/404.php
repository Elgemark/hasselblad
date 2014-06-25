<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	    <div id="hassel-page-wrap">

      <?php get_template_part('hassel','poster'); ?>

      <div id="hassel-page">

      	<div id="hassel-card-area" class="page-root">
             	<div class="hassel-copy">
             	<h1>Oops! Page not found.</h1>
             	<br>
             	<h1>Sök</h1>
             	<?php get_search_form(true); ?>
             	</div>
                <?php 
                  if($wp_query->found_posts < 5){
                    get_template_part('hassel','loop-card'); 
                  }else{
                    get_template_part('hassel','loop-card-small'); 
                  }
                ?>
            </div>

      </div>
    </div>  

<?php get_footer(); ?>