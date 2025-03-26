<?php
/**
 * Calcule le coût du stationnement en fonction des paliers tarifaires.
 * 
 * @param string $dateEntree Date et heure d'entrée au format 'Y-m-d H:i:s'
 * @param string $dateSortie Date et heure de sortie au format 'Y-m-d H:i:s'
 * @return float Le montant total à payer
 */
function calculerFacturationParking($dateEntree, $dateSortie) {
    // Tarifs
    $tarifMoins3Heures = 2.0;   // Tarif par heure pour moins de 3 heures
    $tarifEntre3Et24 = 1.5;     // Tarif par heure pour entre 3 heures et 24 heures
    $tarifJournalier = 20.0;    // Tarif fixe pour une journée complète (plus de 24 heures)

    // Convertir les dates en objets DateTime
    $entree = new DateTime($dateEntree);
    $sortie = new DateTime($dateSortie);

    // Vérifier si la date de sortie est après la date d'entrée
    if ($sortie <= $entree) {
        throw new Exception("La date de sortie doit être postérieure à la date d'entrée.");
    }

    // Calculer la durée totale en heures
    $interval = $entree->diff($sortie);
    $totalHeures = ($interval->days * 24) + $interval->h + ($interval->i > 0 ? 1 : 0); // Arrondi à l'heure supérieure

    // Initialiser le coût total
    $montantTotal = 0;

    // Calculer le coût en fonction des paliers
    if ($totalHeures <= 3) {
        // Moins de 3 heures
        $montantTotal = $totalHeures * $tarifMoins3Heures;
    } elseif ($totalHeures <= 24) {
        // Entre 3 heures et 24 heures
        $montantTotal = (3 * $tarifMoins3Heures) + (($totalHeures - 3) * $tarifEntre3Et24);
    } else {
        // Plus de 24 heures
        $joursComplets = floor($totalHeures / 24);
        $heuresRestantes = $totalHeures % 24;

        $montantTotal = ($joursComplets * $tarifJournalier);

        // Ajouter le coût des heures restantes
        if ($heuresRestantes <= 3) {
            $montantTotal += $heuresRestantes * $tarifMoins3Heures;
        } elseif ($heuresRestantes <= 24) {
            $montantTotal += $heuresRestantes * $tarifEntre3Et24;
        }
    }

    return $montantTotal;
}