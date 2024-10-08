<!doctype html>
    <body>
        <?php
            //ajout du header
            include("../includes/header.php");
        
            //connexion à la base de donnée MySQL
            include("../includes/connexion.php");
        ?>

        <div id="wrapper" >

            <aside>
                <p>Sur cette page on peut poster un message en se faisant 
                    passer pour quelqu'un d'autre.</p>
            </aside>

            <main>
                <article>
                    <h2>Poster un message</h2>
                    <?php
                    //Récupérer la liste des auteurs
                    $listAuteurs = [];
                    $laQuestionEnSql = "SELECT * FROM users";
                    
                    //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                    include("../includes/execute_query.php");
                    
                    //affiche le résultat de la requête
                    while ($user = $lesInformations->fetch_assoc()) {
                        $listAuteurs[$user['id']] = $user['alias'];
                    }

                    //traiter le formulaire
                    $enCoursDeTraitement = isset($_POST['auteur']);
                    
                    if ($enCoursDeTraitement) {
                        //récupérer ce qu'il y a dans le formulaire
                        $authorId = $_POST['auteur'];
                        $postContent = $_POST['message'];

                        //sécurité pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                        $authorId = intval($mysqli->real_escape_string($authorId));
                        $postContent = $mysqli->real_escape_string($postContent);
                        
                        //requête mySQL
                        $lInstructionSql = "INSERT INTO posts "
                                . "(id, user_id, content, created) "
                                . "VALUES (NULL, "
                                . $authorId . ", "
                                . "'" . $postContent . "', "
                                . "NOW())";

                        //exécution de la requête
                        $ok = $mysqli->query($lInstructionSql);
                        if (! $ok) {
                            echo "Impossible d'ajouter le message: " . $mysqli->error;
                        } else {
                            echo "Message posté en tant que :" . $listAuteurs[$authorId];
                        }
                    }
                    ?>                     
                    
                    <form action="usurpedpost.php" method="post">
                        <input type='hidden' name='???' value='achanger'>
                        <dl>
                            <dt><label for='auteur'>Auteur</label></dt>
                            <dd>
                                <select name='auteur'>
                                    <?php
                                    foreach ($listAuteurs as $id => $alias)
                                    echo "<option value='$id'>$alias</option>";
                                    ?>
                                </select>
                            </dd>
                            <dt><label for='message'>Message</label></dt>
                            <dd><textarea name='message'></textarea></dd>
                        </dl>
                        <input type='submit'>
                    </form>               
                </article>
            </main>
        </div>
    </body>
</html>
