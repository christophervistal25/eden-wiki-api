<?php





$router->group(['prefix' => 'api/'], function () use ($router) {

	$router->post('register', 'AuthController@register');
	$router->post('login', 'AuthController@login');
	$router->post('logout', 'AuthController@logout');



	$router->group(['prefix' => 'user', 'namespace' => 'User'], function () use ($router) {
		$router->get('category', 'CategoryController@categories');
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
});
