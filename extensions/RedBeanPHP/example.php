<?php

//Example Script, saves Hello World to the database.

//First, we need to include redbean
require_once('rb.php');

//Second, we need to setup the database

//If you work on Mac OSX or Linux (or another UNIX like system)
//You can simply use this line:

//R::setup(); //This creates an SQLite database in /tmp
//R::setup('database.txt'); -- for other systems

R::setup('mysql:host=localhost;dbname=mydatabase',
        'root','comscitec1213'); //mysql

//Ready. Now insert a bean!
$bean = R::dispense('person');
$bean->name = 'Hello World';
$bean->sex = 'male';

//Store the bean
$id = R::store($bean);
echo 'id-',$id;
//Reload the bean
$leaflet = R::load('person',$id);

//Display the title
echo $leaflet->name;

echo 'over';


