<?php
// V&#233;rification des droits d'acc&#232;s de la page
if (utilisateur_est_connecte()) {

	// On affiche la page d'erreur comme quoi l'utilisateur est d&#233;j&#224; connect&#233;   
	include CHEMIN_VUE_GLOBALE.'erreur_deja_connecte.php';
	
} else {
	// On v&#233;rifie qu'un hash est pr&#233;sent
	if (!empty($_GET['hash'])) {

		// On veut utiliser le mod&#232;le des membres (~/modeles/membres.php)
		include CHEMIN_MODELE.'membres.php';

		// valider_compte_avec_hash() est d&#233;finit dans ~/modeles/membres.php
		if (valider_compte_avec_hash($_GET['hash'])) {
		
			// Affichage de la confirmation de validation du compte
			include CHEMIN_VUE.'compte_valide.php';
		
		} else {
		
			// Affichage de l'erreur de validation du compte
			include CHEMIN_VUE.'erreur_activation_compte.php';
		}

	} else {

		// Affichage de l'erreur de validation du compte
		include CHEMIN_VUE.'erreur_activation_compte.php';
	}
}
?>