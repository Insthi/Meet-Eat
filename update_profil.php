<?php
session_start();
require 'db.php';
if(!isset($_SESSION['id_user'])) exit;

$id = $_SESSION['id_user'];

$action = $_POST['action'] ?? '';

if($action==='photo'){
    $url = $_POST['url'] ?? '';
    if($url){
        $stmt = $pdo->prepare("UPDATE profils SET photo=? WHERE id_user=?");
        $stmt->execute([$url,$id]);
        echo 'OK';
    }
}
if($action==='infos'){
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $ville = $_POST['ville'] ?? '';
    $relation = $_POST['relation'] ?? '';
    $bio = $_POST['bio'] ?? '';

    $stmt = $pdo->prepare("UPDATE profils SET prenom=?, nom=?, ville=?, relation=?, biographie=? WHERE id_user=?");
    $stmt->execute([$prenom,$nom,$ville,$relation,$bio,$id]);
    echo 'OK';
}
