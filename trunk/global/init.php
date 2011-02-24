<?php

// Inclusion du fichier de configuration (qui d&#233;finit des constantes)
include 'global/config.php';

// Utilisation et d&#233;marrage des sessions
session_start();


// D&#233;sactivation des guillemets magiques
ini_set('magic_quotes_runtime', 0);
set_magic_quotes_runtime(0);

if (1 == get_magic_quotes_gpc())
{
	function remove_magic_quotes_gpc(&$value) {
	
		$value = stripslashes($value);
	}
	array_walk_recursive($_GET, 'remove_magic_quotes_gpc');
	array_walk_recursive($_POST, 'remove_magic_quotes_gpc');
	array_walk_recursive($_COOKIE, 'remove_magic_quotes_gpc');
}

// Inclusion de Pdo2, potentiellement utile partout
include CHEMIN_LIB.'pdo2.php';

// V&#233;rifie si l'utilisateur est connect&#233;   
function utilisateur_est_connecte() {
 
	return !empty($_SESSION['id']);
}
?>



<?php
// V&#233;rifications pour la connexion automatique

// On a besoin du mod&#232;le des membres
include CHEMIN_MODELE.'membres.php';

// Le mec n'est pas connect&#233; mais les cookies sont l&#224;, on y va !
if (!utilisateur_est_connecte() && !empty($_COOKIE['id']) && !empty($_COOKIE['connexion_auto']))
{
	$infos_utilisateur = lire_infos_utilisateur($_COOKIE['id']);
	
	if (false !== $infos_utilisateur)
	{
		$navigateur = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$hash = sha1('aaa'.$infos_utilisateur['nom_utilisateur'].'bbb'.$infos_utilisateur['mot_de_passe'].'ccc'.$navigateur.'ddd');
		
		if ($_COOKIE['connexion_auto'] == $hash)
		{
			// On enregistre les informations dans la session
			$_SESSION['id']     = $_COOKIE['id'];
			$_SESSION['pseudo'] = $infos_utilisateur['nom_utilisateur'];
			$_SESSION['avatar'] = $infos_utilisateur['avatar'];
			$_SESSION['email']  = $infos_utilisateur['adresse_email'];
		}
	}
}


?>