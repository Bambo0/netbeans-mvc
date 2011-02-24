<?php

// V&#233;rification des droits d'acc&#232;s de la page
if (!utilisateur_est_connecte()) {

	// On affiche la page d'erreur comme quoi l'utilisateur doit être connect&#233; pour voir la page
	include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';
	
} else {

	// Suppression de toutes les variables et destruction de la session
	$_SESSION = array();
	session_destroy();

	// Suppression des cookies de connexion automatique
	setcookie('id', '');
	setcookie('connexion_auto', '');

	include CHEMIN_VUE.'deconnexion_ok.php';
}
?>