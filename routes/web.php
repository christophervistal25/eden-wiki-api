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




$router->group(['prefix' => 'api/'], function () use($router) {
	$router->get('collection/types', 'CollectionController@index');
	$router->get('/item/{main}/{type}', 'ItemController@show');

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

