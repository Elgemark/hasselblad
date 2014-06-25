<?php 
$options = get_option('hassel_options');
?>

	<div id="hassel-footer">
   			<div id="contact">
			<p><?php echo $options['hassel_contact_text'] ?></p>
			</div>
	</div>


<?php if ( is_active_sidebar( 'hassel_footer')) { ?>     
   <div id="footer-area">
			<?php dynamic_sidebar( 'hassel_footer' ); ?>
        </div><!-- // footer area -->   
<?php }  ?>     
      



     
</div><!-- // wrap -->   

	<?php wp_footer(); ?>
	
</body>
</html>