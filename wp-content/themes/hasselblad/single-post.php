  
<?php global $post ?>
<?php get_header(); ?>
  

    <div id="hassel-page-wrap">
    	
      <?php get_template_part('hassel','poster'); ?>
      
      <div id="hassel-page">
      		<div id="hassel-posts">
           	 	<?php get_template_part('hassel','loop'); ?>
           	 </div>  
      </div>
    </div>  

 


<?php get_footer(); ?>