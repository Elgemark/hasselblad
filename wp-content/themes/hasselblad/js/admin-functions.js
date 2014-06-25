(function(window){
	self = this;
	jQuery(document).ready(function($){
		self.$ = $; 
    	$('.hassel_color_picker').wpColorPicker();
    	$('.hassel_date_picker').datepicker({dateFormat : 'yy-mm-dd'});
		$('#upload_image_button').click(open_image_browser);
		$('#upload_image_button_b').click(open_image_browser);
		$('#upload_image_button_c').click(open_image_browser);
	});

		var custom_uploader;
		var dataPreview;
		var dataTarget;
		this.open_image_browser = function(e){

			dataPreview = $(e.target).data('preview');
			dataTarget = $(e.target).data('target');

			console.log("dataTarget",dataTarget);

	    	 e.preventDefault();	 
	        //If the uploader object has already been created, reopen the dialog
	        if (custom_uploader) {
	            custom_uploader.open();
	            return;
	        }
	 
	        //Extend the wp.media object
	        custom_uploader = wp.media.frames.file_frame = wp.media({
	            title: 'Choose Image',
	            button: {
	                text: 'Choose Image'
	            },
	            multiple: false
	        });
	 
	        //When a file is selected, grab the URL and set it as the text field's value
	        custom_uploader.on('select', function() {
	            attachment = custom_uploader.state().get('selection').first().toJSON();
	            $('#' + dataTarget).val(attachment.url);
	            $('#' + dataPreview).attr('src',attachment.url);
	        });
	 
	        //Open the uploader dialog
	        custom_uploader.open();
	    }


}(window));
