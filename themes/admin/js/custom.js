/* 	
	ADMINPRO - CUSTOM.JS
	Version: 1.0
	Updated: 9/10/2011
	Author: Justin Scheetz
	
	Need support? http://scheetzdesigns.ticksy.com
*/
	

// Wait for the page to load...

$(document).ready(function() {
	
	// Delete link confirmation
	$('.deletelink').click(function() {
		if(confirm('Are you sure you would like to continue?')) {
			window.location = $(this).attr('href');
		} else {
			return false;
		}
	});
	
	 $('.tooltip').tipsy();
	
	
	/* OPEN & CLOSE PANELS													*/
	/* -------------------------------------------------------------------- */
	
	var screenSize = $('body').width();
	
	$('.panel .cap').click(function(){
	
		var content = $(this).parent().find('.content');
		var tabs = $(this).parent().find('.tabs');
		var accordionWrapper = $(this).parent().find('.accordion-wrapper');
		var isOpen = content.is(":visible");
		if (!isOpen) { var isOpen = tabs.is(":visible"); }
		if (!isOpen) { var isOpen = accordionWrapper.is(":visible"); }
		if (isOpen){
			if (screenSize <= 1024){
				content.hide();
				tabs.hide();
				accordionWrapper.hide();
			} else {
				content.slideUp();
				tabs.slideUp();
				accordionWrapper.slideUp();
			}
		} else {
			if (screenSize <= 1024){
				content.show();
				tabs.show();
				accordionWrapper.show();
			} else {
				content.slideDown();
				tabs.slideDown();
				accordionWrapper.slideDown();
			}
		}
	});
	
	// User select all checkbox
    $('.check-all').live('click', function() {
    	// Is it checked or not
    	$isChecked = $(this).is(':checked');
    	$('input[type="checkbox"]').attr('checked', $isChecked);
    	
    });
	
	$('.alert-text .close').click(function(){
		$(this).parents('.alert-wrapper').slideUp('normal');
		return false;
	});
	
	/* /// END - OPEN & CLOSE PANELS /// */

	/* TABS																	*/
	/* -------------------------------------------------------------------- */
	
    //When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li a").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).parent().addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
		
	});
	
	/* /// END - TABS /// */
	
	
	
	/* ACCORDIONS															*/
	/* -------------------------------------------------------------------- */
	
	// On load, show the first panel in each accordion.
	$('.accordion').each(function(){
		$(this).find('.accordion-block').eq(0).addClass('open');
		$(this).find('.accordion-block').eq(0).find('.accordion-content').show();
	});
	
	$('.accordion-block h3').click(function(){
		if($(this).parent().hasClass('open')){
			$('.accordion-block .accordion-content').slideUp('fast',function(){
				$('.accordion-block').removeClass('open');
			});
		} else {
			$('.accordion-block .accordion-content').slideUp('fast');
			$(this).parent().find('.accordion-content').slideDown('fast');
			$('.accordion-block').removeClass('open');
			$(this).parent().addClass('open');
		}
	});
	
	/* /// END - ACCORDIONS /// */
	
	
	
	/* GALLERIES															*/
	/* -------------------------------------------------------------------- */
	
	// Add Fancybox lightboxing to each of the images.
	try { $('.fancybox').fancybox(); } catch(err) { /* Error Stuff */ }
   	
   	
   	
   	/* FORMS																*/
	/* -------------------------------------------------------------------- */
   	
   	
   	// Custom file field
   	$('form.styled input[type=file]').each(function(){
   		$(this).before('<input class="textbox file-field" name="uploadField" type="text" value="" /><span class="browse button medium grey">Browse...</span>');
   	});
   	
   	$('form.styled input[type=file]').animate({'opacity':0},0);
   	
   	$('form.styled input[type=file]').hover(function(){
   		$(this).parent().find('.browse').addClass('hover');
   	},function(){
   		$(this).parent().find('.browse').removeClass('hover');
   	});
   	
   	// "Chosen" field
   	// http://harvesthq.github.com/chosen/

	try {
   		$('form.styled').find('.chosen').chosen();
   		$('body').find('.chosen').chosen();
   	}
   	catch(err){
   		// Error stuff here
   	}
   	   	
   	/* /// END - FORMS /// */
   	
   	
   	
   	/* MOBILE DROPDOWN NAVIGATION											*/
	/* -------------------------------------------------------------------- */
   	
   	$('.mobile-navigation').change(function(){
   		var url = $(this).val();
   		location.href = url;
	  	return false;
   	});
   	
   	/* /// END - MOBILE DROPDOWN NAVIGATION /// */
   	
   	
   	
   	/* 	FOR MOBILE WEB APPS
   		This allows the app to stay contained instead of launching Safari
   		when clicking on links.												*/
	/* -------------------------------------------------------------------- */
	
	/*$('a').click(function(){
		if ( !$(this).hasClass('fancybox') ){
	  		var href = $(this).attr('href');
	  		if (href) { var firstChar = href.substring(0,1); }
	  		if (href && href != '#' && firstChar != '#') {
	  			location.href = href;
	  			return false;
	  		} else {
	  			return false;
	  		}
	  	}
  	});*/

});

/* FUNCTIONS - RESIZE THE "CHOSEN" STYLE DROPDOWNS						*/
/* -------------------------------------------------------------------- */
function resizeChosenWidths(){
	$('form.styled').each(function(){
		$(this).find('.chzn-container').width('100%');
		var containerWidth = $(this).find('.chzn-container').width();
		$(this).find('.chzn-drop').width(containerWidth - 2);
		var searchWidth = $(this).find('.chzn-search').width();
		$(this).find('.chzn-search input').width(searchWidth - 26);
	});
}

/* /// END - FUNCTIONS - RESIZE THE "CHOSEN" STYLE DROPDOWNS /// */