<?php
$fil_ariane = '<i>Vous êtes ici : </i>
    <a href ="./index.php?module=forum&amp;action=index">Index du forum</a>';
$titre     = '<h1>Mon super forum</h1>';


//Initialisation de deux variables
$totaldesmessages = 0;
$categorie = NULL;

include_once CHEMIN_MODELE.'forum.php';

$query = forum_debut($lvl);

?>

    <?php
//echo '<table>';
include_once CHEMIN_LIB.'table.php';

    //Début de la boucle
    while($data = $query->fetch())
    {
        //On affiche chaque catégorie
        if( $categorie != $data['cat_id'] )
        {
            
            //Si c'est une nouvelle catégorie on l'affiche

            $categorie = $data['cat_id'];

            $tab_forum[$categorie] = new Table("tab_forum");

            $tab_forum[$categorie]->add_en_tete('',
                                    "<strong>".
                                        stripslashes(htmlspecialchars($data['cat_nom'])).
                                    "</strong>",
                                    '<strong>Sujets</strong>',
                                    '<strong>Messages</strong>',
                                    '<strong>Dernier message</strong>');
            $tab_forum[$categorie]->add_att_en_tete(2, 'class="titre"');
            $tab_forum[$categorie]->add_att_en_tete(3, 'class="nombremessages"');
            $tab_forum[$categorie]->add_att_en_tete(4, 'class="nombresujets"');
            $tab_forum[$categorie]->add_att_en_tete(5, 'class="derniermessage"');
            /*?>
            <tr>
            <th></th>
            <th class="titre"><strong><?php echo stripslashes(htmlspecialchars($data['cat_nom'])); ?>
            </strong></th>
            <th class="nombremessages"><strong>Sujets</strong></th>
            <th class="nombresujets"><strong>Messages</strong></th>
            <th class="derniermessage"><strong>Dernier message</strong></th>
            </tr>
            <?php*/

        }

        // Ce super echo de la mort affiche tous
        // les forums en détail : description, nombre de réponses etc...

        /*echo'<tr>
                <td><img src="./images/message.gif" alt="message" /></td>
                <td class="titre">
                    <strong>
                        <a href="./voirforum.php?f='.$data['forum_id'].'">
                            '.stripslashes(htmlspecialchars($data['forum_name'])).'
                        </a>
                    </strong>
                    <br />'.nl2br(stripslashes(htmlspecialchars($data['forum_desc']))).'
                </td>
                <td class="nombresujets">'.
                    $data['forum_topic'].'
                </td>
                <td class="nombremessages">'.
                    $data['forum_post'].'
                </td>';*/

        // Deux cas possibles :
        // Soit il y a un nouveau message, soit le forum est vide
        if (!empty($data['forum_post']))
        {
             //Selection dernier message
             $nombreDeMessagesParPage = 15;
             $nbr_post = $data['topic_post'] +1;
             $page = ceil($nbr_post / $nombreDeMessagesParPage);

             $derniere_ligne = '
             '.date('H\hi \l\e d/M/Y',$data['post_time']).'<br />
             <a href="./voirprofil.php?m='.
                     stripslashes(htmlspecialchars($data['membre_id'])).
                     '&amp;action=consulter">'.
                 $data['membre_pseudo'].'
             </a>
             <a href="./voirtopic.php?t='.$data['topic_id'].'&amp;page='.$page.'#p_'.$data['post_id'].'">
                <img src="./images/go.gif" alt="go" />
             </a>';

         }
         else
         {
             $derniere_ligne = 'Pas de message';
         }

         $tab_forum[$categorie]->add_ligne(  '<img src="./images/message.gif" alt="message" />',
                        '<strong>
                            <a href="./voirforum.php?f='.$data['forum_id'].'">
                                '.stripslashes(htmlspecialchars($data['forum_name'])).'
                            </a>
                        </strong>
                        <br />'.nl2br(stripslashes(htmlspecialchars($data['forum_desc']))),
                        $data['forum_topic'],
                        $data['forum_post'],
                        $derniere_ligne);

         //Cette variable stock le nombre de message, on la met à jour
         $totaldesmessages += $data['forum_post'];

         //On ferme notre boucle et nos balises
    } //fin de la boucle
    $query->CloseCursor();
//echo '</table>';


//Ici, on met le contenu de chaque catégorie
include CHEMIN_VUE.'index.php';
?>













