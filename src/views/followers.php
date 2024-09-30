
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
                <img src = "../../assets/images/avatar.png" alt = "Portrait de l'utilisatrice"/>
                
                <section>
                    <p>Les pop screeners qui vous suivent.</p>
                </section>
            </aside>

            <main class='contacts'>
                <?php
                //récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);

        
                //sélectionne les followers de l'utilisateur et récupère leurs données
                $laQuestionEnSql = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
                
                //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                include("../includes/execute_query.php");
                
                //affiche le résultat de la requête : les followers de l'utilisateur
                while ($followers = $lesInformations->fetch_assoc())
                {?>
                    <article>
                        <img src="../../assets/images/avatar.png" alt="blason"/>
                        <h3><a href="wall.php?user_id=<?php echo $followers["id"] ?>"><?php echo $followers["alias"] ?></a></h3> 
                    </article>   
                <?php } ?>
            </main>
        </div>
    </body>
</html>
