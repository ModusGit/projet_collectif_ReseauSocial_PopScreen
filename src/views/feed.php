
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
                <?php
                //Le mur concerne un utilisateur en particulier
                $userId = intval($_GET['user_id']);
                $user_connectedID = $_SESSION['connected_id'];
                
                //sélectionner toutes les colonnes dans la table users, de l'utilisateur connecté
                $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
                
                //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                include("../includes/execute_query.php");
                
                $user = $lesInformations->fetch_assoc();
                ?>

                <img src="../../assets/images/avatar.png" alt="Portrait de l'utilisatrice"/>
                
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message des pop screeners que vous suivez,
                        <a href="wall.php?user_id=<?php echo $user["id"] ?>"><?php echo $user["alias"] ?>.</a>
                    </p>
                </section>
            </aside>
            
            <main>
                <?php
                //récupérer tous les messages des utilisateurs auxquel est abonné l'utilisateur connecté
                $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name, 
                    users.id as author_id, 
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM followers 
                    JOIN users ON users.id=followers.followed_user_id
                    JOIN posts ON posts.user_id=users.id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE followers.following_user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                
                //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                include("../includes/execute_query.php");
                
                //affiche le résultat de la requête : les posts du flux
                while ($post = $lesInformations->fetch_assoc()) {
                ?>                
                    <article>
                        <h3>
                            <?php
                            include_once('../includes/format_date.php');

                            // Créer un objet DateTime à partir de la date du post
                            $date = new DateTime($post['created']);
                            
                            ?>

                            <time><?php echo formaterDateEnFrancais($date), "\n";?></time>
                        </h3>
                        
                        <address> 
                            De 
                            <a href="wall.php?user_id=<?php echo $post["author_id"] ?>">
                            <?php echo $post["author_name"] ?>
                            </a>
                        </address>
                        
                        <div>
                            <p><?php echo $post["content"] ?></p>
                        </div>

                        <footer>
                            <small>♥ <?php echo $post["like_number"] ?></small>
                            <a href="tags.php?tag_id=<?php echo $post['taglist'] ?>">
                            #
                            <?php echo $post["taglist"] ?>
                            </a>
                        </footer>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
