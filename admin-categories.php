<?php 
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;


$app->get("/admin/categories", function(){
	User::verifyLogin();
	$categories = Category::listAll();
	$Page = new PageAdmin();
		$Page->setTpl("categories",[
			'categories'=>$categories
		]);
});

$app->get("/admin/categories/create", function(){
		User::verifyLogin();
		$Page = new PageAdmin();
		$Page->setTpl("categories-create");
});

$app->post("/admin/categories/create", function(){
		User::verifyLogin();
		$category = new Category();
		$category->setData($_POST);
		$category->save();
		header("Location: /admin/categories");
		exit;
});

$app->get("/admin/categories/:idcategory/delete", function($idcategory){
	User::verifyLogin();
	$category = new Category();
	$category->get((int)$idcategory);
	$category->delete();
	header("Location: /admin/categories");
	exit;
});
$app->get("/admin/categories/:idcategory", function($idcategory){
	User::verifyLogin();
	$category = new Category();
	$category->get((int)$idcategory);
	$Page = new PageAdmin();
	$Page->setTpl("categories-update",[
		'category'=>$category->getValues()
	]);
});
$app->post("/admin/categories/:idcategory", function($idcategory){
	User::verifyLogin();
	$category = new Category();
	$category->get((int)$idcategory);
	$category->setData($_POST);
	$category->save();
	header("Location: /admin/categories");
	exit;
});

$app->get("/admin/categories/:idcategory/products",function($idcategory){
	
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$Page = new PageAdmin();

	$Page->setTpl("categories-products",[
		'category'=>$category->getValues(),
		'productsRelated'=>$category->getProducts(),
		'productsNotRelated'=>$category->getProducts(false)
	]);

});


?>