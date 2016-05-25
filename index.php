<?php
//header('Content-type: application/json');


use CTIMT\MyOrm\Builder\ModelDirector;
use CTIMT\MyOrm\Builder\StandardModelBuilder;
use CTIMT\MyOrm\Example\CountryEntry;
use CTIMT\MyOrm\Model\Model;

include './vendor/autoload.php';
$adapter = new PDO('mysql:dbname=springs_local;host=127.0.0.1', 'root');
$modelDirector = new ModelDirector(new StandardModelBuilder());

/* @var $model Model */
$model = $modelDirector->buildModel(new CountryEntry(), $adapter)->getModel();
echo json_encode($model->update(958, ['value' => 'Albania' . rand(0, 100)]));
die();
//echo json_encode($model->fetchAll());