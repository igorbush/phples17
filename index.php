<?php
session_start();
error_reporting( E_ERROR );
require_once 'vendor/autoload.php';
$config = include 'config.php';
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    'cache' => false,
));
include 'libs/database.php';
$db = DataBase::connect(
	$config['mysql']['host'],
	$config['mysql']['dbname'],
	$config['mysql']['user'],
	$config['mysql']['pass']
);
include 'libs/router.php';