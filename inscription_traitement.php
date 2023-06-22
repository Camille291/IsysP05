<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php'; // On inclut la connexion à la base de données

// Si les variables existent et ne sont pas vides
if (
    !empty($_POST['nom']) &&
    !empty($_POST['prenom']) &&
    !empty($_POST['date_de_naissance']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password']) &&
    !empty($_POST['password_retype'])
) {
    // Patch XSS
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $date_de_naissance = htmlspecialchars($_POST['date_de_naissance']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_retype = htmlspecialchars($_POST['password_retype']);

    // On vérifie si l'utilisateur existe
    $check = $bdd->prepare('SELECT nom, prenom, email, password FROM Personne WHERE email = ?');
    $check->execute([$email]);
    $data = $check->fetch();
    $row = $check->rowCount();

    $email = strtolower($email); // On transforme toutes les lettres majuscules en minuscules pour éviter les doublons

    // Si la requête renvoie un 0, alors l'utilisateur n'existe pas
    if ($row == 0) {
        if (strlen($nom) <= 100) { // On vérifie que la longueur du nom <= 100
            if (strlen($prenom) <= 100) { // On vérifie que la longueur du prénom <= 100
                if (strlen($email) <= 100) { // On vérifie que la longueur de l'email <= 100
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Si l'email est de la bonne forme
                        if ($password === $password_retype) { // Si les deux mots de passe saisis sont identiques
                            // Hash du mot de passe
                            $password_hash = password_hash($password, PASSWORD_DEFAULT);

                            // Récupérer tous les ID de carte existants
                            $existingCardIds = [];
                            $query = $bdd->query('SELECT idcarte FROM Carte');
                            while ($row = $query->fetch()) {
                                $existingCardIds[] = $row['idcarte'];
                            }

                            // Récupérer les ID de cartes déjà attribués à des utilisateurs
                            $usedCardIds = [];
                            $queryUsed = $bdd->query('SELECT idcarte FROM Utilisateur WHERE idcarte IS NOT NULL');
                            while ($row = $queryUsed->fetch()) {
                                $usedCardIds[] = $row['idcarte'];
                            }

                            // Trouver les ID de cartes disponibles
                            $availableCardIds = array_diff($existingCardIds, $usedCardIds);

                            // Vérifier s'il y a des cartes disponibles
                            if (count($availableCardIds) == 0) {
                                header('Location: inscription.php?reg_err=no_card_available');
                                die();
                            }

                            // Sélectionner un ID de carte aléatoire parmi les cartes disponibles
                            $randomCardId = array_rand($availableCardIds);

                            // Insérer l'utilisateur avec l'ID de carte attribué
                            $insert = $bdd->prepare('INSERT INTO Personne(nom, prenom, email, password, token) VALUES(:nom, :prenom, :email, :password, :token)');
                            $insert->execute([
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'email' => $email,
                                'password' => $password_hash,
                                'token' => bin2hex(openssl_random_pseudo_bytes(64))
                            ]);

                            // Récupération de l'identifiant généré
                            $idpersonne = $bdd->lastInsertId();

                            // Insérer l'utilisateur dans la table Utilisateur avec l'ID de carte attribué
                            $insertUtilisateur = $bdd->prepare('INSERT INTO Utilisateur(date_de_naissance, idcarte, idmedecin, idpersonne) VALUES(:date_de_naissance, :idcarte, :idmedecin, :idpersonne)');
                            $insertUtilisateur->execute([
                                'date_de_naissance' => $date_de_naissance,
                                'idcarte' => $availableCardIds[$randomCardId],
                                'idmedecin' => NULL,
                                'idpersonne' => $idpersonne
                            ]);

                            header('Location: inscription.php?reg_err=success');
                            die();
                        } else {
                            header('Location: inscription.php?reg_err=password');
                            die();
                        }
                    } else {
                        header('Location: inscription.php?reg_err=email');
                        die();
                    }
                } else {
                    header('Location: inscription.php?reg_err=email_length');
                    die();
                }
            } else {
                header('Location: inscription.php?reg_err=prenom_length');
                die();
            }
        } else {
            header('Location: inscription.php?reg_err=nom_length');
            die();
        }
    } else {
        header('Location: inscription.php?reg_err=already');
        die();
    }
} else {
    header('Location: inscription.php');
    die();
}
?>
