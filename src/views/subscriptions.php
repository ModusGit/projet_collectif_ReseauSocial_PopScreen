<!doctype html>
    <body>
        <?php
            //ajout du header
            include("../includes/header.php");
        
            //connexion à la base de donnée MySQL
            include("../includes/connexion.php");
        ?>

        <div id="wrapper">
            <aside>
                <img src="../../assets/images/avatar.png" alt="Portrait de l'utilisatrice"/>
                
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des pop screeners que vous suivez.
                    </p>
                </section>
            </aside>
            
            <main class='contacts'>
                <?php
                //récupère l'id de l'utilisateur via l'URL puis le stocke dans la variable
                $userId = intval($_GET['user_id']);
                
                //requête mySQL à la base de données: récupère le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
                
                //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                include("../includes/execute_query.php");
                
                //affiche le résultat de la requête : la liste des personnes dont l'utilisatrice suit les messages
                while ($subscript = $lesInformations->fetch_assoc()) {
                ?>
                    <article>
                        <img src="../../assets/images/avatar.png" alt="blason"/>
                        <h3>
                            <a href="wall.php?user_id=<?php echo $subscript["id"]?>">
                            <?php echo $subscript["alias"] ?>
                            </a>
                        </h3> 
                    </article>                
                <?php } ?>
            </main>
        </div>
    </body>
</html>
