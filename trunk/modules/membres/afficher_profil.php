<?php
// Pas de v&#233;rification de droits d'acc&#232;s n&#233;cessaire : tout le monde peut voir un profil utilisateur :)
include_once CHEMIN_LIB.'table.php';

$tab = new Table("test", 1, 2);
$tab->add_en_tete("truc", "machin", "chose")
        ->getCell(0)->setAttributs("width=100px");
$tab->add_ligne("<b>a</b>", "d", "c");
$tab->add_ligne("b", "c", "a");
$tab->add_ligne("c", "a", "b");
$tab->add_ligne("d", "b", "d");
$tab->caption("test");

echo $tab;


// Si le param&#232;tre id est manquant ou invalide
if (empty($_GET['id']) or !is_numeric($_GET['id'])) {

	include CHEMIN_VUE.'erreur_parametre_profil.php';

} else {

	// On veut utiliser le mod&#232;le des membres (~/modules/membres.php)
	include_once CHEMIN_MODELE.'membres.php';
	
	// lire_infos_utilisateur() est d&#233;fini dans ~/modules/membres.php
	$infos_utilisateur = lire_infos_utilisateur($_GET['id']);
	
	// Si le profil existe et que le compte est valid&#233;
	if (false !== $infos_utilisateur && $infos_utilisateur['hash_validation'] == '') {
		//ne fonctionne qu'avec des tableau numerique
		//list($nom_utilisateur, ,$avatar, $adresse_email, $date_inscription, ) = $infos_utilisateur;
		
		$nom_utilisateur = $infos_utilisateur['nom_utilisateur'];
		$avatar = $infos_utilisateur['avatar'];
		$adresse_email = $infos_utilisateur['adresse_email'];
		$date_inscription = $infos_utilisateur['date_inscription'];
		
		//echo $infos_utilisateur['nom_utilisateur'];
		//print_r($infos_utilisateur);
		//echo 'blabla'.$adresse_email;
		include CHEMIN_VUE.'profil_infos_utilisateur.php';

	} else {

		include CHEMIN_VUE.'erreur_profil_inexistant.php';
	}
}


?>