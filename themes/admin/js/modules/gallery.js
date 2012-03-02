$(document).ready(function() {	
	
	/* /// END - OPEN & CLOSE PANELS /// */
	
	
	
	/* SORTABLE TABLES														*/
	/* -------------------------------------------------------------------- */
	
	try {
		$('.tablesorter')
		.tablesorter({widthFixed: true, widgets: ['zebra']})
	    .tablesorterPager({size: 100, container: $("#table-pager")});
	    
	    $(".pagesize").chosen();
	}
	catch(err){
		// Error stuff here
		console.log(err);
	}
    
    /* /// END - SORTABLE TABLES /// */
    
    
    // Add Fancybox lightboxing to each of the images.
	try { $('.fancybox').fancybox(); } catch(err) { /* Error Stuff */ }

	// On window resize, adjust the sizing.
	$(window).resize(function(){
  		setTimeout("resizeGalleries()",50);
  	});
  	
      	// When you check a checkbox, add some styling to the image block
  	$('.gallery-item .checkbox-block input').click(function(){
  	
  		var checkedLayer = $(this).parent().parent().find('.checked-layer');
  	
  		if ($(this).attr('checked')){
  			checkedLayer.show();
  		} else {
  			checkedLayer.hide();
  		}
  		
   	});
   	
   	$('.hidden-image img').css({border: '3px solid red'});
   	$('.cover-image img').css({border: '3px solid blue'});
   	
   	$('.gallery').find('.next').click(function(){
   		var thisGallery = $(this).parent().parent().parent().find('.gallery-wrap');
   		
   		// Get page information
   		var pageDisplayContent = $(this).parent().find('.pagedisplay').val();
   		pageDisplayContent = pageDisplayContent.split('/');
   		currentPage = pageDisplayContent[0];
   		totalPages = pageDisplayContent[1];
   		var nextPage = parseInt(currentPage) + 1;
   		
   		// Get this galleries height
   		var galleryHeight = $(this).parent().parent().parent().find('.gallery-wrap').height();
   		var galleryHeight = galleryHeight + 10;
   		
   		// Slide the gallery to the next page
   		if (nextPage <= totalPages){
   			galleryPaginate(thisGallery,nextPage,galleryHeight,totalPages);
   		}
   	});
   	
   	$('.gallery').find('.prev').click(function(){
   		var thisGallery = $(this).parent().parent().parent().find('.gallery-wrap');
   		
   		// Get page information
   		var pageDisplayContent = $(this).parent().find('.pagedisplay').val();
   		pageDisplayContent = pageDisplayContent.split('/');
   		currentPage = pageDisplayContent[0];
   		totalPages = pageDisplayContent[1];
   		var prevPage = parseInt(currentPage) - 1;
   		
   		// Get this galleries height
   		var galleryHeight = $(this).parent().parent().parent().find('.gallery-wrap').height();
   		var galleryHeight = galleryHeight + 10;
   		
   		// Slide the gallery to the previous page
   		if (prevPage > 0){
   			galleryPaginate(thisGallery,prevPage,galleryHeight,totalPages);
   		}
   	});
   	
   	$('.gallery').find('.last').click(function(){
   		var thisGallery = $(this).parent().parent().parent().find('.gallery-wrap');
   		
   		// Get page information
   		var pageDisplayContent = $(this).parent().find('.pagedisplay').val();
   		pageDisplayContent = pageDisplayContent.split('/');
   		currentPage = pageDisplayContent[0];
   		totalPages = pageDisplayContent[1];
   		
   		// Get this galleries height
   		var galleryHeight = $(this).parent().parent().parent().find('.gallery-wrap').height();
   		var galleryHeight = galleryHeight + 10;
   		
   		// Slide the gallery to the last page
   		galleryPaginate(thisGallery,totalPages,galleryHeight,totalPages);
   	});
   	
   	$('.gallery').find('.first').click(function(){
   		var thisGallery = $(this).parent().parent().parent().find('.gallery-wrap');
   		
   		// Get page information
   		var pageDisplayContent = $(this).parent().find('.pagedisplay').val();
   		pageDisplayContent = pageDisplayContent.split('/');
   		currentPage = pageDisplayContent[0];
   		totalPages = pageDisplayContent[1];
   		
   		// Get this galleries height
   		var galleryHeight = $(this).parent().parent().parent().find('.gallery-wrap').height();
   		var galleryHeight = galleryHeight + 10;
   		
   		// Slide the gallery to the first page
   		galleryPaginate(thisGallery,1,galleryHeight,totalPages);
   	});
   	
   	setTimeout("resizeGalleries()",50);
   	
   	/* /// END - GALLERIES /// */
    
});

   	/* FUNCTIONS - GALLERY													*/
/* -------------------------------------------------------------------- */

var GalleryRowsPerPage = 10;
var GalleryThumbsToFitVariable = 110;
var GalleryThumbsToFitVariableSecond = 100;
var GalleryThumbsToFitVariableAdjust = 20;

function resetGalleryPager(thisGallery,thumbsToFit,newWrapHeight){
	var totalThumbs = thisGallery.find('.gallery-item').size();
	var totalVisibleThumbs = thumbsToFit * GalleryRowsPerPage;
	var totalPages = Math.ceil(totalThumbs / totalVisibleThumbs);
	window.adminpro_totalPages = totalPages;
	thisGallery.parent().find('.pagedisplay').val('1/'+totalPages);
	galleryPaginate(thisGallery,1,newWrapHeight,totalPages);
	window.adminpro_newWrapHeight = newWrapHeight;
}

function galleryPaginate(thisGallery,currentPage,galleryHeight,totalPages){
	var pageLocation = -1 * ((currentPage * galleryHeight) - galleryHeight);
	thisGallery.find('.gallery-pager').css('top',pageLocation);
	thisGallery.parent().find('.pagedisplay').val(currentPage+'/'+totalPages);
	window.currentPage = currentPage;
}

function resizeGalleries(){

	galleryWrap = $('.gallery-wrap');
	galleryWrap.each(function(){
		
		var thisGallery = $(this);
		var galleryWrapWidth = thisGallery.width();
		var thumbsToFit = Math.floor(galleryWrapWidth / GalleryThumbsToFitVariable);
		var totalThumbWidth = thumbsToFit * GalleryThumbsToFitVariable;
		var leftOverWidth = galleryWrapWidth - totalThumbWidth;
		var addToThumbWidth = Math.floor(leftOverWidth / thumbsToFit);
		var totalThumbSize = addToThumbWidth + GalleryThumbsToFitVariableSecond;
		var newWrapHeight = (totalThumbSize * GalleryRowsPerPage) - GalleryThumbsToFitVariableAdjust;
		thisGallery.find('.gallery-item').width(totalThumbSize).height(totalThumbSize);
		thisGallery.height(newWrapHeight);
		
		resetGalleryPager(thisGallery,thumbsToFit,newWrapHeight);
	
	});
	
}

/* /// END - FUNCTIONS - GALLERY /// */