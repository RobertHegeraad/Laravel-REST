<?php

class ProductsController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Resourceful Controller
	|--------------------------------------------------------------------------
	|
	|	Verb 		Path 						Action 		Route Name
	|	------------------------------------------------------------------
	|	GET 		/resource 					index 		resource.index
	|	GET 		/resource/create 			create 		resource.create
	|	POST 		/resource 					store 		resource.store
	|	GET 		/resource/{resource} 		show 		resource.show
	|	GET 		/resource/{resource}/edit 	edit 		resource.edit
	|	PUT/PATCH 	/resource/{resource} 		update 		resource.update
	|	DELETE 		/resource/{resource} 		destroy 	resource.destroy
	|
	| http://laravel.com/docs/controllers#resource-controllers
	|
	*/

	/**
	 * GET
	 */
	public function index()
	{
		return Response::json(array(
	        'products' => array(
	        	array('id' => 1, 'name' => 'Product 1'),
	        	array('id' => 2, 'name' => 'Product 2'),
	        	array('id' => 3, 'name' => 'Product 3')
	        )), 200);
	}

	/**
	 * POST
	 */
	public function store()
	{
		$data = Input::all();

		// Save data in the database

		return Response::json(array(), 200);
	}

	/**
	 * PUT
	 */
	public function update($id)
	{
		$data = Input::all();

		// Update fields in the database

		return Response::json(array(), 200);
	}

	/**
	 * DELETE
	 */
	public function destroy($id)
	{
		// Remove record from the database

		return Response::json(array(), 200);
	}
}