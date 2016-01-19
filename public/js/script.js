function Message() {
	this.VARIANT_EXISTS = 'Variant exists for this feature.  Please enter a different variant.';
	this.SAVING = 'Saving...';
	this.FEATURES_LOAD_ERROR = 'Unable to load features.';
	this.NO_CATEGORIES = 'No categories found matching search term';
	this.NUMERIC_VALUE = 'Please enter a numeric value.';
	this.EMPTY_FIELD = 'Please enter a value for this field.';
	this.NO_FEATURES_IN_CATEGORY = 'No features in this category';
	this.ENTER_VARIANT_NAME = 'Enter a variant name.';
	this.CATEGORY_INFO_FETCH_ERRO = 'Category information not found.'
	return this;
}

function Constant() {
	this.TYPE_OF_ROLLING = 'type of rolling';
	this.TYPE_OF_STEEL = 'type of steel';
	this.PO_1 = 'pickled & oiled';
	this.PO_2 = 'pickled and oiled';
	this.PO_3 = 'Pickled & Oiled';
	this.PO = 'PO';
	this.SS = 'SS ';
	this.MS = 'MS ';
	this.TYPE_SOMETHING = 'Type something to search...';
	this.STD_DIMENSION = 'standard dimension';
	this.NO_RESULT = 'No result found.';
	this.SELECT_CATEGORY = 'Select a category';
	this.SEARCH_CATEGORY = 'Type to search a category';
	return this;
}
var msg = new Message();
var constant = new Constant();

function selectFeatureRadio(feature_id, variant_id) {
	return '[name="product_features[' +  feature_id + ']"][value="' + variant_id + '"]';
}

function selectFeatureCB(feature_id, variant_id) {
	return '[name="product_features[' +  feature_id + '][' + variant_id + ']"][value="' + variant_id + '"]';
}
function selectFeature(feature_id) {
	return '[name="product_features[' + feature_id + ']"]';
}

$(function() {
	$('*').tooltip();
});

$.ajaxSetup({
	beforeSend: function() {
		if(this.url.substring(0,1) == '/') {
			this.url = BASE_URL + this.url;
		}
	}
});

function ajax(type, url, dataType, success, error, data) {
	$.ajax({
		type: type,
		url: url,
		dataType: dataType,
		data: data,
		success: success,
		error : error
	});
}

function ajaxGet(url, callback) {
	ajax('GET', url, 'json', callback.success, callback.error);
}

function ajaxPost(url, callback, data) {
	ajax('POST', url, 'json', callback.success, callback.error, data);
}


$(document).ready(function() {
	getNotifications();
	$('[href="' + document.location.pathname + '"]').parent().addClass('active');;
});

function getNotifications() {
	$.ajax({
		type: 'GET',
		url: '/notifications',
		dataType: 'json',
		success: function(response) {
			
			if(response.count == 0) {
				if ($('.badge.badge-notify').text() == 0) {
					$('.badge.badge-notify').remove();
				}
				
			} else {
				if($('.badge.badge-notify').length) {
					
					$('.badge.badge-notify').text(response.count + parseInt($('.badge.badge-notify').text()));
				} else {
					$('<span></span>')
					.attr({ class: 'badge badge-notify' })
					.text(response.count)
					.insertAfter($('.dropdown-menu'));
				}
				
				//update product status
				for(var i = 0; i < response.notification.length; i++) {
					var css_class = 'product-status';
					if (response.notification[i].pushed_to_navision == 0) {
						css_class += ' not-processed';
						var text = 'In Queue';
					} else if (response.notification[i].pushed_to_navision == 1) {
						css_class += ' processing';
						var text = 'Processing';
					} else {
						css_class += ' processed';
						var text = 'Processed';
					}
					$('[data-sku="' + response.notification[i].sku + '"]')
					.next()
					.attr({'class': css_class})
					.text(text);
				}
			}
			setTimeout(getNotifications, 60000);
		},
		error : function() {
			setTimeout(getNotifications, 60000);
		}
	});
}


function validateRequiredFields(required_fields) {
	for(var i = 0; i <  required_fields.length; i++) {
		if($(required_fields[i]).val().trim().length == 0) {
			//$(required_fields[i]).addClass('error').attr({title: 'Please enter a value for this field.'});
		}
	}
}

function source(name) {
	this.reference_sku = function(request, response) {
		$(".ui-autocomplete").hide();
		
		$.ajax({
			url: "/api/products/",
			dataType: "json",
			data: "q=" + request.term,
			success: function(result) {
				$('#reference_sku').removeClass('ui-autocomplete-loading');
				var products = new Array();
				
				//in case of error show error message.
				if(result.error) {
					showMessage(result.message, 'error');
					return;
				}
				
				if(result.data.products.length) {
					products = $.map(result.data.products, function(item) {
						if(item.status == 'A') {
							return {
								name: item.product,
								sku: item.product_code,
								product: item
							};
						}
					});
				}
				
				if(products.length  == 0) {
					products = [{id: -1, value: 'No results found.'}];
				}
				response(products);
			},
			error : function(xhr, status, error) {
				showMessage(status, 'error');
				$('#message').html('<label class="error">' + status + ' : ' + error + '</label>');
			}
		});
	};
	
	return this[name];
}
