<?php
// ce fichier permet l'initialisation du site. Il sera inclus sur toutes les pages avec les fichiers minimum requis pour le bon fonctionnement du site.
header('Content-type: text/html; charset=UTF-8');
define("RACINE_SITE", "http://www.indiancornner.com/"); // permet d'avoir le chemin absolu afin de gérer les incohérences de l'arboréscence de notre projet
//define("RACINE_SERVER", $_SERVER['DOCUMENT_ROOT']); // permet d'avoir un chemin automatisé
define("RACINE_SERVER", $_SERVER['http://www.indiancornner.com']);

require_once("connection_bdd.inc.php");
require_once("function.inc.php");

session_start(); // création de la session qui sera disponible sur tout le site du fait dêtre sur ce fichier !

$msg = ""; // cette variable contiendra les messages à échanger avec l'utilisateur. Nous la déclarons ici afin de pouvoir faire de la concaténation. (elle existe !)
