jQuery(function($){
	$('.more').click(function(e){
        e.preventDefault();
 
		var button = $(this),
		    data = {
			'action': 'loadmore',
			'query': bb_loadmore_params.posts,
			'page' : bb_loadmore_params.current_page
		};
 
		$.ajax({
			url : bb_loadmore_params.ajaxurl, 
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...'); 
			},
			success : function( data ){
				if( data ) { 
                  
					button.text( 'More posts' ).closest('.container').append(data).children().last().append(button);
					bb_loadmore_params.current_page++;
 
					if ( bb_loadmore_params.current_page == bb_loadmore_params.max_page ) 
						button.remove(); 
 
				} else {
					button.remove(); 
				}
			}
		});
	});
});