<?php
namespace Man;
include ("1.php");
include ("2.php");
use Manager as Man;

echo 'getUsers = ';print_r( Man\User::getUsers('40') );echo '<br>';

$names = array('Rob', 'Vov');
$names_query = '';

if(empty($_GET['validate'])) {
    $validate = serialize(array('Rob', 'Vov'));
    $hmac = hash_hmac('sha1', $validate, '2023');
    $link = 'http://localhost/Joomla_3.9.27/Tests/NodaSoft/test.php?names='.$names_query.'&validate=' . $hmac;

    header($link);exit();
}else{
    echo 'getByNames = ';print_r( Man\User::getByNames($_GET['names'],$_GET['validate']) );echo '<br>';
}

$newuser = array();
$newuser[0]['name']='Yoda';
$newuser[0]['lastName']='Yoda Фриборн';
$newuser[0]['age']='896';

$newuser[1]['name']='Palpatin';
$newuser[1]['lastName']='Palpatin';
$newuser[1]['age']='80';

echo 'getUsers = ';print_r( Man\User::users($newuser) );echo '<br>';
