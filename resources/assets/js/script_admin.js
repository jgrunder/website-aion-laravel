$(document).ready(function(){

	/**
	 * Shop Add Item
	 */
	var $idItem = $('#idItem');

	$idItem.on('focusout', function() {

		var idItem = $(this).val();

		$.get("/database/item/" + idItem, function(data) {
			/* For aiondatabase.net
			var qualityItem = $(data).find('tr:nth-child(2) td').attr('class');
			qualityItem 	= qualityItem.replace('  ', '' ).replace('quality-', '' ).toUpperCase();
			*/
			var qualityItem = $(data).find('.item_title').attr('class');
			qualityItem 	= qualityItem.replace('item_title ', '' ).replace('quality-', '' ).toUpperCase();

			/* For aiondatabase.net
			var nameItem = $(data).find('.item_title').text();
			*/
			var nameItem = $(data).find('.item_title').first().text();

			if(nameItem !== ''){
				$('#nameItem').val(nameItem);
			}

			if(qualityItem !== ''){
				$('#qualityItem').val(qualityItem);
			}

			if(data.includes("Réservé aux Elyséens") || data.includes("Elyos Only")) {
				console.log("ELYOS");
				$('#race option[value="ELYOS"]').prop('selected', 'selected');
			}
			else if(data.includes("Réservé aux Asmodiens") || data.includes("Asmodian Only")) {
				console.log("ASMODIANS");
				$('#race option[value="ASMODIANS"]').prop('selected', 'selected');
			}

		});


	});

});
