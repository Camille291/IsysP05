<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config_A.php'; // On inclut la connexion à la base de données

// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['idpersonne'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion_A.php");
    exit;
}

// Si les variables existent et ne sont pas vides
if (
    !empty($_POST['taille']) &&
    !empty($_POST['date_prise'])
) {
    // Prise de taille et date
    $taille = htmlspecialchars($_POST['taille']);
    $date_prise = htmlspecialchars($_POST['date_prise']);

    // Récupérer l'ID de la personne connectée
    $idpersonne = $_SESSION['idpersonne'];

    // Obtenir l'heure actuelle
    $heure_prise = date('H:i:s');

    // Combiner la date et l'heure
    $date_time = $date_prise . ' ' . $heure_prise;

    // Insérer les données dans la table Taille
    $insert = $bdd->prepare('INSERT INTO Taille (taille, date_prise, idutilisateurs) VALUES (:taille, :date_time, :idpersonne)');
    $insert->execute([
        'taille' => $taille,
        'date_time' => $date_time,
        'idpersonne' => $idpersonne
    ]);
    header('Location: landing.php?reg_err=success');
    die();
}
?>
