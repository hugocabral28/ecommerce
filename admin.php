<?php
use \Hcode\PageAdmin;
use \Hcode\Model\User;


$app->get('/admin', function() {
	User::verifyLogin();

	$Page = new PageAdmin();
	$Page->setTpl("index");
});

$app->get('/admin/login', function() {
	$Page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$Page->setTpl("login");
});

$app->post('/admin/login', function(){
	User::login($_POST["login"],$_POST["password"]);
	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function(){
	User::logout();
	header("Location: /admin/login");
	exit;
});
$app->get("/admin/forgot", function(){
	$Page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$Page->setTpl("forgot");
});

$app->post("/admin/forgot", function(){

	$user = User::getForgot($_POST["email"]);

	header("Location /admin/forgot/sent");
	exit;
});

$app->get("/admin/forgot/sent", function(){
	$Page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$Page->setTpl("forgot-sent");
});



?>