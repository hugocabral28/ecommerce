<?php
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {

	$Page = new Page();
	$Page->setTpl("index");
});

$app->config('debug', true);

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

$app->get("/admin/users", function(){
	User::verifyLogin();

	$users = User::listAll();

	$Page = new PageAdmin();
	$Page->setTpl("users", array(
		"users"=>$users
	));
});

$app->get("/admin/users/create", function(){
	User::verifyLogin();
	$Page = new PageAdmin();
	$Page->setTpl("users-create");
});

$app->get("/admin/users/:iduser/delete", function($iduser){
	User::verifyLogin();
	$user = new User();
	$user->get((int)$iduser);
	$user->delete();
	header("Location: /admin/users");
	exit;
});

$app->get("/admin/users/:iduser", function($iduser){
	User::verifyLogin();
	$user = new User();
	$user->get((int)$iduser);
	$Page = new PageAdmin();
	$Page->setTpl("users-update", array(
		"user"=>$user->getValues()
	));
});

$app->post("/admin/users/create", function(){
	User::verifyLogin();
	$user = new User();
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$user->setData($_POST);
	$user->save();
	header("Location: /admin/users");
	exit;
});

$app->post("/admin/users/:iduser", function($iduser){
	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");
	exit;
});

$app->run();

 ?>