// JavaScript Document
$(function() {
	// Top Menu
	ddsmoothmenu.init({
		mainmenuid: "smoothmenu1", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		//customtheme: ["#1c5a80", "#18374a"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	});

	// Open currently viewed image in new tab
	$('#gallery_download_image').live('click', function() {
		window.open($('#pp_full_res').children('img').attr('src'));
	});
	
	// Pretty photo
	$("a[rel^='prettyPhoto']").prettyPhoto({deeplinking: false, social_tools: "<a href='javascript:void(0);' class='buttonPro small rounded' id='gallery_download_image'>Download Image</a>"});
	
});