<?php
use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;


$app->get('/', function() {

	$products = Product::listAll();

	$Page = new Page();

	$Page->setTpl("index",[
		'products'=>Product::checkList($products)
	]);

});

$app->get("/categories/:idcategory", function($idcategory){

	$category = new Category();
	$category->get((int)$idcategory);

	$Page = new Page();
	$Page->setTpl("category",[
		'category'=>$category->getValues(),
		'products'=>Product::checkList($category->getProducts())
	]);
});

?>