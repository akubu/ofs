var loading_categories = false;
var loading_features = false;
(function() {
	var categories = new Array();
	var all_features = new Array();
	var category_tree = new Array();
	var category_list = new Array();
	var product_name_format = [TYPE_OF_STEEL, TYPE_OF_ROLLING, OTHER_PROPERTIES, 'CATEGORY', 27, 29, 34, 23, 36, 37, 31, 32, 24, 38, 30,  46, 47, 18, 33];
	
	//get all categories
	$.ajax({
		type: "GET",
		url: "/api/categories",
		dataType: "json",
		success: function(response) {
			
			//filter categories as per status
			handleCategories(response);
			
			//if category data is loaded, get features for categories
			if(categories.length) {
				getFeatures();
			}
		},
		error : function(xhr, status, error) {
			showMessage(error, 'error');
			$("#categories").prop("disabled", false);
			$("#categories option").remove();
		}
	});
	
	$(document).on('blur', '.features .required.error', function () {
		if($(this).val().trim().length == 0) {
			$(this).addClass('error').attr({title: msg.EMPTY_FIELD});
		} else {
			$(this).removeClass('error').removeAttr('title');
		}
	})
	
	$("#product").submit(function(event) {
		event.preventDefault();
		$('.features .required').removeClass('error').removeAttr('title');
		
		validateRequiredFields($('.features .required'));
		if($('.required.error').length) {
			return;
		}
		
		//generate product name
		var features = categories[$('#categories').val()].features;
		var product_features = new Array();
		var product_names = new Array();
		
		//keep features indexed by feature id 
		for(var i = 0; i< features.length; i++) {
			product_features[features[i].feature_id] = features[i]
		}

		features = product_features;
		
		var product_features = $('.features');
		
		for(var index = 0; index < product_features.length; index++ ) {
			product_names[index] = '';			
			for(var i = 0; i < product_name_format.length; i++) {
				if(product_name_format[i] == 'CATEGORY') {
					product_names[index] += $('#categories option:selected').text().split(' (')[0] + ' ';
					continue;
				}
				
				if(!(product_name_format[i] in features) || 
					features[product_name_format[i]].feature_type == 'G') {
					continue;
				}
				
				var parent = features[product_name_format[i]].parent_id == 0 ? ('.features:eq(' + index + ') ') : '';
				var feature_id = features[product_name_format[i]].feature_id;

				//if field is not selected, skip
				if($(parent + '[name*="product_features[' + feature_id + ']"]').val() == '') {
					continue;
				}
				
				if(features[product_name_format[i]].feature_type == 'M') {
					if(features[product_name_format[i]].description.toLowerCase() == constant.TYPE_OF_STEEL) {
						var steel_type = $(parent + '[name*="product_features[' + feature_id + ']"]').val();

						if(steel_type != '') {
							var steel = $(parent + '[name*="product_features[' + feature_id + ']"] option:selected').text();
							
							if(steel.toLowerCase() == 'mild steel') {
								product_names[index] +=  constant.MS;
							} else {
								product_names[index] +=  steel + ' ';
							}
						}
					} else {
						var checked = $(parent + '[name*="product_features[' + feature_id + ']"]:checked');

						for(var j = 0; j < checked.length; j++) {
							var variant_value = all_features[feature_id].variants[$(checked[j]).val()].variant;

							if(variant_value.toLowerCase() == constant.PO_1 || 
							   variant_value.toLowerCase() == constant.PO_2) {
							   product_names[index] += constant.PO + ' ';
							} else {
							   product_names[index] += variant_value + ' ';
							}
						}
					}
					continue;

				} else if ( features[product_name_format[i]].feature_type == 'C' ) {
					var variant_id = $(parent + '[name*="product_features[' + feature_id + ']"]:checked').val()
				} else {
					var variant_id = $(parent + '[name="product_features[' + feature_id + ']"]').val();
				}

				if(features[product_name_format[i]].parent_id != 0 &&  variant_id.trim() == '') {
					continue;
				}

				product_names[index] += all_features[feature_id].variants[variant_id].variant + ' ';
			}
		}
		saveProducts(product_names, 0);
	});

    $("#reference_sku").autocomplete({
		minLength: 3,
		source: source('reference_sku'),
		focus: function(event, ui) {
			$("#reference_sku").val(ui.item.name);
			return false;
		},
		select: function(event, ui) {
			populateFeatures(ui.item.product);
			return false;
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		return $( '<li class="' + ('id' in item && item.id == -1 ? 'ui-state-disabled disabled-item' : '') + '">' )
			.append("<a>" + ('id' in item && item.id == -1 ? item.value :(item.name + "(" + item.sku + ")"))+"</a>")
			.appendTo(ul);
	};
	
	$('#recent-products').on('click', 'li a', function(event) {
		event.preventDefault();
		resetPage();
		$('#reference_sku').val($(this).text().trim().split('(')[0]);
		$('.loading-container').removeClass('hide');
		$.ajax({
			url: "/api/products/",
			dataType: "json",
			data: "pcode=" + $(this).attr('data-sku'),
			success: function(result) {
				$('.loading-container').addClass('hide');
				populateFeatures(result.data.products[0]);
			},
			error : function(xhr, status, error) {
				$('.loading-container').addClass('hide');
				showMessage('Error occured while loading product details.', 'error');
			}
		});
	
	});
		
	$('#create_new').click(function() {
		if(all_features.length == 0 || categories.length == 0) {
			showMessage(msg.FEATURES_LOAD_ERROR, 'error');
			return;
		}

		$('div.categories').removeClass('hide');
		$('#categories').val('').change();
		$('#category_search').val('');
		$('#reference_sku').val('');
		$('.features').prev().addClass('hide');
		$('.properties').prev().addClass('hide');
		$('.button-div').addClass('hide');
		$('.add-feature-group').addClass('hide');
		$('.features').html('');
		$('.features:not(:first)').remove();
		
	});

	$("#categories").change(function() {

		$('.feature').remove();
		$('.properies .feature').remove();
		$('.button-div').removeClass('hide');
		
		if($(this).val() == '')  {
			return;
		}
		
		$('.add-feature-group').removeClass('hide');
		$('div.categories').removeClass('hide');
		var category = categories[$(this).val()];
		var parent_id = false;
		var features ;
		
		if(typeof category == 'undefined') {
			showMessage(msg.CATEGORY_INFO_FETCH_ERROR, 'error');
			return;
		}
		
		$('#category_search').val(category.category);
		
		if(!('parent_mapped' in category)) {
			if(!('features' in category) || category.features.length == 0) {
				category.features = new Array();
			}

			if(category.parent_id != 0 && 'features' in categories[category.parent_id] && 
						categories[category.parent_id].features.length > 0) {
				category.features = category.features.concat(categories[category.parent_id].features);
			}
			categories[$(this).val()].parent_mapped = true;
		}

		if(category.features.length == 0) {
			showMessage(msg.NO_FEATURES_IN_CATEGORY, 'warning');
			return;
		}
		
		showFeatureFields(category);
		
		$('.features').prev().removeClass('hide');
		$('.features').removeClass('hide');
		
		if($('.properties div').length) {
			$('.properties .col-sm-offset-2:last').removeClass('col-sm-offset-2');
			$('.properties .col-sm-offset-2:last').removeClass('col-sm-offset-2 col-sm-4').addClass('col-sm-offset-1 col-sm-2');
			$('.properties').prev().removeClass('hide');
			$('.properties').removeClass('hide');
		} else {
			$('.properties').prev().addClass('hide');
			$('.properties').addClass('hide');
		}
	});

	$('body').on('click', '.add-feature-group', function() {
		var header = $('<div></div>').attr({class: 'form-group'})
						.append(
							$('<hr/>').attr({class: 'col-sm-offset-2 col-sm-8'})
						);
		var remove = $('<div></div>').attr({class: 'col-sm-offset-2 col-sm-8 right-align'})
						.append(
							$('<a></a>').attr({href: '#'}).text('Remove')
							.click(function(event) {
								event.preventDefault();
								$(this).parent().parent().next().remove();
								$(this).parent().parent().remove();
							})
						);
		$('.features:last').append(remove);
		$(header).insertAfter($('.features:last'));

		var container = $('<div></div>').attr({class: 'features'});
		$(container).insertAfter(header);
		showFeatureFields(categories[$('#categories').val()], true);
	})

	function resetPage()
	{
		$('.properties').addClass('hide');
		$('.properties').prev().addClass('hide');
		$('.features').not(':first').remove();
		$('.features').html('');
		$('.features').addClass('hide');
		$('.features').prev().addClass('hide');
		$('.button-div').addClass('hide');
		$('#reference_sku').val('');
		$('.add-feature-group').addClass('hide');
		$('hr').remove();
	}

	function saveProducts(product_names, index) {
		
		if(index === 0) {
			$('.growl').remove();
		}
		
		if(product_names.length == index) {
			$('.categories').addClass('hide');
			
			if(index != 1) {
				$('.feature').remove();
				$('hr').remove();
			}
			resetPage();
			return;
		}
		
		$('.button-div button').addClass('hide');
		$('.button-div img').removeClass('hide');

		var product_data = $("#product").serialize();

		$.ajax({
			type: "POST",
			url: "/api/products/save",
			dataType: "json",
			data: product_data+'&product=' + product_names[index].substring(0, product_names[index].length - 1),
			success: function(response) {
				$('.button-div button').removeClass('hide');
				$('.button-div img').addClass('hide');
				
				if(response.error) {
					showMessage(response.message, 'error');
					if(product_names.length == 1) {
						return;
					} 
				} else {
					var message = 'Product <b>' + response.product_name + '(' + 
									response.sku +')</b> created successfully. ' + 
									(product_names.length == 1 ? ('<a href="#"'  + 
										' class="create-similar">Create similar product</a>') : "");
					showMessage(message, 'notice');
					$('.empty-list').remove();
					$('#recent-products').prepend(
						$('<li></li>').append(
							$('<a></a>').attr({
								href: '#',
								'data-sku' : response.sku,
								'class': 'truncate'
							}).text(product_names[index] + '(' + response.sku + ')')
						).append(
							$('<span></span>').attr({
								'class': 'product-status not-processed'
							}).text('In Queue')
						).attr({
							title: 	product_names[index]
						}).addClass('recent-product')
					);
				}
				
				saveProducts(product_names, ++index);
			},
			error : function(xhr, status, error) {
				showMessage(error, 'error');
				$('.button-div button').removeClass('hide');
				$('.button-div img').addClass('hide');
				$("#categories").prop("disabled", false);
				$("#categories option").remove();
			}
		});
	}

	function showFeatureFields(category, only_features) {

		for(i = 0; i < category.features.length; i++) {
			
			if(category.features[i].status != 'A') {
				continue;
			}
			
			if(typeof only_features != 'undefined' && only_features) {
				if(category.features[i].parent_id != 0) {
					continue;
				}
			}
			var feature_id = category.features[i].feature_id;
			var feature_type = category.features[i].feature_type;
			var feature_desc = category.features[i].description;
			
			switch(feature_type) {
				case 'C':
					showFeaturesInput(feature_id, 'radio');
				break;

				case 'M':
					if(feature_desc.toLowerCase() == constant.TYPE_OF_ROLLING) {
						all_features[feature_id].feature_type = 'C';
						showFeaturesInput(feature_id, 'radio');
					} else if(feature_desc.toLowerCase() == constant.TYPE_OF_STEEL) {
						all_features[feature_id].feature_type = 'S';
						showFeaturesSelect(feature_id, 'text');
					} else {
						showFeaturesInput(feature_id, 'checkbox');
					}
				break;
				
				case 'S':
					//if(all_features[feature_id].variants_count > 10) {
						showFeaturesAutocomplete(feature_id);
					//} else {
					//	showFeaturesSelect(feature_id, 'text');
					//}
				break;

				case 'N':
					if(all_features[feature_id].variants_count > 10) {
						showFeaturesAutocomplete(feature_id);
					} else {
						showFeaturesSelect(feature_id, 'number');
					}
				break;

				case 'E':
					showFeaturesAutocomplete(feature_id);
				break;

				case 'T':
					showFeaturesTextBox(feature_id);
				break;

				case 'O':
					showFeaturesTextBox(feature_id, 'number');
				break;

				case 'D':
					showFeaturesTextBox(feature_id, 'date');
				break;
			}
		}
	}

	function showMessage(message, type, remove_last_message) {
		$.growl[type]({
			message: message, 
			size: 'large',
			duration: 10000
		});
	}

	dialog = $( "#dialog-form" ).dialog({
		autoOpen: false,
		modal: true,
		width: '350px',
		my: "center",
		at: "center",
		of: window,
		open: function( event, ui ) {
		  $("#dialog-form").closest("div[role='dialog']").css({top:100});              
		},
		
		buttons: {
			Add : addVariant,
			Cancel: function() {
				dialog.dialog( "close" );
			}
		},
		close: function() {
			form.find('input').val('');
		}
	});

	form = dialog.find( "form" ).on( "submit", function( event ) {
		event.preventDefault();
		addVariant();
	});

	$('.container').on("click", '.add-new', function(event) {
		event.preventDefault();
		var feature_id = $(this).attr('data-feature-id');
		index = $('span[data-feature-id="' + feature_id + '"]').index($(this));
		$('.ui-dialog-title').text("Add a new " + all_features[feature_id].description);
		$('#dialog-form').find('[name="new_variant"]').val('').focus();
		$('#dialog-form').find('[name="feature_type"]').val(all_features[feature_id].feature_type);
		$('#dialog-form').find('[name="feature_id"]').val(feature_id);
		$('.ui-dialog-buttonpane').removeClass('hide');
		$('[name="new_variant"]').removeClass('hide');
		$('.err').remove();
		dialog.dialog("open");
	})

	function addVariant() {
		var feature = all_features[$('#dialog-form').find('[name="feature_id"]').val()];
		var variants = feature.variants;
		var all_vars = new Array();
		var new_variant = $('#dialog-form').find('[name="new_variant"]').val();
		
		if($('#dialog-form').find('[name="new_variant"]').next()[0].tagName == 'DIV') {
			$('#dialog-form').find('[name="new_variant"]').next().remove();
		}

		if(new_variant.trim().length == 0) {
			$('<div class="err">' + msg.ENTER_VARIANT_NAME + '</div>')
			.insertAfter($('#dialog-form').find('[name="new_variant"]'));
			return;
		}

		if(feature.description.toLowerCase().indexOf('dimension') > -1 && 
			feature.description.toLowerCase() != constant.STD_DIMENSION) {
			
			var regExp = /\(([^)]+)\)/;
			var matches = regExp.exec(feature.description);
			matches[0] = matches[0].replace('(', '').replace(')', '')	
			
			//get no of fields for this dimension
			var field_count = matches[0].split('*').length;
			
			if(new_variant.split('*').length != field_count) {
				var message = '<div class="err">' + 'Please enter ' + feature.description + 
								' in ' + matches[0] + ' format.</div>';
				$(message).insertAfter($('#dialog-form').find('[name="new_variant"]'));
				return;
			}
			
			//no  of fields are correct now check field type
			var fields = new_variant.split('*');
			for(var i = 0; i < field_count; i++) {
				if(isNaN(parseFloat(fields[i])) || parseFloat(fields[i]) <= 0) {
					var message = '<div class="err">Please enter correct data for ' + 
									feature.description + ' in ' + matches[0] + ' format.</div>';
					$(message).insertAfter($('#dialog-form').find('[name="new_variant"]'));
					return;
				}
				
				fields[i] = parseFloat(fields[i].trim());
			}
			
			/*if((fields[0] > fields[1]) || (fields[1] > fields[2]) || (fields[0] > fields[2])) {
				var message = '<div class="err">Please enter correct data for ' + 
								feature.description + ' in ' + matches[0] + ' format.</div>';
				$(message).insertAfter($('#dialog-form').find('[name="new_variant"]'));
				return;
			}*/
			
			new_variant = fields.join('*');
			
		} else if(feature.feature_type == 'N' || 
					feature.description.toLowerCase() == 'thickness') {
			if(isNaN(parseFloat(new_variant)) || parseFloat(new_variant) <= 0) {
				var message = '<div class="err">' + msg.NUMERIC_VALUE + '</div>';
				$(message).insertAfter($('#dialog-form').find('[name="new_variant"]'));
				return;
			}
		}

		//check if variant name already exists
		for(id in variants) {
				
			if(new_variant.toLowerCase() == variants[id].variant.toLowerCase()) {

				var message = '<div class="err">' + msg.VARIANT_EXISTS + '</div>';
				$(message).insertAfter($('#dialog-form').find('[name="new_variant"]'));
				$('#dialog-form').find('[name="new_variant"]').val('').focus();
				return;
			}
		}
		
		$('.ui-dialog-buttonset button').attr({disabled: true});
		$('.ui-dialog-buttonset button:first span').text(msg.SAVING);
		$.ajax({
			type: "POST",
			url: "/api/features/save/variant",
			dataType: "json",
			data: $('#dialog-form').serialize(),
			success: function(response) {
				
				$('.ui-dialog-buttonset button').removeAttr('disabled');
				$('.ui-dialog-buttonset button:first span').text('Add');
				
				if(response.error) {
					showMessage(response.message, 'error');
					return;
				}
				
				$('.ui-dialog-buttonpane').addClass('hide');
				$('.ui-dialog-buttonpane').addClass('hide');
				$('[name="new_variant"]').addClass('hide');
				$('#feature_update').removeClass('hide');
				updateFeature(response.data.feature_id, new_variant);
			},
			error : function(xhr, status, error) {
				showMessage(error, 'error');
				$('.ui-dialog-buttonset button').removeAttr('disabled');
				$('.ui-dialog-buttonset button:first span').text('Add');
				$("#categories").prop("disabled", false);
				$("#categories option").remove();
			}
		});
	}

	function populateFeatures(product, id) {				
		if(all_features.length == 0 || categories.length == 0) {
			showMessage(msg.FEATURES_LOAD_ERROR, 'error');
			return;
		}
		$("#categories").val(product.main_category).change();
		var features = product.product_features;
		
		for(id in features) {
			
			var variants = features[id].variants;
			for(variant_id in variants) {
				if(features[id].feature_type == 'M') {
					if(features[id].description.toLowerCase() == constant.TYPE_OF_ROLLING) {
						$(selectFeatureRadio(id, variant_id)).prop('checked', true).click();
					} else if (features[id].description.toLowerCase() == constant.TYPE_OF_STEEL) {
						$(selectFeature(id)).val(variant_id).change();
					} else {
						$(selectFeatureCB(id, variant_id)).prop('checked', true);
					}
				} else if(features[id].feature_type == 'C') {
					$(selectFeatureCB(id, variant_id)).prop('checked', true);
				} else {
					$(selectFeature(id)).val(variant_id);
					if(features[id].feature_type == 'E' || all_features[id].variants_count > 10) {
						$(selectFeature(id)).prev().val(variants[variant_id].variant);
					}
				}
			}
		}
		
		var category_features = categories[product.main_category].features;
		for(id in category_features) {

			if(category_features[id].parent_id == 0) {
				continue;
			}
			
			var feature_id = category_features[id].feature_id;
			var variants = all_features[feature_id].variants;
			for(variant_id in variants) {

				if(variants[variant_id].variant.toLowerCase() == constant.PO_1 || 
					variants[variant_id].variant.toLowerCase() == constant.PO_2) {
					variants[variant_id].variant = constant.PO;
				}
				
				if(product.product.indexOf(' ' + variants[variant_id].variant + ' ') > -1 || 
					product.product.indexOf(variants[variant_id].variant + ' ') > -1) {
					if(category_features[id].description.toLowerCase() == constant.TYPE_OF_ROLLING) {
						$(selectFeatureCB(feature_id, variant_id)).prop('checked', true).click();
					} else if (category_features[id].description.toLowerCase() == constant.TYPE_OF_STEEL) {
						$(selectFeature(feature_id)).val(variant_id).change();
					} else {
						$(selectFeatureCB(feature_id, variant_id)).prop('checked', true);
					}
				}
			
				if(product.product.substring(0,3).toUpperCase() == constant.MS && 
					category_features[id].description.toLowerCase() == constant.TYPE_OF_STEEL) {
					$(selectFeature(feature_id)).val(MILD_STEEL); //mild steel
				} else if( product.product.substring(0,3).toUpperCase() == constant.SS && 
					category_features[id].description.toLowerCase() == constant.TYPE_OF_STEEL) {
					$(selectFeature(feature_id)).val(STAINLESS_STEEL); //stainless steel
				}
				
				if(variants[variant_id].variant == constant.PO) {
					variants[variant_id].variant = constant.PO_3;
				}

			}
		}
		
		if($('.properties div').length) {
			$('.properties').removeClass('hide');
		}
		
		if($('.features div').length) {
			$('.features').removeClass('hide');
		}
	}

	function showFeaturesInput(feature_id, input_type) {
		var element = $('<div></div>').attr({class: 'col-sm-offset-2 col-sm-3 feature'})
						.append(
							$('<div></div>')
							.attr({class: ''})
							.text(all_features[feature_id].description)
						)
						.append(
							$('<div></div>').attr({class: ''})
						);

		var variants = all_features[feature_id]['variants'];
		var variants_arr = new Array();

		for(id in variants) {
			variants_arr.push(variants[id]);
		}
		
		variants_arr.sort(function(lhs, rhs) {
			var lhs_value = lhs.variant.toUpperCase();
			var rhs_value = rhs.variant.toUpperCase();
			return (lhs_value < rhs_value) ? -1 : (lhs_value > rhs_value) ? 1 : 0;
		});

		var append_to = (all_features[feature_id].parent_id != 0 ? $('.properties') : $('.features:last'));
		$(append_to).append(element);

		var container = $(append_to).find(' .feature:last div:last');
		all_features[feature_id].container = container;

		for(index in variants_arr) {
			var name = 'product_features[' + feature_id + ']' + 
						(input_type == 'checkbox' ? '[' + variants_arr[index].variant_id + ']' : '');
			var element = $('<div></div>')
							.append(
								$('<input />').attr(
									{ 
										type: input_type, 
										value : variants_arr[index].variant_id, 
										name: name
									}
								)
							)
							.append(
								$('<label></label>').text(variants_arr[index].variant)
							);
			$(container).append(element);
		}
		
		if(all_features[feature_id].description.toLowerCase() == constant.TYPE_OF_ROLLING) {
			createHiddenInputForRadio(all_features[feature_id]);
		}
	}

	function createHiddenInputForRadio(feature) {
		$(feature.container).find('input[type="radio"]').click(function() {
			$(feature.container).find('input[type="hidden"]').remove();
			var selected = $(feature.container).find('input[type="radio"]:checked').val();
			var new_input = '<input type="hidden" value="' + selected + 
							'"  name="product_features[' + feature.feature_id + '][' + selected + ']"/>';
			$(feature.container).append(new_input);
		});
	}

	function showFeaturesAutocomplete(feature_id) {
		var element = $('<div></div>').attr({class: 'col-sm-offset-2 col-sm-3 feature'})
					.append(
						$('<div></div>')
						.attr({class: ''})
						.text(all_features[feature_id].description)
					)
					.append(
						$('<div></div>')
						.append(
							$('<input />').attr(
								{ 
									class: 'form-control required', 
									placeholder: constant.TYPE_SOMETHING,
									'data-feature-id' : feature_id
								}
							)
						)
						.append(
							$('<input />').attr(
								{ 
									type: 'hidden',
									name: 'product_features[' + feature_id + ']'
								}
							)
						).append(
							$('<span></span>').attr(
								{
									class: 'add-new glyphicon glyphicon-plus',
									'data-feature-id': feature_id,
									title: 'Add a new ' + all_features[feature_id].description 
								}
							)
						)
					);

		var append_to = (all_features[feature_id].parent_id != 0 ? $('.properties') : $('.features:last'));
		$(append_to).append(element);
		
		var element = append_to.find('.feature:last input')[0];
		var variants = new Array();
		
		for(id in all_features[feature_id]['variants']) {

			var description = all_features[feature_id]['variants'][id].description.replace(/\n/g, ''); 
			all_features[feature_id]['variants'][id].description = description;
			variants.push(
				{
					id : id,
					value : all_features[feature_id]['variants'][id].variant
				}
			);
		}
		all_features[feature_id].source = variants;

		if(all_features[feature_id].description.toLowerCase().indexOf('dimension') == -1 ||
			all_features[feature_id].description.toLowerCase() == constant.STD_DIMENSION) {

			all_features[feature_id].element =
			 $( element ).autocomplete({
				minLength: 0,
				source: function(request, response) {
					var source = all_features[feature_id].source;
					var result = $.map(source, function(option) {
						var item = jQuery.extend({}, option);
						var index = item.value.toLowerCase().indexOf(request.term.toLowerCase());
						if(index === 0) {
							item.original_value = item.value;
							var matched_str = item.value.substr(index, request.term.length);
							item.value = item.value.replace(matched_str, '<span class="bold">' + matched_str + '</span>');
							return item;
						}
					});

					//sort elements
					result.sort(function(lhs, rhs) {
						var lhs_value = lhs.value.toUpperCase();
						var rhs_value = rhs.value.toUpperCase();
						return (lhs_value < rhs_value) ? -1 : (lhs_value > rhs_value) ? 1 : 0;
					});

					response(result);
				},
				response: function(event, ui) {
					if(ui.content.length == 0) {
						ui.content[0] = {id: -1, value: constant.NO_RESULT};
					}  
				},
				select: function( event, ui ) {
					var feature_id = $(event.target).attr('data-feature-id');
					$(event.target).val(ui.item.original_value);
					$(append_to).find('[name="product_features[' + feature_id + ']"]').val(ui.item.id);
					return false;
				}
			}).focus(function() {
				$(this).autocomplete("search");
			}).blur(function(event) {
				if($(event.target).next().val() == '') {
					$(event.target).val('');
				}
			}).change(function(event) {
				$(event.target).next().val('');
			});
			
			all_features[feature_id].element
			.autocomplete( "instance" )._renderItem = function( ul, item ) {
				return $( '<li class="' + (item.id == -1 ? 'ui-state-disabled disabled-item' : '') + '">' )
				.append( "<a>" + item.value + "</a>" )
				.appendTo( ul );
			};
		} else { 
			
			all_features[feature_id].element =
			 $( element ).autocomplete({
				minLength: 0,
				response: function(event, ui) {
				},
				source: function(request, response) {
					var result = $.map(all_features[feature_id].source, function(item) {
						if(item.value.toLowerCase().indexOf(request.term.toLowerCase()) === 0 ||
							request.term.length == 0) {
							return item;
						}
					});

					if(result.length === 0) {
						result = [{id: -1, value: constant.NO_RESULT}];
					}
					response(result);
				},
				select: function( event, ui ) {
					var feature_id = $(event.target).attr('data-feature-id');
					$(event.target).val(ui.item.value);
					$(append_to).find('[name="product_features[' + feature_id + ']"]').val(ui.item.id);
					return false;
				},
			}).focus(function() {
				$(this).autocomplete("search");
			}).blur(function(event) {
				if($(event.target).next().val() == '') {
					$(event.target).val('');
				}
			}).change(function(event) {
				$(event.target).next().val('');
			});
			all_features[feature_id].element
			.autocomplete( "instance" )._renderItem = function( ul, item ) {
				return $( '<li class="' + (item.id == -1 ? 'ui-state-disabled disabled-item' : '') + '">' )
				.append( "<a>" + item.value + "</a>" )
				.appendTo( ul );
			};
		}
	}

	function showFeaturesSelect(feature_id, feature_type) {

		var element = $('<div></div>').attr({class: 'col-sm-offset-2 col-sm-3 feature'})
			.append(
				$('<div></div>')
				.text(all_features[feature_id].description)
			)
			.append(
				$('<div></div>')
				.append(
					$('<select></select>')
					.attr(
						{
							class: 'form-control  required', 
							name: 'product_features[' + feature_id + ']'
						}
					)
				).append(
					$('<span></span>').attr(
						{
							class: 'add-new glyphicon glyphicon-plus',
							'data-feature-id': feature_id,
							title: 'Add a new ' + all_features[feature_id].description 
						}
					)
				)
			);

		var variants = all_features[feature_id]['variants'];

		var append_to = (all_features[feature_id].parent_id != 0 ? $('.properties') : $('.features:last'));
		$(append_to).append(element);
		
		var select = $(append_to).find(' .feature:last select');
		all_features[feature_id].container = select;
		$(select).append('<option value="">Select a value for ' + all_features[feature_id].description + '</option>');
		
		var variants_arr = new Array();
		for(id in variants) {
			variants_arr.push(variants[id]);
		}
		
		variants_arr.sort(function(lhs, rhs) {
			var lhs_value = lhs.variant.toUpperCase();
			var rhs_value = rhs.variant.toUpperCase();
			return (lhs_value < rhs_value) ? -1 : (lhs_value > rhs_value) ? 1 : 0;
		});

		for(index in variants_arr) {
			$(select).append('<option value="' + variants_arr[index].variant_id + '">' + variants_arr[index].variant + '</option>');
		}
		
		if(all_features[feature_id].description.toLowerCase() == constant.TYPE_OF_STEEL) {
			$(element).find('.add-new').remove();
			createHiddenInputForSelect(all_features[feature_id]);
		}
	}

	function createHiddenInputForSelect(feature) {
		$(feature.container).change(function() {

			$(feature.container).parent().find('input[type="hidden"]').remove();
			var selected = $(feature.container).val();
			var new_input = '<input type="hidden" value="' + selected + 
							'"  name="product_features[' + feature.feature_id + '][' + selected + ']"/>';
			$(feature.container).parent().append(new_input);
		});
	}

	function showFeaturesTextBox(feature_id) {
		var element = $('<div></div>').attr({class: 'col-sm-offset-2 col-sm-3 feature'})
			.append(
				$('<div></div>')
				.text(all_features[feature_id].description)
			)
			.append(
				$('<div></div>')
				.append(
					$('<select></select>')
					.attr(
						{
							class: 'form-control required', 
							name: 'product_features[' + feature_id + ']'
						}
					)
				)
			);

		var append_to = (all_features[feature_id].parent_id != 0 ? $('.properties') : $('.features:last'));
		$(append_to).append(element);

		var container = $('.features .feature:last div:last');
		$(container).append(
			$('<input/>').attr(
				{
					type: 'text', 
					name : 'product_features[' + feature_id + ']'
				}
			)
		);
	}

	function handleCategories(response) {
		
		$("#categories").prop("disabled", false);
		$("#categories option").remove();
		
		if(response.error) {
			showMessage(response.message, 'error');
		} else {
			if($.isArray(response.data)) {
				for(var i = 0; i < response.data.length; i++) {
					categories[response.data[i].category_id] = response.data[i];
					if(response.data[i].parent_id != 0) {
						if(!(response.data[i].parent_id in category_tree)) {
							category_tree[response.data[i].parent_id] = new Array();
						}
						category_tree[response.data[i].parent_id].push(response.data[i].category_id);
					}
				}
			} else {
				categories[0] = response.data;
			}
		}
		
		//remove all category with child or children
		for(id in category_tree) {
			if(!(id in categories)) {
				continue;
			}
			
			if(category_tree[id].length ) {
				categories[id].skip = true;
			} else {
				categories[id].skip = false;
			}
		}
	}

	function getFeatures() {
		$.ajax({
			type: "GET",
			url: "/api/features",
			dataType: "json",
			success: function(response) {
				if(response.error) {
					showMessage(response.message, 'error');
					return;
				}
				
				handleFeatures(response.data);
				getFeatureVariants();
			},
			error : function(xhr, status, error) {
				showMessage(error, 'error');
				$("#categories").prop("disabled", false);
				$("#categories option").remove();
			}
		});
	}

	function updateFeature(feature_id, new_variant) {
		$.ajax({
			type: "GET",
			url: "/api/features/" + feature_id + '/' + 1,
			dataType: "json",
			success: function(response) {
				all_features[response.data.feature_id].variants = response.data.variants;
				showMessage('Variant added successfully.', 'notice');
				
				var feature = all_features[feature_id];
				var selected_var = {value: new_variant};
				for(id in feature.variants) {
					if(feature.variants[id].variant == new_variant) {
						selected_var.id = id;
						feature.source.push(
							{
								id : id,
								value : feature.variants[id].variant,
								original_value : feature.variants[id].variant
							}
						);
					}
					
				}
				
				//$(feature.element).data('ui-autocomplete')._trigger('select', 'autocompleteselect', {item:selected_var});
				var input = $('.features:eq(' + index + ')').find('input[data-feature-id="' + feature_id + '"]');
				$(input).autocomplete("option", {
					source: function(request, response) {
						var source = all_features[feature_id].source;
						var result = $.map(source, function(option) {
							var item = jQuery.extend({}, option);
							var index = item.value.toLowerCase().indexOf(request.term.toLowerCase());


							if(all_features[feature_id].description.toLowerCase().indexOf('dimension') == -1 ||
								all_features[feature_id].description.toLowerCase() == constant.STD_DIMENSION) {
								if(index >= 0) {
									item.original_value = item.value;
									var matched_str = item.value.substr(index, request.term.length);
									item.value = item.value.replace(matched_str, '<span class="bold">' + matched_str + '</span>');
									return item;
								}
							} else {
								if(index == 0) {
									item.original_value = item.value;
									return item;
								}
							}
						});

						//sort elements
						result.sort(function(lhs, rhs) {
							var lhs_value = lhs.value.toUpperCase();
							var rhs_value = rhs.value.toUpperCase();
							return (lhs_value < rhs_value) ? -1 : (lhs_value > rhs_value) ? 1 : 0;
						});

						response(result);
					},
				});
				$(input).val(selected_var.value);
				$(input).next().val(selected_var.id);
				$(input).next().val(selected_var.id);
				$('#feature_update').addClass('hide');
				dialog.dialog('close');
			},
			error : function(xhr, status, error) {
				showMessage(error, 'error');
				$("#categories").prop("disabled", false);
				$("#categories option").remove();
				$('#feature_update').addClass('hide');
				dialog.dialog('close');
			}
		});
	}

	function handleFeatures(features) {
		for(i = 0; i < features.length; i++) {
			features[i].categories_path = features[i].categories_path.split(',');
			all_features[features[i].feature_id] = features[i];

			for(var j = 0; j < features[i].categories_path.length; j++) {
				if(features[i].categories_path[j] in categories) {
					if('features' in categories[features[i].categories_path[j]]) {
						categories[features[i].categories_path[j]]['features'].push(features[i]);
					} else {
						categories[features[i].categories_path[j]]['features'] = new Array();
						categories[features[i].categories_path[j]]['features'].push(features[i]);
					}
				}
			}
		}
		renderCategories();
	}

	function renderCategories()
	{
		$("#categories").hide()
		var option = $('<option></option>')
					.attr({value: ''})
					.text(constant.SELECT_CATEGORY);
		$("#categories").append(option);
		
		for(id in categories) {
			if(!(categories[id].parent_id == 5992 || 
				$.inArray(categories[id].parent_id, category_tree[5992]) >= 0)) {
				categories[id].skip = true;
			}
			
			if(categories[id].skip) {
				continue;
			}
			var parent_name = (categories[id].parent_id != 0 ? ' (' + categories[categories[id].parent_id].category +')' : '');
			var option = $('<option></option>')
						.attr({value: id})
						.text(categories[id].category + parent_name);
			$("#categories").append(option);
			category_list.push(
				{
					'id': id, 
					name: categories[id].category + parent_name
				}
			);
		}
		
		var cat_search = $('<input />').attr(
			{
				class: 'form-control',
				placeholder : constant.SEARCH_CATEGORY,
				id: 'category_search'
			}
		);
		$(cat_search).insertAfter($('#categories'));
		category_autocomplete(cat_search);
	}

	function dimensionSource(request, response) {
		var result = $.map(category_list, function(item) {
			if(item.name.indexOf(request.term) > -1) {
				return item;
			}
		});

		if(result.length === 0) {
			result = [{id: -1, value: constant.NO_RESULT}];
		}
		response(result);
	}

	function category_autocomplete(element) {
		 $( element ).autocomplete({
			minLength: 0,
			source: function(request, response) {
				var result = $.map(category_list, function(item) {
					if(item.name.toLowerCase().indexOf(request.term.toLowerCase()) > -1) {
						return item;
					}				
				});
				result.sort(function(lhs, rhs) {
					var lhs_value = lhs.name.toUpperCase();
					var rhs_value = rhs.name.toUpperCase();
					return (lhs_value < rhs_value) ? -1 : (lhs_value > rhs_value) ? 1 : 0;
				});
				
				if(result.length === 0) {
					result = [{id: -1, name: constant.NO_RESULT}];
				}
				response(result);
			},
			response: function(event, ui) {
				if(ui.content.length == 0) {
					$(event.target).val('');
					showMessage(msg.NO_CATEGORIES, 'error');
				}  
			},
			focus: function( event, ui ) {
				$(element).val(ui.item.name);
				$( "#categories" ).val( ui.item.id );
				return false;
			},
			select: function( event, ui ) {
				$(element).val(ui.item.name);
				$( "#categories" ).val( ui.item.id ).change();
				return false;
			},
		})
		.autocomplete( "instance" )._renderItem = function( ul, item ) {
			return $( '<li class="' + (item.id == -1 ? 'ui-state-disabled disabled-item' : '') + '">' )
				.append( "<a>" + item.name + "</a>" )
				.appendTo( ul );
		};
	}
	var feature_ids = new Array();
	
	function getFeatureVariants(index) {
		
		if(feature_ids.length == 0) {
			for(id in all_features) {
				feature_ids.push(id);
			}
		}
		
		if(typeof index == 'undefined') {
			index = 0;
		}

		$.ajax({
			type: "GET",
			url: "/api/features/" + feature_ids[index] + '?index=' + index,
			dataType: "json",
			success: function(response) {
				all_features[response.data.feature_id] = response.data;
				if(response.next_index < feature_ids.length) {
					getFeatureVariants(response.next_index);
				}
			},
			error : function(xhr, status, error) {
				showMessage(error, 'error');
				$("#categories").prop("disabled", false);
				$("#categories option").remove();
			}
		});
	}

	$('body').on('click', '.create-similar', function() {
		$('.growl').remove();
		$('#recent-products').find('li:first a').click();
	});
})();
