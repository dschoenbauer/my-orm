<?php
//header('Content-type: application/json');


use CTIMT\MyOrm\Builder\ModelDirector;
use CTIMT\MyOrm\Builder\StandardModelBuilder;
use CTIMT\MyOrm\Connection\ConnectionDecorator;
use CTIMT\MyOrm\Example\CountryEntry;
use CTIMT\MyOrm\Model\Model;
use CTIMT\MyOrm\Visitor\Setup\EncodingDb;
use CTIMT\MyOrm\Visitor\Setup\TimeZoneDb;

include './vendor/autoload.php';
$adapter = new ConnectionDecorator(new PDO('mysql:dbname=springs_local;host=127.0.0.1', 'root'));
$adapter->accept(new EncodingDb());
$adapter->accept(new TimeZoneDb());

$modelDirector = new ModelDirector(new StandardModelBuilder());

/* @var $model Model */
$model = $modelDirector->buildModel(new CountryEntry(), $adapter)->getModel();

/*
 * echo json_encode($model->update(1238,
    [
        'country_id'=>'1238',
        'country_name' => 'Albania' . rand(0, 100),
        'country_requireState' => false,
        'country_abbrev2'=>'Bo',
        'country_abbrev3'=>'Bon'
    ]));
    */
//die();
echo json_encode($model->fetchAll());