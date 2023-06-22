<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    .login-form {
          width: 340px;
          margin: 50px auto;
          background-color: #fff;
          box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
          padding: 30px;
        }

        .login-form h2 {
          margin-bottom: 15px;
        }

        .form-group {
          margin-bottom: 15px;
        }

        .form-control {
          width: 100%;
          height: 38px;
          padding: 5px 10px;
          border: 1px solid #ccc;
          border-radius: 2px;
          font-size: 14px;
        }

        .btn {
          width: 100%;
          height: 38px;
          background-color: #fb911f;
          color: #fff;
          border: none;
          border-radius: 2px;
          font-size: 15px;
          font-weight: bold;
          cursor: pointer;
        }

        .btn:hover {
            background: #d87710;
            transition: ease-out;
        }

        .text-center {
          text-align: center;
        }

        .text-center a {
          text-decoration: none;
          color: #4285f4;
        }

        .text-center a:hover {
          text-decoration: underline;
        }

        /* Nouvelles couleurs */
        body {
          background-color: #f7f7f7;
        }

        header {
          background-color: #f3f3f3;
        }

        .btn-primary {
          background-color: #4285f4;
        }

        .btn-primary:hover {
          background-color: #3367d6;
        }

        .alert {
          color: #fff;
          background-color: #ff5722;
          padding: 10px;
          margin-bottom: 15px;
        }

        .alert-danger {
          background-color: #ff5722;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }

        /* Formulaire d'inscription */
        .registration-form {
            max-width: 400px;
            margin: 20px auto;
        }

        .registration-form input[type="text"],
        .registration-form input[type="email"],
        .registration-form input[type="password"],
        .registration-form input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .registration-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .registration-form input[type="submit"]:hover {
            background-color: #45a049;
        }
</style>
</head>

<body>
    <header>
        <a href="index.html" class="logo"><span>P</span>rojet <span>IsysP05</span></a>
        <div class="toggleMenu" onclick="toggleMenu();"></div>
        <ul class="navbar">
            <li><a href="index.html#NotreProduit" onclick="toggleMenu();">Notre Produit</a></li>
            <li><a href="index.html#News" onclick="toggleMenu();">News & Média</a></li>
            <li><a href="index.html#DocumentsOfficiels" onclick="toggleMenu();">Documents Officiels</a></li>
            <li><a href="index.html#AvisRecommandations" onclick="toggleMenu();">Avis & Recommandations</a></li>
            <li><a href="index.html#Nous6" onclick="toggleMenu();">Contacts</a></li>
            <a href="inscription.php" class="btn_Langue">Fr</a>
            <a href="inscription_A.php" class="btn_Langue">En</a>
        </ul>

    </header>

    <section class="Compte" id="Compte">
        <div class="login-form">
            <?php
            if (isset($_GET['reg_err'])) {
                $err = htmlspecialchars($_GET['reg_err']);

                if ($err === 'already') {
                    echo "<div class='error-message'>Erreur : Cet utilisateur existe déjà !</div>";
                } elseif ($err === 'password') {
                    echo "<div class='error-message'>Erreur : Les mots de passe ne correspondent pas !</div>";
                } elseif ($err === 'email') {
                    echo "<div class='error-message'>Erreur : L'adresse email n'est pas valide !</div>";
                } elseif ($err === 'email_length') {
                    echo "<div class='error-message'>Erreur : L'adresse email dépasse la limite de caractères autorisée !</div>";
                } elseif ($err === 'prenom_length') {
                    echo "<div class='error-message'>Erreur : Le prénom dépasse la limite de caractères autorisée !</div>";
                } elseif ($err === 'nom_length') {
                    echo "<div class='error-message'>Erreur : Le nom dépasse la limite de caractères autorisée !</div>";
                } elseif ($err === 'no_card_available') {
                    echo "<div class='error-message'>Erreur : Aucune carte n'est disponible pour l'inscription !</div>";
                } elseif ($err === 'success') {
                    echo "<div class='success-message'>Inscription réussie !</div>";
                }
            }
            ?>

        <form method="post" action="inscription_traitement.php">
            <h2 class="text-center">Inscription</h2>
            <div class="form-group">
                <input type="text" name="nom" class="form-control" placeholder="Nom" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="text" name="prenom" class="form-control" placeholder="Prénom" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="date" name="date_de_naissance" class="form-control" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Adresse email" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="password" name="password_retype" class="form-control" placeholder="Confirmez le mot de passe" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
            <button type="submit" class="btn">S'inscrire</button>
            </div>
        </form>
        <p class="text-center"><a href="connexion.php">Déjà inscrit ? Connectez-vous ici</a></p>
    </div>
    </section>

</body>

</html>
