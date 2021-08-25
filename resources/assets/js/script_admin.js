$(document).ready(function(){

	/**
	 * Shop Add Item
	 */
	var $idItem = $('#idItem');

	$idItem.on('focusout', function() {

		var idItem = $(this).val();

		$.get("/database/item/" + idItem, function(data) {

			var qualityItem = $(data).find('tr:nth-child(2) td').attr('class');
			qualityItem 	= qualityItem.replace('  ', '' ).replace('quality-', '' ).toUpperCase();

			var nameItem = $(data).find('.item_title').text();

			if(nameItem !== ''){
				$('#nameItem').val(nameItem);
			}

			if(qualityItem !== ''){
				$('#qualityItem').val(qualityItem);
			}

		});


	});

});
