<?php

// Identifiants pour la base de donn&#233;es. N&#233;cessaires a PDO2.
define('SQL_DSN',      'mysql:dbname=mvc;host=localhost');
define('SQL_USERNAME', 'root');
define('SQL_PASSWORD', '');

// Chemins &#224; utiliser pour acc&#233;der aux vues/modeles/librairies
$module = empty($module) ? !empty($_GET['module']) ? $_GET['module'] : 'index' : $module;
define('CHEMIN_VUE',         'modules/'.$module.'/vues/');
define('CHEMIN_MODELE',      'modeles/');
define('CHEMIN_LIB',         'libs/');
define('CHEMIN_VUE_GLOBALE', 'vues_globales/');

define('DOSSIER_AVATAR', 'images/avatars/');

// Configurations relatives &#224; l'avatar
define('AVATAR_LARGEUR_MAXI', 100);
define('AVATAR_HAUTEUR_MAXI', 100);

?>