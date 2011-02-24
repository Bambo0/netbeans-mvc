<?php
// V&#233;rification des droits d'acc&#232;s de la page
if (utilisateur_est_connecte()) {

    // On affiche la page d'erreur comme quoi l'utilisateur est d&#233;j&#224; connect&#233;
    include CHEMIN_VUE_GLOBALE.'erreur_deja_connecte.php';

} else {
    // Ne pas oublier d'inclure la librairie Form
    include CHEMIN_LIB.'form.php';

    // "formulaire_connexion" est l'ID unique du formulaire
    $form_connexion = new Form('formulaire_connexion');

    $form_connexion->method('POST');

    $form_connexion->add('Text', 'nom_utilisateur')
                        ->label("Votre nom d'utilisateur");

    $form_connexion->add('Password', 'mot_de_passe')
                        ->label("Votre mot de passe");

    // Ajoutons d'abord une case &#224; cocher au formulaire de connexion
    $form_connexion->add('Checkbox', 'connexion_auto')
                        ->label("Connexion automatique");

    $form_connexion->add('Submit', 'submit')
                        ->value("Connectez-moi !");

    // Pr&#233;-remplissage avec les valeurs pr&#233;c&#233;demment entr&#233;es (s'il y en a)
    $form_connexion->bound($_POST);

    // Cr&#233;ation d'un tableau des erreurs
    $erreurs_connexion = array();

    // Validation des champs suivant les r&#232;gles
    if ($form_connexion->is_valid($_POST)) {

        list($nom_utilisateur, $mot_de_passe) =
                $form_connexion->get_cleaned_data('nom_utilisateur', 'mot_de_passe');

        // On veut utiliser le mod&#232;le des membres (~/modeles/membres.php)
        include_once CHEMIN_MODELE.'membres.php';

        // combinaison_connexion_valide() est d&#233;finit dans ~/modeles/membres.php
        $id_utilisateur = combinaison_connexion_valide($nom_utilisateur, sha1($mot_de_passe));

        // Si les identifiants sont valides
        if (false !== $id_utilisateur) {

            $infos_utilisateur = lire_infos_utilisateur($id_utilisateur);

            // On enregistre les informations dans la session
            $_SESSION['id']     = $id_utilisateur;
            $_SESSION['pseudo'] = $nom_utilisateur;
            $_SESSION['avatar'] = $infos_utilisateur['avatar'];
            $_SESSION['email']  = $infos_utilisateur['adresse_email'];

            // Mise en place des cookies de connexion automatique
            if (false != $form_connexion->get_cleaned_data('connexion_auto'))
            {
                $navigateur = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
                $hash_cookie = sha1('aaa'.$nom_utilisateur.'bbb'.$mot_de_passe.'ccc'.$navigateur.'ddd');

                setcookie( 'id',            $_SESSION['id'], strtotime("+1 year"), '/');
                setcookie('connexion_auto', $hash_cookie,    strtotime("+1 year"), '/');
            }

            // Affichage de la confirmation de la connexion
            include CHEMIN_VUE.'connexion_ok.php';

        } else {

            $erreurs_connexion[] = "Couple nom d'utilisateur / mot de passe inexistant.";

            // Suppression des cookies de connexion automatique
            setcookie('id', '');
            setcookie('connexion_auto', '');

            // On r&#233;affiche le formulaire de connexion
            include CHEMIN_VUE.'formulaire_connexion.php';
        }

    } else {

        // On r&#233;affiche le formulaire de connexion
        include CHEMIN_VUE.'formulaire_connexion.php';
    }
}
?>