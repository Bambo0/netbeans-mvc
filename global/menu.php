<div id="menu">
    <h2>Menu</h2>
    <ul>
        <li><a href="index.php">Accueil</a></li>
    </ul>
    <h3>Espace membre</h3>

	<?php if (!utilisateur_est_connecte()) { ?>
	<ul>
		<li><a href="index.php?module=membres&amp;action=inscription">Inscription</a></li>
		<li><a href="index.php?module=membres&amp;action=connexion">Connexion</a></li>
		<li><a href="index.php?module=membres&amp;action=afficher_profil&amp;id=4">Profil</a></li>
		
	</ul>
	<?php } else { ?>
	<p>Bienvenue, <?php echo htmlspecialchars($_SESSION['pseudo']); ?>.</p>
	<ul>
		<li><a href="index.php?module=membres&amp;action=deconnexion">D&#233;connexion</a></li>
		<li><a href="index.php?module=membres&amp;action=modifier_profil">Profil</a></li>
	</ul>
	<?php } ?>

        <ul>
            <li><a href="index.php?module=forum&amp;action=index">Index du Forum</a></li>
        </ul>

</div>
