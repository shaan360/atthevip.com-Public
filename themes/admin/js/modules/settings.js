$(document).ready(function() {	
	
	/* /// END - OPEN & CLOSE PANELS /// */
	
	
	
	/* SORTABLE TABLES														*/
	/* -------------------------------------------------------------------- */
	
	try {
		$('.tablesorter')
		.tablesorter({widthFixed: true, widgets: ['zebra']}) 
	    .tablesorterPager({container: $("#table-pager")});
	    
	    $(".pagesize").chosen();
	}
	catch(err){
		// Error stuff here
		console.log(err);
	}
    
    /* /// END - SORTABLE TABLES /// */
    
});