(function(window){

	var hasselPosterData = {};
	var itemClicked;
	var hash;
	var isMobile = false;

	// resize 
	$(document).ready(function(){

		if(window.BrowserDetect.browser == 'Explorer' && window.BrowserDetect.version < 8){
			$('#hassel-poster img').load(function() {
  				onLoadPoster();
			});
		}else{
			
			$('#hassel-poster').imagesLoaded(function() {
   				onLoadPoster();
			})
		}

		if(!(window.BrowserDetect.browser == 'Explorer' && window.BrowserDetect.version < 9) && !isMobile){
			$('#hassel-poster').fadeOut(0);
		}
		
		

		// -> Mobile Menu
		isMobile = $("#wrap").css('overflow') == "hidden"; // Checks if CSS mobile.css is loaded
		if(!isMobile ){
			$("#toggle-bar").css('display','none');
			//$("#mmenu").hide();
			
		}else{
			$(".mtoggle").click(function() {
				$("#nav").css("height","auto");
   				$("#mmenu").slideToggle(500);}
   			);

		}
   		// <- Mobile Menu

   		if(isMobile){
   			$(".page-start").css("float","left");
   			$(".page-start #hassel-card").css("float","left");
   		}

   		//-> Anchor
   		/*
   		$(window).click(updateCurrentPage);
   		updateCurrentPage();
   		*/
   		//<- Anchor

		$(window).resize(onResize);
		onResize();
	});

	var onLoadPoster = function(){
		if(!isMobile){
			$('#hassel-poster').fadeIn(500);
		}
		hasselPosterData.originalW = $("#hassel-poster img").css("width").replace("px","");
		hasselPosterData.originalH = $("#hassel-poster img").css("height").replace("px","");
		hasselPosterData.originalRatio = hasselPosterData.originalH/hasselPosterData.originalW;	
		onResize();
	}

	var updateCurrentPage = function(e){
		hash = window.location.hash.replace("#","");
		if(hash == ""){return;}
		//console.log("hash",hash);
	   	//$(".anchor-" + hash).addClass("current-page-item");
	   	//$(".anchor-" + hash).find("a").css("color","#ab8349");
	   	if(itemClicked){itemClicked.find("a").css("color","#000")};
	   	itemClicked = $(".anchor-" + hash);
	   	itemClicked.find("a").css("color","#ab8349");
	}

	var onResize = function(e){
		var hasselPosterImg = $("#hassel-poster img");

		var hasselPosterWidth = $('#hassel-poster').width();
		var hasselPosterHeight = hasselPosterData.originalRatio * hasselPosterWidth;

		//set width & height op poster image
		hasselPosterImg.css("width",hasselPosterWidth)
		hasselPosterImg.css("height",hasselPosterHeight);


		//console.log(hasselPosterHeight + ":" + $("#hassel-page").height());

		if(hasselPosterHeight > $("#hassel-page").height() || hasselPosterWidth < 1){
			$("#hassel-page-wrap").css("height",hasselPosterHeight);
		}
	}

}(window));
