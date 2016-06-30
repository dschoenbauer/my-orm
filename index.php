<?php
//header('Content-type: application/json');


use CTIMT\MyOrm\Adapter\ErrorHandlerException;
use CTIMT\MyOrm\Builder\ModelDirector;
use CTIMT\MyOrm\Builder\StandardModelBuilder;
use CTIMT\MyOrm\Connection\ConnectionDecorator;
use CTIMT\MyOrm\Example\CountryEntry;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Visitor\Setup\EncodingDb;
use CTIMT\MyOrm\Visitor\Setup\TimeZoneDb;

include './vendor/autoload.php';
$adapter = new ConnectionDecorator(new PDO('sqlsrv:Server=CTT-DSCHOEN\\SQLEXPRESS;Database=springs_local', 'admin','admin'));
//$adapter = new ConnectionDecorator(new PDO('mysql:dbname=springs_local;host=127.0.0.1', 'root'));
$adapter->accept(new EncodingDb());
$adapter->accept(new TimeZoneDb());
$adapter->accept(new ErrorHandlerException());

$modelDirector = new ModelDirector(new StandardModelBuilder());

/* @var $model Model */
$model = $modelDirector->buildModel(new CountryEntry(), $adapter)->getModel();


 echo json_encode($model->fetch(293));
  
 //var_dump($model->delete($model->getId())); 
die();

echo "<pre>",json_encode($model->fetchAll());