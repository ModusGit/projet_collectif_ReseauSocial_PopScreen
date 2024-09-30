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
                    <p>Les derniers messages de tous les pop screeners.
                    </p>
                </section>
            </aside>

            <main>
                <?php
                //requête mySQL à la base de données et récupérer ses informations
                $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,
                    users.id as author_id,
                    posts_tags.post_id as post_id,
                    posts_tags.tag_id as tag_id,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    LIMIT 5
                    ";
                
                //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                include("../includes/execute_query.php");

                //affiche le résultat de la requête : les derniers posts de tous les utilisateurs du site
                //à chaque tour du while, la variable post ci dessous reçois les informations du post suivant.
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
                                <?php echo $post['author_name'] ?></a>
                        </address>
                        
                        <div>
                            <p><?php echo $post['content'] ?></p>
                        </div>
                        
                        <footer>
                            <small>♥ <?php echo $post['like_number'] ?></small>
                            <a href="tags.php?tag_id=<?php echo $post['tag_id'] ?>">
                                #
                                <?php echo $post['taglist'] ?>
                            </a>
                        </footer>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
