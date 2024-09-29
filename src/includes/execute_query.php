<?php

    /*
    exécution de la requête SQL contenue dans la variable $laQuestionEnSql à l'aide de l'objet $mysqli 
    et stockage du résultat dans la variable $lesInformations
    */
    $lesInformations = $mysqli->query($laQuestionEnSql);

    // Vérifier si la requête a réussi
    if (!$lesInformations) {
        echo "Erreur lors de l'exécution de la requête : " . $mysqli->error;
        exit();
    }

?>