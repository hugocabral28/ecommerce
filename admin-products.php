<?php
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Product;


$app->get("/admin/products", function()
{

	User::verifyLogin();

	$products = Product::listAll();

	$Page = new PageAdmin();

	$Page->setTpl("products",[
		"products"=>$products
	]);

});

$app->get("/admin/products/create", function()
{
	User::verifyLogin();

	$Page = new PageAdmin();

	$Page->setTpl("products-create");

});

$app->post("/admin/products/create", function()
{
	User::verifyLogin();

	$product = new Product();

	$product->setData($_POST);

	$product->save();

	header("Location: /admin/products");
	exit;

});

$app->get("/admin/products/:idproduct", function($idproduct)
{
	User::verifyLogin();

	$product = new Product();

	$product->get((int)$idproduct);

	$Page = new PageAdmin();

	$Page->setTpl("products-update",[
		'product'=>$product->getValues()
	]);

});

$app->post("/admin/products/:idproduct", function($idproduct)
{
	User::verifyLogin();

	$product = new Product();
	$product->get((int)$idproduct);
	$product->setData($_POST);
	$product->save();
	$product->setPhoto($_FILES["file"]);
	header("Location: /admin/products");
	exit;
});

$app->get("/admin/products/:idproduct/delete", function($idproduct)
{
	User::verifyLogin();

	$product = new Product();

	$product->get((int)$idproduct);

	$product->delete();

	header("Location: /admin/products");
	exit;
});

?>