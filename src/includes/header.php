<?php
session_start();
?> 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pop Screen</title>
    <link rel="stylesheet" href="/projet_collectif_ReseauSocial_PopScreen/assets/css/style.css">
</head>
<body>
    <header>
        <img src="/projet_collectif_ReseauSocial_PopScreen/assets/images/popcorn.png" alt="Logo pop screen" id="logo"/>
        
        <nav id="menu">
            <a href="/projet_collectif_ReseauSocial_PopScreen/src/views/news.php">
                <img src="/projet_collectif_ReseauSocial_PopScreen/assets/images/actu.png" alt="actualités">
            </a>
            <a href="/projet_collectif_ReseauSocial_PopScreen/src/views/wall.php?user_id=<?php echo $_SESSION['connected_id']; ?>">
                <img src="/projet_collectif_ReseauSocial_PopScreen/assets/images/mur.png" alt="mur">
            </a>
            <a href="/projet_collectif_ReseauSocial_PopScreen/src/views/feed.php?user_id=<?php echo $_SESSION['connected_id']; ?>">
                <img src="../../assets/images/feed.png" alt="feed">
            </a>
            <a href="/projet_collectif_ReseauSocial_PopScreen/src/views/tags.php?tag_id=1">
                <img src="../../assets/images/tags.png" alt="mots clés">
            </a>
        </nav>

        <nav id="user">
            <a href="#"><img src="../../assets/images/profil.png" alt="icone de profil"></a>
            <ul>
                <li><a href="/projet_collectif_ReseauSocial_PopScreen/src/views/settings.php?user_id=
                <?php echo $_SESSION['connected_id']; ?>">Mes Paramètres</a>
                </li>
                <li><a href="/projet_collectif_ReseauSocial_PopScreen/src/views/followers.php?user_id=
                <?php echo $_SESSION['connected_id']; ?>">Mes suiveurs</a>
                </li>
                <li><a href="/projet_collectif_ReseauSocial_PopScreen/src/views/subscriptions.php?user_id=
                <?php echo $_SESSION['connected_id']; ?>">Mes abonnements</a>
                </li>
            </ul>
        </nav>
    </header>
</body>
</html>