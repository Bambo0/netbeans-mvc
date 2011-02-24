<?php

// Initialisation
include 'global/init.php';

// D&#233;but de la tamporisation de sortie
ob_start();

// Si un module est specifi&#233;, on regarde s'il existe
if (!empty($_GET['module'])) {

	$module = dirname(__FILE__).'/modules/'.$_GET['module'].'/';
	
	// Si l'action est specifi&#233;e, on l'utilise, sinon, on tente une action par d&#233;faut
	$action = (!empty($_GET['action'])) ? $_GET['action'].'.php' : 'index.php';
	
	// Si l'action existe, on l'ex&#233;cute
	if (is_file($module.$action)) {

		include $module.$action;

	// Sinon, on affiche la page d'accueil !
	} else {

		include 'global/accueil.php';
	}

// Module non specifi&#233; ou invalide ? On affiche la page d'accueil !
} else {

	include 'global/accueil.php';
}

// Fin de la tamporisation de sortie
$contenu = ob_get_clean();

// D&#233;but du code HTML
include 'global/haut.php';

echo $contenu;

// Fin du code HTML
include 'global/bas.php';
?>