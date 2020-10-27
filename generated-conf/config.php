<?php

require_once dirname(__DIR__, 1) . '/environment.php';

$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('default', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();

$config = ENVIRONMENT === "development" ?
	array(
		'dsn' => 'mysql:host=localhost;port=3306;dbname=blog_covid',
		'user' => 'root',
		'password' => 'guiiAmorim',
		'settings' =>
			array (
				'charset' => 'utf8',
				'queries' =>
					array (
					),
			),
		'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
		'model_paths' =>
			array (
				0 => 'src',
				1 => 'vendor',
			),
	) :
	array (
		'dsn' => 'mysql:host=sql302.epizy.com;port=3306;dbname=epiz_26282682_covid',
		'user' => 'epiz_26282682',
		'password' => 'NUo9zYCoVD',
		'settings' =>
			array (
				'charset' => 'utf8',
				'queries' =>
					array (
					),
			),
		'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
		'model_paths' =>
			array (
				0 => 'src',
				1 => 'vendor',
			),
	);

$manager->setConfiguration($config);
$manager->setName('default');
$serviceContainer->setConnectionManager('default', $manager);
$serviceContainer->setDefaultDatasource('default');