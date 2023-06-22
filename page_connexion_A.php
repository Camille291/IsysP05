<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Connection</title>
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

            <a href="page_connexion.php" class="btn_Langue">Fr</a>
            <a href="page_connexion_A.php" class="btn_Langue">En</a>
        </ul>

  </header>

  <section class="Compte" id="Compte">
    <div class="login-form">
      <?php 

      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);

      if(isset($_GET['login_err']))
      {
          $err = htmlspecialchars($_GET['login_err']);

          switch($err)
          {
              case 'password':
              ?>
                <div class="alert alert-danger">
                  <strong>Error</strong> wrong password
                </div>
              <?php
              break;

              case 'email':
              ?>
                <div class="alert alert-danger">
                  <strong>Error</strong> wrong email
                </div>
              <?php
              break;

              case 'already':
              ?>
                <div class="alert alert-danger">
                  <strong>Error</strong> non existing account
                </div>
              <?php
              break;
          }
      }
      ?>
      <form action="connexion_A.php" method="post">
        <h2 class="text-center">Connection</h2>
        <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Password" required="required" autocomplete="off">
        </div>
        <div class="form-group">
          <button type="submit" class="btn">Connection</button>
        </div>
      </form>
      <p class="text-center"><a href="inscription_A.php">Sign up</a></p>
      <p class="text-center"><a href="mp_A.php">Forgotten password</a></p>
    </div>
  </section>
</body>

</html>