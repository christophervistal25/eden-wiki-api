<?php





$router->group(['prefix' => 'api/'], function () use ($router) {

	$router->post('register', 'AuthController@register');
	$router->post('login', 'AuthController@login');
	$router->post('logout', 'AuthController@logout');



	$router->group(['prefix' => 'user', 'namespace' => 'User'], function () use ($router) {
		$router->get('category', 'CategoryController@categories');
		$router->get('category/{name}[/{page}]', 'CategoryController@show');
		$router->get('category/{category}/items[/{page}]', 'CategoryController@categoriesWithItems');
		$router->get('search/item/{keyword}', 'ItemController@search');


		$router->get('item/{main}/{type}', 'ItemController@items');
		$router->get('item/{main}/{type}/{page}', 'ItemController@paginate');
	});



	$router->group(
		['middleware' => 'jwt', 'prefix' => 'admin', 'namespace' => 'Admin'],
		function () use ($router) {
			$router->get('items/{page}[/{by}]', 'ItemController@list');
			$router->get('search/item/name/{name}', 'ItemController@search');

			$router->get('category', 'CategoryController@categories');
			$router->get('category/sub', 'CategoryController@categoriesWithSub');

			$router->post('category/create', 'CategoryController@store');
			$router->put('category/edit/{id}', 'CategoryController@update');

			$router->get('sub-categories', 'SubCategoryController@subCategories');
			$router->post('sub-category/create', 'SubCategoryController@store');
			$router->put('sub-category/edit/{id}', 'SubCategoryController@update');

			$router->post('create/item', 'ItemController@store');
			$router->put('item/edit/{id}', 'ItemController@update');
			$router->get('item/count', 'ItemController@noOfItems');
		}
	);








	// $router->group(['prefix' => 'equipments', 'namespace' => 'Equipments'], function () use ($router) {
	// 	$router->get('/armors', 'ArmorController@index');
	// 	$router->get('/armors/kinds/list', 'ArmorController@kinds');
	// 	$router->get('/armors/part/{type}', 'ArmorController@show');
	// });

	// $router->get('/charge', 'ChargeController@index');
	// $router->get('/charge/kinds/list', 'ChargeController@kinds');
	// $router->get('/charge/{charge_type}', 'ChargeController@show');
	$router->post('token/refresh', 'AuthController@refresh');
	$router->get('me', 'AuthController@profile');
});



$router->get('/', function () {
	$path =  rtrim(app()->basePath('public/all.json'), '/');
	$json = file_get_contents($path);
	$jsonIterator = new RecursiveIteratorIterator(
		new RecursiveArrayIterator(json_decode($json, TRUE)),
		RecursiveIteratorIterator::SELF_FIRST
	);
	$data = [];
	foreach ($jsonIterator as $key => $val) {
		if (!is_array($val)) {
			if ($key == 'szName') {
				$data['name'][] = $val;
			} else if ($key == 'szComment') {
				$data['description'][] = $val;
			} else if ($key == 'dwItemSex') {
				$data['gender'][] = $val;
			} else if ($key == 'dwLimitLevel1') {
				$data['level'][] = $val;
			} else if ($key == 'dwItemKind1') {
				$data['item_kind'][] = $val;
			} else if ($key == 'dwItemJob') {
				$data['job'][] = $val;
			} else if ($key == 'szIcon') {
				$data['icon'][] = $val;
			} else if ($key == 'dwAbilityMin') {
				$data['ability_min'][] = $val;
			} else if ($key == 'dwAbilityMax') {
				$data['ability_max'][] = $val;
			} else if ($key == 'dwDestParam1') {
				$data['effect_1_description'][] = $val;
			} else if ($key == 'dwDestParam2') {
				$data['effect_2_description'][] = $val;
			} else if ($key == 'dwDestParam3') {
				$data['effect_3_description'][] = $val;
			} else if ($key == 'nAdjParamVal1') {
				$data['effect_1'][] = $val;
			} else if ($key == 'nAdjParamVal2') {
				$data['effect_2'][] = $val;
			} else if ($key == 'nAdjParamVal3') {
				$data['effect_3'][] = $val;
			}
		}
	}
	echo "<pre>";
	dd(array_unique($data['item_kind']));
	echo "</pre>";
});
