<?php
//test pour la classe tableau
include_once CHEMIN_LIB.'table.php';

$tab = new Table("test", 1, 2);
$tab->add_en_tete("truc", "machin", "chose");
//$tab->add_att_en_tete(1, "width=200px");
$tab->add_ligne("<b>a</b>", "d", "c");
$tab->add_ligne("b", "c", "a");
$tab->add_ligne("c", "a", "b");
$tab->add_ligne("d", "b", "d");
$tab->caption("test");

//test pour la classe list
include_once CHEMIN_LIB.'liste.php';

$list = new Liste('testtttt',1);
$list->add_value('test1');
$list->add_value('test2');
$list->add_value('test3');

$list_def = new Liste('testtttt2',2);
$list_def->add_values('test1', 'cecei est le test 1');
$list_def->add_values('test2', 'celui la le secon');
$list_def->add_values('test3', 'et voici le dernier enfin normalement cest bien fini');

?>
