<?php
// Tableau des jours et des mois en français
$jours = [
    'Sunday' => 'Dimanche', 'Monday' => 'Lundi', 'Tuesday' => 'Mardi', 
    'Wednesday' => 'Mercredi', 'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 
    'Saturday' => 'Samedi'
];

$mois = [
    'January' => 'Janvier', 'February' => 'Février', 'March' => 'Mars', 
    'April' => 'Avril', 'May' => 'Mai', 'June' => 'Juin', 
    'July' => 'Juillet', 'August' => 'Août', 'September' => 'Septembre', 
    'October' => 'Octobre', 'November' => 'Novembre', 'December' => 'Décembre'
];

// Fonction pour formater une date et la convertir en français
function formaterDateEnFrancais(DateTime $date) {
    global $jours, $mois;
    
    // Formater la date en anglais
    $formattedDate = $date->format('l d F Y H:i');
    
    // Remplacer les jours et mois en anglais par leurs équivalents en français
    $formattedDate = str_replace(array_keys($jours), array_values($jours), $formattedDate);
    $formattedDate = str_replace(array_keys($mois), array_values($mois), $formattedDate);
    
    return $formattedDate;
}
?>