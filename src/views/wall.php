
<!doctype html>
    <body>
        <?php
            //ajout du header
            include("../includes/header.php");
        
            //connexion à la base de donnée MySQL
            include("../includes/connexion.php");
        ?>

        <div id="wrapper">
            
            <?php
            
            if (isset($_GET['user_id'])) {
                $user_wall_id =intval($_GET['user_id']);
            } else {
                $user_wall_id =$_SESSION['connected_id'];
            }
            ?>

            <aside>
                <?php
                 //sélectionner dans la table users, l'utilisateur connecté             
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$user_wall_id' ";
                
                //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                include("../includes/execute_query.php");

                $user = $lesInformations->fetch_assoc();
                ?>

                <img src="../../assets/images/avatar.png" alt="Portrait du pop screener connecté"/>
                
                <section>
                    <p>Tous vos messages, <?php echo $user["alias"] ?>.
                    </p>
                </section>
                
                <article>
                    <?php

                    //s'abonner à un pop screener
                    $enCoursDeTraitement = isset($_POST['jeVeuxTeSuivre']);
                    if ($enCoursDeTraitement) {
                        $followed_connectedID = $_POST['jeVeuxTeSuivre'];
                        $following_connectedID = $_POST['tuMeSuis'];
                        
                        //requête my SQL
                         $lInstructionSql = "INSERT INTO followers "
                                . "(id, followed_user_id, following_user_id) "
                                . "VALUES (NULL, "
                                . $followed_connectedID . ", "
                                . "'" . $following_connectedID . "' )";

                        //exécution de la requête
                        $ok = $mysqli->query($lInstructionSql);
                        if (! $ok) {
                            echo "Impossible de suivre ce pop screener." . $mysqli->error;
                        } else {
                            echo "Cool un nouveau pop screen friend!";
                        }
                    }

                    if (isset($_GET['user_id'])) { 
                    ?>
                        <form action="wall.php" method="post">
                            <input type='hidden' name='tuMeSuis' value="<?php echo $_SESSION['connected_id']?>"> 
                            <input type='hidden' name='jeVeuxTeSuivre' value="<?php echo $_GET['user_id']?>">
                            <input type='submit' value="Abonne-toi  &#127909"></input> 
                         </form> 
                    <?php } ?>       
                </article>
            </aside>

            <main>
                <?php
                //récupérer tous les messages de l'utilisatrice
                $laQuestionEnSql = "
                    SELECT posts.content, 
                    posts.created, 
                    users.alias as author_name, 
                    posts_tags.post_id as post_id,
                    posts_tags.tag_id as tag_id,
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$user_wall_id' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                
                //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                include("../includes/execute_query.php");
                
                //affiche le résultat de la requête : les posts de l'utilisatrice
                while ($post = $lesInformations->fetch_assoc())
                {
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
                            <?php echo $post["author_name"] ?>
                        </address>
                        
                        <div>
                            <p><?php echo $post["content"] ?></p>
                        </div>

                        <footer>
                            <small>♥ <?php echo $post["like_number"] ?></small>
                            <a href="tags.php?tag_id=<?php echo $post['tag_id'] ?>">
                            #
                            <?php echo $post["taglist"] ?>
                            </a>
                        </footer>
                    </article>
                <?php } ?>
                
                    <article>
                        <h2>Poster un message</h2>
                        <?php
                        $enCoursDeTraitement = isset($_POST['author_id']);
                        if ($enCoursDeTraitement) {
                            $user_connectedID = $_POST['author_id'];
                            $postContent = $_POST['message'];
                            
                            //sécurité: évite les injections
                            $user_connectedID = intval($mysqli->real_escape_string($user_connectedID));
                            $postContent = $mysqli->real_escape_string($postContent);
                            
                            //requête mySQL
                            $lInstructionSql = "INSERT INTO posts "
                                . "(id, user_id, content, created) "
                                . "VALUES (NULL, "
                                . $user_connectedID . ", "
                                . "'" . $postContent . "', "
                                . "NOW())";

                            //exécution de la requête mySQL
                            $ok = $mysqli->query($lInstructionSql);
                            if (! $ok) {
                                echo "Impossible d'ajouter le message: " . $mysqli->error;
                            } else {
                                echo "Message posté en tant que :" . $user_wall_id;
                            }
                        }
                        ?>                     
                    
                    <form action="wall.php" method="post">
                        <input type='hidden' name='author_id' value="<?php echo $user_wall_id ?>">
                        <dl>
                            <dt><label for='message'></label></dt>
                            <dd><textarea name='message'></textarea></dd>
                        </dl>
                        <input type='submit'>
                    </form>               
                </article>
            </main>
        </div>
    </body>
</html>
