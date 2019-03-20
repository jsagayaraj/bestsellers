$(function() {
	
	$('.buy-btn').live('click', function(e){
		var article = $(this).attr('id');
		var url = window.location.origin + '/ajax/ajouter_pannier.php?id=' + article;

		//$('#preloader').show();

	    $.ajax({
	    	url: url , 
	    	success: function(result) {
	        	$(".sum_header").html(result);
	        	//$('#preloader').hide();
	        	alert('Produit ajouté');
	    	}
	    });
	});

});