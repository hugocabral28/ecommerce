<?php
use \Hcode\Page;
use \Hcode\Model\Product;


$app->get('/', function() {
	$products = Product::listAll();

	$Page = new Page();

	$Page->setTpl("index",[
		'product'=>Product::checkList($products)
	]);

});

$app->get("/categories/:idcategory", function($idcategory){

	$category = new Category();
	$category->get((int)$idcategory);

	$Page = new Page();
	$Page->setTpl("category",[
		'category'=>$category->getValues(),
		'products'=>[]
	]);
});

?>