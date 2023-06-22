<?php 
    session_start();
    require_once 'config_A.php'; // ajout connexion bdd 
   // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:page_connexion_A.php');
        die();
    }

    // On récupere les données de l'utilisateur
    $req = $bdd->prepare('SELECT * FROM Personne WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();
   
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title> Password </title>
        <link rel="stylesheet" href="style.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"rel="stylesheet"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="NoS1gnal"/>

    </head>
  <body>
        <header>
            <a href="landing.php" class="logo"><span>P</span>roject <span>IsysP05</span></a>
            <ul class="navbar">
            <div class="toggleMenu" onclick="toggleMenu();"></div>
            <a href="deconnexion_A.php" class="btn_Compte">Logout</a> 
            </ul>

        </header>

    <section>

        <div class="container">
            <div class="col-md-12">
                <?php 
                        if(isset($_GET['err'])){
                            $err = htmlspecialchars($_GET['err']);
                            switch($err){
                                case 'current_password':
                                    echo "<div class='alert alert-danger'>The current password is incorrect</div>";
                                break;

                                case 'success_password':
                                    echo "<div class='alert alert-success'>The password has been changed successfully ! </div>";
                                break; 
                            }
                        }
                    ?>
            </div>
        </div>

        <div>
        <form action="layouts/change_password.php" method="POST">
            <h2 class="text-center">Changer le mot de passe</h2>
            <div class="form-group">   
                <input type="password" id="current_password" name="current_password" class="form-control" required/>
            </div>
            <div class="form-group">
                <input type="password" id="new_password" name="new_password" class="form-control" required/>
            </div>
            <div class="form-group">
                <input type="password" id="new_password_retype" name="new_password_retype" class="form-control" required/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Sauvegarder</button>
            </div>
        </form>
        </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </section>
  </body>
</html>