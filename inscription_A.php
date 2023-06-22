<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sign up</title>
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
        <a href="index_A.html" class="logo"><span>P</span>roject <span>IsysP05</span></a>
        <div class="toggleMenu" onclick="toggleMenu();"></div>
        <ul class="navbar">
            <li><a href="index_A.html#NotreProduit" onclick="toggleMenu();">Our Product</a></li>
            <li><a href="index_A.html#News" onclick="toggleMenu();">News & Media</a></li>
            <li><a href="index_A.html#DocumentsOfficiels" onclick="toggleMenu();">Official Documents</a></li>
            <li><a href="index_A.html#AvisRecommandations" onclick="toggleMenu();">Reviews & Recommendations</a></li>
            <li><a href="index_A.html#Nous6" onclick="toggleMenu();">Contacts</a></li>
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
                    echo "<div class='error-message'>Error : This user already exists !</div>";
                } elseif ($err === 'password') {
                    echo "<div class='error-message'>Error : Passwords do not match !</div>";
                } elseif ($err === 'email') {
                    echo "<div class='error-message'>Error : The email address is not valid !</div>";
                } elseif ($err === 'email_length') {
                    echo "<div class='error-message'>Error : The email address exceeds the allowed character limit !</div>";
                } elseif ($err === 'prenom_length') {
                    echo "<div class='error-message'>Error : The first name exceeds the allowed character limit !</div>";
                } elseif ($err === 'nom_length') {
                    echo "<div class='error-message'>Error : The name exceeds the allowed character limit !</div>";
                } elseif ($err === 'no_card_available') {
                    echo "<div class='error-message'>Error : No card is available for registration !</div>";
                } elseif ($err === 'success') {
                    echo "<div class='success-message'>Successful registration !</div>";
                }
            }
            ?>

        <form method="post" action="inscription_traitement_A.php">
            <h2 class="text-center">Sign up</h2>
            <div class="form-group">
                <input type="text" name="nom" class="form-control" placeholder="Name" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="text" name="prenom" class="form-control" placeholder="Surname" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="date" name="date_de_naissance" class="form-control" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="password" name="password_retype" class="form-control" placeholder="Confirm password" required="required" autocomplete="off" />
            </div>
            <div class="form-group">
            <button type="submit" class="btn">Sign up</button>
            </div>
        </form>
        <p class="text-center"><a href="connexion_A.php">Already registered ? Log in here</a></p>
    </div>
    </section>

</body>

</html>
