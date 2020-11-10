<?php
// use App\Models\Armor;
// use App\Models\Charge;
// use App\Models\General;
// use App\Models\Gold;
// use App\Models\Housing;
// use App\Models\Ride;
// use App\Models\System;
// use App\Models\Weapon;
use App\Models\Item;
use App\Models\Category;





$router->group(['prefix' => 'api/'], function () use ($router) {
	$router->get('collection/types', 'CollectionController@index');
	$router->get('items', 'ItemController@list');
	$router->get('item/{main}/{type}', 'ItemController@items');
	$router->get('item/{main}/{type}/{page}', 'ItemController@paginate');
	$router->get('search/item/{keyword}', 'ItemController@search');

	$router->post('create/item', 'ItemController@store');
	$router->put('item/edit/{id}', 'ItemController@update');
	$router->get('show/item/{id}', 'ItemController@show');

	$router->post('register', 'AuthController@register');
	$router->post('login', 'AuthController@login');

	$router->get('category', 'CategoryController@categories');
	$router->get('category/{id}', 'CategoryController@show');
	$router->post('category/create', 'CategoryController@store');
	$router->put('category/edit/{id}', 'CategoryController@update');


	$router->get('sub-categories', 'SubCategoryController@subCategories');
	$router->post('sub-category/create', 'SubCategoryController@store');
	$router->put('sub-category/edit/{id}', 'SubCategoryController@update');

	// $router->group(['prefix' => 'equipments', 'namespace' => 'Equipments'], function () use ($router) {
	// 	$router->get('/armors', 'ArmorController@index');
	// 	$router->get('/armors/kinds/list', 'ArmorController@kinds');
	// 	$router->get('/armors/part/{type}', 'ArmorController@show');
	// });

	// $router->get('/charge', 'ChargeController@index');
	// $router->get('/charge/kinds/list', 'ChargeController@kinds');
	// $router->get('/charge/{charge_type}', 'ChargeController@show');

});


$router->get('/', function () {
});
