<?php

return [

	'api' => [
		'url' => [
			'products'            => '/api/products/',
			'features'            => '/api/features/',
			'categories'          => '/api/categories/',
			'product_features'    => '/api/products/:pid:/features',
			'categories_products' => '/api/categories/:cid:/products/',
		],
		'production' => [
			'auth' => 'abani.meher@power2sme.com:0t4901b48ajxKMX9UzleXr3hzj3aP4D8',
			'hostname' => 'http://bazaar.power2sme.com',
        ],
		'staging' => [
			'auth' => 'abani.meher@power2sme.com:0t4901b48ajxKMX9UzleXr3hzj3aP4D8',
			'hostname' => 'http://uat-services.power2sme.com',
        ],
		'local' => [
			'auth' => 'nasirj@power2sme.com:MqW3TI8J281Dw34j03S4T77aHG6mq71P',
			'hostname' => 'http://rmbazaar.com',
        ],
	],
			
	'property' => [
		'production' => [
			'TYPE_OF_STEEL' => '54',
			'TYPE_OF_ROLLING' => '55',
			'OTHER_PROPERTIES' => '53',
			'MILD_STEEL' => '1483',
			'STAINLESS_STEEL' => '1484'
		],
		'staging' => [
			'TYPE_OF_STEEL' => '54',
			'TYPE_OF_ROLLING' => '55',
			'OTHER_PROPERTIES' => '53',
			'MILD_STEEL' => '1483',
			'STAINLESS_STEEL' => '1484'
		],
		'local' => [
			'TYPE_OF_STEEL' => '54',
			'TYPE_OF_ROLLING' => '55',
			'OTHER_PROPERTIES' => '53',
			'MILD_STEEL' => '1483',
			'STAINLESS_STEEL' => '1484'
		],
	],
	'vtiger_url' => [
		'production' => 'http://103.25.172.110:8080/p2sapi/ws/v3/userlogin/',
		'staging' => 'http://uat.power2sme.com/p2sapi/ws/v3/userlogin',
		'local' => 'http://uat.power2sme.com/p2sapi/ws/v3/userlogin',
	],
	'call_external_api' => false
];
