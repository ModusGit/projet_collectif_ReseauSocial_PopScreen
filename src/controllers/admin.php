<!doctype html>
    <body>
        <?php
            //ajout du header
            include("../includes/header.php");
        
            //connexion à la base de donnée MySQL
            include("../includes/connexion.php");
        ?>

        <div id="wrapper" class='admin'>
            
            <aside>
                <h2>Mots-clés</h2>
                
                <?php
                //sélectionner toutes les colonnes de la table tags et limité le résultat à 50 lignes
                $laQuestionEnSql = "SELECT * FROM `tags` LIMIT 50";
                
                //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                include("../includes/execute_query.php");
                
                //affiche le résultat de la requête
                while ($tag = $lesInformations->fetch_assoc()) {
                ?>
                    <article>
                        <h3>#<?php echo $tag["label"] ?></h3>
                        <p><?php echo $tag["id"]?></p>
                        <nav>
                            <a href="../views/tags.php?tag_id=<?php echo $tag["id"]?>">Messages</a>
                        </nav>
                    </article>
                <?php } ?>
            </aside>

            <main>
                <h2>Pop Screeners</h2>
                
                <?php
                //sélectionner toutes les colonnes de la table users et limité le résultat à 50 lignes
                $laQuestionEnSql = "SELECT * FROM `users` LIMIT 50";
                
                //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                include("../includes/execute_query.php");
                
                //affiche le résultat de la requête
                while ($lesUtilisatrices = $lesInformations->fetch_assoc()) {
                ?>
                    <article>
                        <h3><?php echo $lesUtilisatrices["alias"] ?></h3>
                        <p><?php echo $lesUtilisatrices["id"]?></p>
                        <nav>
                            <a href="../views/wall.php?user_id=
                            <?php echo $lesUtilisatrices["id"]?>">Mur</a>
                            
                            <a href="../views/feed.php?user_id=
                            <?php echo $lesUtilisatrices["id"]?>">Flux</a>
                            
                            <a href="../views/settings.php?user_id=
                            <?php echo $lesUtilisatrices["id"]?>">Paramètres</a>
                            
                            <a href="../views/followers.php?user_id=
                            <?php echo $lesUtilisatrices["id"]?>">Suiveurs</a>
                            
                            <a href="../views/subscriptions.php?user_id=
                            <?php echo $lesUtilisatrices["id"]?>">Abonnements</a>
                        </nav>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
