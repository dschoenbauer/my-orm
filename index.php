<?php
//header('Content-type: application/json');
use CTIMT\MyOrm\Example\ListEntity;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Model\ModelFactory;

include './vendor/autoload.php';
$adapter = new PDO('mysql:dbname=north;host=127.0.0.1', 'root');
$modelFactory = new ModelFactory(New ListEntity(), $adapter);

/* @var $model Model */
$model = $modelFactory->getStandardModel();
echo json_encode($model->fetchAll());