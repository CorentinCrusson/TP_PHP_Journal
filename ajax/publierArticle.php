<?php

session_start();

include_once('../class/autoload.php');

$errors         = array();
$data 			= array();
$data['success']=false;

$tab=array();
$mypdo=new mypdo();

$tab['idArticle'] = $_POST['idArticle'];

$data=$mypdo->publie_article($tab);
echo json_encode($data);
?>
