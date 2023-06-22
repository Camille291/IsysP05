<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php'; // On inclut la connexion à la base de données

// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['idpersonne'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit;
}

// Si les variables existent et ne sont pas vides
if (
    !empty($_POST['poids']) &&
    !empty($_POST['date_prise'])
) {
    // Prise de poids et date
    $poids = htmlspecialchars($_POST['poids']);
    $date_prise = htmlspecialchars($_POST['date_prise']);

    // Récupérer l'ID de la personne connectée
    $idpersonne = $_SESSION['idpersonne'];

    // Obtenir l'heure actuelle
    $heure_prise = date('H:i:s');

    // Combiner la date et l'heure
    $date_time = $date_prise . ' ' . $heure_prise;

    // Insérer les données dans la table Poids
    $insert = $bdd->prepare('INSERT INTO Poids (poids, date_prise, idutilisateurs) VALUES (:poids, :date_time, :idpersonne)');
    $insert->execute([
        'poids' => $poids,
        'date_time' => $date_time,
        'idpersonne' => $idpersonne
    ]);
    header('Location: landing.php?reg_err=success');
    die();
}
?>
