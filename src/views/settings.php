<!doctype html>
    <body>
        <?php
            //ajout du header
            include("../includes/header.php");
        
            //connexion à la base de donnée MySQL
            include("../includes/connexion.php");
        ?>

        <div id="wrapper" class='profile'>

            <aside>
                <img src="../../assets/images/avatar.png" alt="Portrait de l'utilisatrice"/>
                
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez vos informations de compte.
                </section>
            </aside>
            
            <main>
                <?php
                //récupère l'id de l'utilisateur via l'URL puis le stocke dans la variable
                $userId = intval($_GET['user_id']);
                
                //requête mySQL à la base de données et récupérer ses informations
                $laQuestionEnSql = "
                    SELECT users.*, 
                    count(DISTINCT posts.id) as totalpost, 
                    count(DISTINCT given.post_id) as totalgiven, 
                    count(DISTINCT recieved.user_id) as totalrecieved 
                    FROM users 
                    LEFT JOIN posts ON posts.user_id=users.id 
                    LEFT JOIN likes as given ON given.user_id=users.id 
                    LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
                    WHERE users.id = '$userId' 
                    GROUP BY users.id
                    ";
                //exécution de la requête mySQL contenue dans la variable $laQuestionEnSql
                include("../includes/execute_query.php");                
                
                $user = $lesInformations->fetch_assoc();
               ?>                

                <article class='parameters'>
                    <h3>Mes paramètres</h3>
                    <dl>
                        <dt>Pseudo</dt>
                        <dd><?php echo $user["alias"] ?></dd>
                        <dt>E-mail</dt>
                        <dd><?php echo $user["email"] ?></dd>
                        <dt>Nombre de message</dt>
                        <dd><?php echo $user["totalpost"] ?></dd>
                        <dt>Nombre de "J'aime" donnés </dt>
                        <dd><?php echo $user["totalgiven"] ?></dd>
                        <dt>Nombre de "J'aime" reçus</dt>
                        <dd><?php echo $user["totalrecieved"] ?></dd>
                    </dl>
                </article>
            </main>
        </div>
    </body>
</html>
