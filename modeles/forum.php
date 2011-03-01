<?php

function forum_debut($lvl){
    //Cette requete permet d'obtenir tout sur le forum
    $pdo = PDO2::getInstance();

    $query=$pdo->prepare('SELECT cat_id, cat_nom,
    forum_forum.forum_id, forum_name, forum_desc, forum_post, forum_topic, auth_view, forum_topic.topic_id,
    forum_topic.topic_post, post_id, post_time, post_createur, membre_pseudo, membre_id
    FROM forum_categorie
    LEFT JOIN forum_forum ON forum_categorie.cat_id = forum_forum.forum_cat_id
    LEFT JOIN forum_post ON forum_post.post_id = forum_forum.forum_last_post_id
    LEFT JOIN forum_topic ON forum_topic.topic_id = forum_post.topic_id
    LEFT JOIN forum_membres ON forum_membres.membre_id = forum_post.post_createur
    WHERE auth_view <= :lvl
    ORDER BY cat_ordre, forum_ordre DESC');
    $query->bindValue(':lvl',$lvl,PDO::PARAM_INT);
    $query->execute();
    return $query;
}


?>
