<?php






$router->group(['prefix' => 'api/'], function () use ($router) {

	$router->post('register', 'AuthController@register');
	$router->post('login', 'AuthController@login');
	$router->post('logout', 'AuthController@logout');



	$router->group(['prefix' => 'user', 'namespace' => 'User'], function () use ($router) {

		$router->get('category', 'CategoryController@categories');
		$router->get('category/article/{id}', 'CategoryController@showArticle');
		$router->get('category/{name}[/{page}]', 'CategoryController@show');
		$router->get('category/{category}/items[/{page}]', 'CategoryController@categoriesWithItems');
		$router->get('search/item/{keyword}', 'ItemController@search');

		$router->get('sub-category/{id}', 'SubCategoryController@show');


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
			$router->get('category/edit/{id}', 'CategoryController@edit');
			$router->put('category/edit/{id}', 'CategoryController@update');


			$router->get('sub-categories', 'SubCategoryController@subCategories');
			$router->get('sub-category/{id}', 'SubCategoryController@edit');
			$router->post('sub-category/create', 'SubCategoryController@store');
			$router->put('sub-category/edit/{id}', 'SubCategoryController@update');
			// article type edit for sub-category
			$router->put('sub-category/article/edit/{id}', 'SubCategoryController@updateArticle');


			$router->post('create/item', 'ItemController@store');
			$router->post('item/edit/{id}', 'ItemController@update');
			$router->get('item/count', 'ItemController@noOfItems');

			$router->get('set/item/list/{page}', 'ItemController@listForSet');
			$router->get('set/item/list/search/{key}[/{pageIndex}]', 'ItemController@searchItemForSetList');
			$router->get('sets/{page}[/{by}]', 'SetController@list');
			$router->get('set/{id}', 'SetController@show');
			$router->post('sets/create', 'SetController@linkToItem');
			$router->put('set/edit/{id}', 'SetController@update');
			$router->get('set/search/{key}[/{pageIndex}]', 'SetController@searchSet');
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
