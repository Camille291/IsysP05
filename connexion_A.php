<?php
session_start();
require_once 'config_A.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $email = strtolower($email);

    $check = $bdd->prepare('SELECT idpersonne, nom, prenom, email, password, token FROM Personne WHERE email = ?');
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();

    if ($row > 0) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (password_verify($password, $data['password'])) {
                $_SESSION['user'] = $data['token'];
                $_SESSION['idpersonne'] = $data['idpersonne'];

                // Redirection vers la page graphique_inshalla.php après la connexion réussie
                header('Location: landing.php');
                die();
            } else {
                header('Location: page_connexion_A.php?login_err=password');
                die();
            }
        } else {
            header('Location: page_connexion_A.php?login_err=email');
            die();
        }
    } else {
        header('Location: page_connexion_A.php?login_err=already');
        die();
    }
} else {
    header('Location: page_connexion_A.php');
    die();
}
?>
