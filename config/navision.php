<?php

return [
	'api' => [
		'url' => [
			'reload' => '/p2sapi/ws/v3/skuList?r=true',
			'create_sku' => '/p2sapi/ws/v3/createNavSku?sku=',
		],
		'production' => [
			'auth' => 'admin:admin',
			'hostname' => 'http://103.25.172.167:7979',
        ],
		'staging' => [
			'auth' => 'admin:admin',
			'hostname' => 'http://uat.power2sme.com',
        ],
		'local' => [
			'auth' => 'admin:admin',
			'hostname' => 'http://uat.power2sme.com',
        ],
	],
];
