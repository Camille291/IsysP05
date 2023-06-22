<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure le fichier de configuration de la base de données
require_once 'config.php';

// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['idpersonne'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit;
}

// On récupere les données de l'utilisateur
$req = $bdd->prepare('SELECT * FROM Personne WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();

// Récupérer l'ID de la personne connectée
$idpersonne = $_SESSION['idpersonne'];

// Récupérer les données de poids pour la personne connectée depuis la base de données triées par date croissante
$sqlPoids = "SELECT date_prise, poids FROM Poids WHERE idutilisateurs = $idpersonne ORDER BY date_prise ASC";
$resultPoids = $bdd->query($sqlPoids);

// Récupérer les données de taille pour la personne connectée depuis la base de données triées par date croissante
$sqlTaille = "SELECT date_prise, taille FROM Taille WHERE idutilisateurs = $idpersonne ORDER BY date_prise ASC";
$resultTaille = $bdd->query($sqlTaille);


// Récupérer les données de frequence_cardiaque pour la personne connectée depuis la base de données triées par date croissante
$sqlfrequence_cardiaque = "SELECT date_prise, frequence_cardiaque FROM Stethoscope WHERE idutilisateurs = $idpersonne ORDER BY date_prise ASC";
$resultfrequence_cardiaque = $bdd->query($sqlfrequence_cardiaque);


// Récupérer les données de température pour la personne connectée depuis la base de données triées par date croissante
$sqlTemperature = "SELECT date_prise, temperature FROM Thermometre WHERE idutilisateurs = $idpersonne ORDER BY date_prise ASC";
$resultTemperature = $bdd->query($sqlTemperature);


// Récupérer les données de tension artérielle pour la personne connectée depuis la base de données triées par date croissante
$sqlTension = "SELECT date_prise, systole, diastole FROM Tensiometre WHERE idutilisateurs = $idpersonne ORDER BY date_prise ASC";
$resultTension = $bdd->query($sqlTension);

// Tableaux pour stocker les données du graphique
$datesPoids = [];
$poids = [];
$datesTaille = [];
$taille = [];
$datesTemperature = [];
$temperature = [];
$datesfrequence_cardiaque = [];
$frequence_cardiaque= [];
$datesTension = [];
$systole = [];
$diastole = [];

// Parcourir les résultats de la requête de poids et récupérer les données
while ($rowPoids = $resultPoids->fetch(PDO::FETCH_ASSOC)) {
    $datesPoids[] = $rowPoids['date_prise'];
    $poids[] = $rowPoids['poids'];
}

// Parcourir les résultats de la requête de taille et récupérer les données
while ($rowTaille = $resultTaille->fetch(PDO::FETCH_ASSOC)) {
    $datesTaille[] = $rowTaille['date_prise'];
    $taille[] = $rowTaille['taille'];
}

// Parcourir les résultats de la requête de température et récupérer les données
while ($rowTemperature = $resultTemperature->fetch(PDO::FETCH_ASSOC)) {
    $datesTemperature[] = $rowTemperature['date_prise'];
    $temperature[] = $rowTemperature['temperature'];
}

// Parcourir les résultats de la requête de frequence_cardiaque et récupérer les données
while ($rowfrequence_cardiaque = $resultfrequence_cardiaque->fetch(PDO::FETCH_ASSOC)) {
    $datesfrequence_cardiaque[] = $rowfrequence_cardiaque['date_prise'];
    $frequence_cardiaque[] = $rowfrequence_cardiaque['frequence_cardiaque'];

}

// Parcourir les résultats de la requête de tension artérielle et récupérer les données
while ($rowTension = $resultTension->fetch(PDO::FETCH_ASSOC)) {
    $datesTension[] = $rowTension['date_prise'];
    $systole[] = floatval($rowTension['systole']); // Convertir en nombre
    $diastole[] = floatval($rowTension['diastole']); // Convertir en nombre
}



// Récupérer la dernière valeur de poids pour la personne connectée depuis la base de données
$sqlLastPoids = "SELECT poids, date_prise FROM Poids WHERE idutilisateurs = $idpersonne ORDER BY date_prise DESC LIMIT 1";
$resultLastPoids = $bdd->query($sqlLastPoids);
$lastPoidsRow = $resultLastPoids->fetch(PDO::FETCH_ASSOC);
$lastPoids = $lastPoidsRow['poids'];
$lastPoidsDate = $lastPoidsRow['date_prise'];

// Récupérer la dernière valeur de taille pour la personne connectée depuis la base de données
$sqlLastTaille = "SELECT taille, date_prise FROM Taille WHERE idutilisateurs = $idpersonne ORDER BY date_prise DESC LIMIT 1";
$resultLastTaille = $bdd->query($sqlLastTaille);
$lastTailleRow = $resultLastTaille->fetch(PDO::FETCH_ASSOC);
$lastTaille = $lastTailleRow['taille'];
$lastTailleDate = $lastTailleRow['date_prise'];


// Récupérer la dernière valeur de bpm pour la personne connectée depuis la base de données
$sqlLastfrequence_cardiaque = "SELECT frequence_cardiaque, date_prise FROM Stethoscope WHERE idutilisateurs = $idpersonne ORDER BY date_prise DESC LIMIT 1";
$resultLastfrequence_cardiaque = $bdd->query($sqlLastfrequence_cardiaque);
$lastfrequence_cardiaqueRow = $resultLastfrequence_cardiaque->fetch(PDO::FETCH_ASSOC);
$lastfrequence_cardiaque = $lastfrequence_cardiaqueRow['frequence_cardiaque'];
$lastfrequence_cardiaqueDate = $lastfrequence_cardiaqueRow['date_prise'];



// Récupérer la dernière valeur de taille pour la personne connectée depuis la base de données
$sqlLasttemperature = "SELECT temperature, date_prise FROM Thermometre WHERE idutilisateurs = $idpersonne ORDER BY date_prise DESC LIMIT 1";
$resultLasttemperature = $bdd->query($sqlLasttemperature);
$lasttemperatureRow = $resultLasttemperature->fetch(PDO::FETCH_ASSOC);
$lasttemperature = $lasttemperatureRow['temperature'];
$lasttemperatureDate = $lasttemperatureRow['date_prise'];


// Récupérer la dernière valeur de taille pour la personne connectée depuis la base de données
$sqlLastTension = "SELECT systole, diastole, date_prise FROM Tensiometre WHERE idutilisateurs = $idpersonne ORDER BY date_prise DESC LIMIT 1";
$resultLastTension = $bdd->query($sqlLastTension);
$lastTensionRow = $resultLastTension->fetch(PDO::FETCH_ASSOC);
$lastsystole = $lastTensionRow['systole'];
$lastdiastole= $lastTensionRow['diastole'];
$lastTensionDate = $lastTensionRow['date_prise'];


// Calculer l'IMC en utilisant la dernière valeur de poids et de taille
$imc = 0;
if ($lastPoids > 0 && $lastTaille > 0) {
    $imc = $lastPoids / (($lastTaille / 100) * ($lastTaille / 100));
}


// Fermer la connexion à la base de données
$bdd = null;
?>

<?php
// Calcul de la position du curseur
$imcMin = 0; // Valeur minimale de l'IMC
$imcMax = 60; // Valeur maximale de l'IMC

// Supposons que $imc soit la valeur de l'IMC pour lequel vous voulez positionner le curseur
$positionCurseur = ($imc - $imcMin) / ($imcMax - $imcMin) * 100; 
$imc = round($imc, 2); // Arrondir l'IMC à 0.01 près
// Convertit l'IMC en pourcentage de la largeur du graphique

// Affichage du curseur avec la position calculée
?>





<!doctype html>
<html lang="fr">

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="utf-8">
    <title>Mon compte</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NoS1gnal">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style>

        .IMC_blanc {
            background-color: #FFFFFF;
            padding: 20px;
        }

        .Poids_blanc {
            background-color: #FFFFFF;
            padding: 20px;
            margin-top: 100px; /* Ajout d'une marge supérieure pour créer un espace entre l'en-tête et la section */
            margin-bottom: 50px;
        }

        .Taille_blanc {
            background-color: #FFFFFF;
            padding: 20px;
            margin-top: 100px; /* Ajout d'une marge supérieure pour créer un espace entre l'en-tête et la section */
            margin-bottom: 50px;
        }

        .Tension_blanc {
                    background-color: #FFFFFF;
                    padding: 20px;
                    margin-top: 100px; /* Ajout d'une marge supérieure pour créer un espace entre l'en-tête et la section */
                    margin-bottom: 50px;
                }

        .Temperature_blanc {
            background-color: #FFFFFF;
            padding: 20px;
            margin-top: 100px; /* Ajout d'une marge supérieure pour créer un espace entre l'en-tête et la section */
            margin-bottom: 50px;
        }

        .frequence_cardiaque_blanc {
            background-color: #FFFFFF;
            padding: 20px;
            margin-top: 100px; /* Ajout d'une marge supérieure pour créer un espace entre l'en-tête et la section */
            margin-bottom: 50px;
        }

        .graphique-container {
            display: flex;
            width: 100%;
            margin-bottom: 70px;
            margin-top: 100px; /* Ajuster cette valeur selon vos besoins */
        }

        .graphique {
            flex: 1;
            height: 500px;
            background-color: #FFFFFF;
            overflow: hidden;
        }

        .login-form {
            width: 340px;
            margin: 50px auto;
            background-color: #fff;
            border: 1px solid #f3f3f3;
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

        .text-centerbis {
            font-size: 4em;
            color: #fb911f;
            text-align: center;
            margin-bottom: 20px;
        }

        .text-centerbis a:hover {
            text-decoration: underline;
        }

        .text-center {
            text-align: center;
            margin-bottom: 20px;
        }

        .text-center a {
            text-decoration: none;
            color: #4285f4;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
        }

        body {
            justify-content: center;
            align-items: center;
            background-image: url(./Images/pageheader-banner.png);
            background-size: cover;
            margin: 40; /* Supprimer les marges par défaut du body */
            margin-top: 60px; /* Ajout d'une marge supérieure pour éviter que le contenu soit caché par l'en-tête */
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

        .imc-frise {
          position: relative;
          height: 40px;
          background-color: #eee;
          margin-top: 20px;
        }

          .imc-frise div {
            position: absolute;
            height: 100%;
            text-align: center;
            font-size: 12px;
            line-height: 20px;
            color: #000; /* Couleur du texte */
          }

          .zone-insuffisance {
            height: 20px;
            left: 0;
            width: 25%;
            background-color: #FF0000;
            color: #fff;
          }

          .zone-normal {
            height: 20px;
            left: 25%;
            width: 25%;
            background-color: #4CD555;
            color: #fff;
          }

          .zone-surpoids {
            height: 20px;
            left: 50%;
            width: 25%;
            background-color: #EEEE4D;
            color: #fff;

          }

          .zone-obesite {
            height: 20px;
            left: 75%;
            width: 25%;
            background-color: #FF8000;
            color: #fff;
          }

          .curseur {
            position: absolute;
            top: -5px;
            width: 10px;
            height: 30px;
            background-color: #000;
            border-radius: 5px; /* Ajout d'une bordure arrondie */
          }

        .box {
            display: inline-block;
            width: 18%;
            background-color: white;
            border: 1px solid gray;
            padding: 10px;
            margin: 5px;
            text-align: center;
        }

        /* Style pour le texte en gros et orange */
        h3 {
            font-size: 30px;
            color: #000;
        }

        .black {
            font-size: 20px;
            color: black;
        }
        
        .gris {
            font-size: 12px;
            color: gray;
        }

        .orange{
            font-size: 40px;
            color: orange;

        }




        /* Style pour les cadres avec fond blanc */
        .contenu {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        /* Style pour l'image en arrière-plan */
        section#Nous {
            background-image: url("./Images/pageheader-banner2.png");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .annotation-label {
            position: absolute;
            font-size: 12px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 4px;
            border-radius: 4px;
        }

    </style>
</head>

<body>
    <header>
        <a href="" class="logo"><span>P</span>rojet <span>IsysP05</span></a>
        <div class="toggleMenu" onclick="toggleMenu();"></div>
        <ul class="navbar">
            <li><a href="#Temperature_blanc" onclick="toggleMenu();">Température</a></li>
            <li><a href="#Tension_blanc" onclick="toggleMenu();">Tension</a></li>
            <li><a href="#BPM_blanc" onclick="toggleMenu();">Fréquence Cardiaque</a></li>
            <li><a href="#Poids_blanc" onclick="toggleMenu();">Poids</a></li>
            <li><a href="#Taille_blanc" onclick="toggleMenu();">Taille</a></li>
            <a href="IsysP05_achat.html" class="btn_Compte">Boutique</a>
            <a href="deconnexion.php" class="btn_Compte">Déconnexion</a>
            <a href="landing.php" class="btn_Langue">Fr</a>
            <a href="landing_A.php" class="btn_Langue">En</a>
        </ul>

    </header>
         <section class="Nous" id="Nous">
            <br><br>
            <div class="text">
                <h3 class="p-5">Bonjour <?php echo $data['prenom']; ?> !</h3>
            </div>
            <br><br>
            <div class="IMC_blanc" id="IMC_blanc" >
                <div class="text" >
                    <h3> IMC: <?php echo $imc; ?> </h3>
                </div>
                <div class="imc-frise">
                    <div class="zone-insuffisance">
                        <h3 class="black">Insuffisance pondérale</h3>
                    </div>
                    <div class="zone-normal">
                        <h3 class="black">Poids normal</h3>
                    </div>
                    <div class="zone-surpoids">
                        <h3 class="black">Surpoids</h3>
                    </div>
                    <div class="zone-obesite">
                        <h3 class="black">Obésité</h3>
                    </div>
                    <div class="curseur" style="left: <?php echo $positionCurseur; ?>%"></div>
                </div>
            </div>
            <div class="contenu">
                <div class="box">
                    <div class="text">
                        <h3 >Dernier Poids:</h3>
                        <br><br>
                        <h3 class="orange"> <?php echo $lastPoids; ?> kg </h3>
                        <br><br>
                        <h3 class="gris"> datant du <?php echo $lastPoidsDate; ?> </h3>
                    </div>
                </div>

                <div class="box">
                    <div class="text">
                        <h3>Dernière Taille:</h3>
                        <br><br>
                        <h3 class="orange"> <?php echo $lastTaille; ?> cm</h3>
                        <br><br>
                        <h3 class="gris"> datant du <?php echo $lastTailleDate; ?> </h3>
                    </div>
                </div>
                <div class="box">
                    <div class="text">
                        <h3>Dernière Fréquence Cardiaque: </h3>
                        <h3 class="orange"> <?php echo $lastfrequence_cardiaque; ?> BPM </h3>
                        <br><br>
                        <h3 class="gris"> datant du <?php echo $lastfrequence_cardiaqueDate; ?> </h3>

                    </div>
                </div>
            </div>
            <div class="contenu">
                <div class="box">
                    <div class="text">
                        <h3>Dernière Température: </h3>
                        <h3 class="orange"> <?php echo $lasttemperature; ?> °C</h3>
                        <br><br>
                        <h3 class="gris"> datant du <?php echo $lasttemperatureDate; ?> </h3>
                    </div>
                </div>

                <div class="box">
                    <div class="text">
                        <h3>Dernière Tension: </h3>
                        <h3 class="orange"> <?php echo $lastsystole; ?> mmHg</h3>
                        <h3 class="orange"> <?php echo $lastdiastole; ?> mmHg</h3>
                        <br><br>
                        <h3 class="gris"> datant du <?php echo $lastTensionDate; ?> </h3>
                    </div>
                </div>
            </div>
        </section>

        <section class="Temperature_blanc" id="Temperature_blanc" >
            <div class="graphique-container">
                <div class="graphique">
                    <canvas id="graphiqueTemperature"></canvas>
                </div>
                <div class="container">
                    <h2 class="text-centerbis">Température</h2>
                    <div class="login-form">
                        <div class="titre-container">
                            <h2 class="text-center">Ajouter une température</h2>
                        </div>
                        <form method="post" action="temperature_traitement.php">
                            <ul>Si la prise de température a été réalisée par voie:
                                <br><br>
                                <li>anale: ne rien ajouter au résultat </li>
                                <li>buccale: ajouter 0,6 °C </li>
                                <li>axillaire: ajouter 0,7 °C </li>
                            </ul>
                            <br><br>
                            <div class="form-group">
                                <input type="temperature" name="temperature" class="form-control" placeholder="Température en °C" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="date" name="date_prise" class="form-control" required="required" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>


        <section class="Tension_blanc" id="Tension_blanc">
            <div class="graphique-container">
                <div class="container">
                    <h2 class="text-centerbis">Tension</h2>
                    <div class="login-form">
                        <div class="titre-container">
                            <h2 class="text-center">Ajouter une tension</h2>
                        </div>
                        <form method="post" action="tension_traitement.php">
                            <div class="form-group">
                                <input type="systole" name="systole" class="form-control" placeholder="Systole en mmHg" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="diastole" name="diastole" class="form-control" placeholder="Diastole en mmHg" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="date" name="date_prise" class="form-control" required="required" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="graphique">
                     <canvas id="graphiqueTension"></canvas>
                </div>
            </div>
        </section>

        <section class="frequence_cardiaque_blanc" id="frequence_cardiaque_blanc" >
            <div class="graphique-container">
                <div class="graphique">
                    <canvas id="graphiquefrequence_cardiaque"></canvas>
                </div>
                <div class="container">
                    <h2 class="text-centerbis">BPM</h2>
                    <div class="login-form">
                        <div class="titre-container">
                            <h2 class="text-center">Ajouter une fréquence cardiaque</h2>
                        </div>
                        <form method="post" action="frequence_cardiaque_traitement.php">
                            <div class="form-group">
                                <input type="frequence_cardiaque" name="frequence_cardiaque" class="form-control" placeholder="Fréquence cardiaque en BPM" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="date" name="date_prise" class="form-control" required="required" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="Poids_blanc" id="Poids_blanc" >
            <div class="graphique-container">
                <div class="container">
                    <h2 class="text-centerbis">Poids</h2>
                    <div class="login-form">
                        <div class="titre-container">
                            <h2 class="text-center">Ajouter un poids</h2>
                        </div>
                        <form method="post" action="poids_traitement.php">
                            <div class="form-group">
                                <input type="poids" name="poids" class="form-control" placeholder="Poids en kg" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="date" name="date_prise" class="form-control" required="required" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="graphique">
                    <canvas id="graphiquePoids"></canvas>
                </div>
            </div>
        </section>

        <section class="Taille_blanc" id="Taille_blanc">
            <div class="graphique-container">
                <div class="graphique">
                    <canvas id="graphiqueTaille"></canvas>
                </div>
                <div class="container">
                    <h2 class="text-centerbis">Taille</h2>
                    <div class="login-form">
                        <div class="titre-container">
                            <h2 class="text-center">Ajouter une taille</h2>
                        </div>
                        <form method="post" action="taille_traitement.php">
                            <div class="form-group">
                                <input type="taille" name="taille" class="form-control" placeholder="Taille en cm" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="date" name="date_prise" class="form-control" required="required" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    <script>
        // Configuration du graphique pour les poids
        var ctxPoids = document.getElementById('graphiquePoids').getContext('2d');
        var graphiquePoids = new Chart(ctxPoids, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($datesPoids); ?>,
                datasets: [{
                    label: 'Poids',
                    data: <?php echo json_encode($poids); ?>,
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


    <script>
        // Configuration du graphique pour les tailles
        var ctxTaille = document.getElementById('graphiqueTaille').getContext('2d');
        var graphiqueTaille = new Chart(ctxTaille, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($datesTaille); ?>,
                datasets: [{
                    label: 'Taille',
                    data: <?php echo json_encode($taille); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.0.2"></script>

    <script>
        // Configuration du graphique pour les températures
        var ctxTemperature = document.getElementById('graphiqueTemperature').getContext('2d');
        var graphiqueTemperature = new Chart(ctxTemperature, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($datesTemperature); ?>,
                datasets: [{
                    label: 'Température',
                    data: <?php echo json_encode($temperature); ?>,
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 34 // Ajout de la valeur minimale
                    }
                },
                plugins: {
                    annotation: {
                        annotations: [{
                            type: 'box',
                            id: 'normal-temperature',
                            drawTime: 'beforeDatasetsDraw',
                            yScaleID: 'y',
                            yMin: 36.1,
                            yMax: 37.8,
                            backgroundColor: 'rgba(144, 238, 144, 0.2)',
                            borderColor: 'rgba(144, 238, 144, 1)',
                            borderWidth: 1,
                            label: {
                                content: 'Température normale',
                                enabled: true,
                                position: 'center',
                                backgroundColor: 'rgba(144, 238, 144, 0.5)',
                                font: {
                                    size: 12
                                }
                            }
                        }, {
                            type: 'box',
                            id: 'fever',
                            drawTime: 'beforeDatasetsDraw',
                            yScaleID: 'y',
                            yMin: 37.8,
                            yMax: 38.5,
                            backgroundColor: 'rgba(255, 255, 0, 0.2)',
                            borderColor: 'rgba(255, 255, 0, 1)',
                            borderWidth: 1,
                            label: {
                                content: 'Fièvre',
                                enabled: true,
                                position: 'center',
                                backgroundColor: 'rgba(255, 255, 0, 0.5)',
                                font: {
                                    size: 12
                                }
                            }
                        }, {
                            type: 'box',
                            id: 'high-fever',
                            drawTime: 'beforeDatasetsDraw',
                            yScaleID: 'y',
                            yMin: 38.5,
                            yMax: Number.POSITIVE_INFINITY,
                            backgroundColor: 'rgba(255, 0, 0, 0.2)',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 1,
                            label: {
                                content: 'Fièvre élevée',
                                enabled: true,
                                position: 'center',
                                backgroundColor: 'rgba(255, 0, 0, 0.5)',
                                font: {
                                    size: 12
                                }
                            }
                        }]
                    }
                }

            }
        });
    </script>
    
   <script>
        // Configuration du graphique pour les frequence_cardiaque
        var ctxfrequence_cardiaque = document.getElementById('graphiquefrequence_cardiaque').getContext('2d');
        var graphiquefrequence_cardiaque = new Chart(ctxfrequence_cardiaque, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($datesfrequence_cardiaque); ?>,
                datasets: [{
                    label: 'Fréquence cardiaque',
                    data: <?php echo json_encode($frequence_cardiaque); ?>,
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    annotation: {
                        annotations: [
                            {
                                type: 'box',
                                drawTime: 'beforeDatasetsDraw',
                                yScaleID: 'y',
                                yMin: 100,
                                yMax: 160,
                                backgroundColor: 'rgba(255, 255, 0, 0.2)',
                                borderColor: 'rgba(255, 255, 0, 1)',
                                borderWidth: 1,
                                label: {
                                    content: 'Zone jaune',
                                    enabled: true,
                                    position: 'center',
                                    backgroundColor: 'rgba(255, 255, 0, 0.5)',
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            {
                                type: 'box',
                                drawTime: 'beforeDatasetsDraw',
                                yScaleID: 'y',
                                yMin: 160,
                                yMax: Infinity,
                                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                                borderColor: 'rgba(255, 0, 0, 1)',
                                borderWidth: 1,
                                label: {
                                    content: 'Zone rouge',
                                    enabled: true,
                                    position: 'center',
                                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        ]
                    }
                }
            }
        });
    </script>

    <script>
        var ctxtension = document.getElementById('graphiqueTension').getContext('2d');
        var graphiqueTension = new Chart(ctxtension, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($datesTension); ?>,
                datasets: [{
                    label: 'Systole',
                    data: <?php echo json_encode($systole); ?>,
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2
                },
                {
                    label: 'Diastole',
                    data: <?php echo json_encode($diastole); ?>,
                    backgroundColor: 'rgba(0, 255, 0, 0.5)',
                    borderColor: 'rgba(0, 255, 0, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10
                        }
                    }
                },
                plugins: {
                    annotation: {
                        annotations: [{
                            type: 'box',
                            drawTime: 'beforeDatasetsDraw',
                            xScaleID: 'x',
                            yScaleID: 'y',
                            xMin: 0,
                            xMax: <?php echo count($datesTension) - 1; ?>,
                            yMin: 159,
                            backgroundColor: 'rgba(255, 0, 0, 0.2)',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 0,
                            label: {
                                content: '159 et plus',
                                enabled: true,
                                position: 'end'
                            }
                        },
                        {
                            type: 'box',
                            drawTime: 'beforeDatasetsDraw',
                            xScaleID: 'x',
                            yScaleID: 'y',
                            xMin: 0,
                            xMax: <?php echo count($datesTension) - 1; ?>,
                            yMin: 139,
                            yMax: 159,
                            backgroundColor: 'rgba(255, 165, 0, 0.2)',
                            borderColor: 'rgba(255, 165, 0, 1)',
                            borderWidth: 0,
                            label: {
                                content: '159 à 139',
                                enabled: true,
                                position: 'end'
                            }
                        },
                        {
                            type: 'box',
                            drawTime: 'beforeDatasetsDraw',
                            xScaleID: 'x',
                            yScaleID: 'y',
                            xMin: 0,
                            xMax: <?php echo count($datesTension) - 1; ?>,
                            yMin: 129,
                            yMax: 139,
                            backgroundColor: 'rgba(255, 255, 0, 0.2)',
                            borderColor: 'rgba(255, 255, 0, 1)',
                            borderWidth: 0,
                            label: {
                                content: '139 à 129',
                                enabled: true,
                                position: 'end'
                            }
                        },
                        {
                            type: 'box',
                            drawTime: 'beforeDatasetsDraw',
                            xScaleID: 'x',
                            yScaleID: 'y',
                            xMin: 0,
                            xMax: <?php echo count($datesTension) - 1; ?>,
                            yMin: 99,
                            yMax: 129,
                            backgroundColor: 'rgba(0, 128, 0, 0.2)',
                            borderColor: 'rgba(0, 128, 0, 1)',
                            borderWidth: 0,
                            label: {
                                content: '129 à 99',
                                enabled: true,
                                position: 'end'
                            }
                        },
                        {
                            type: 'box',
                            drawTime: 'beforeDatasetsDraw',
                            xScaleID: 'x',
                            yScaleID: 'y',
                            xMin: 0,
                            xMax: <?php echo count($datesTension) - 1; ?>,
                            yMin: 89,
                            yMax: 99,
                            backgroundColor: 'rgba(255, 165, 0, 0.2)',
                            borderColor: 'rgba(255, 165, 0, 1)',
                            borderWidth: 0,
                            label: {
                                content: '99 à 89',
                                enabled: true,
                                position: 'end'
                            }
                        },
                        {
                            type: 'box',
                            drawTime: 'beforeDatasetsDraw',
                            xScaleID: 'x',
                            yScaleID: 'y',
                            xMin: 0,
                            xMax: <?php echo count($datesTension) - 1; ?>,
                            yMin: 84,
                            yMax: 89,
                            backgroundColor: 'rgba(255, 255, 0, 0.2)',
                            borderColor: 'rgba(255, 255, 0, 1)',
                            borderWidth: 0,
                            label: {
                                content: '89 à 84',
                                enabled: true,
                                position: 'end'
                            }
                        },
                        {
                            type: 'box',
                            drawTime: 'beforeDatasetsDraw',
                            xScaleID: 'x',
                            yScaleID: 'y',
                            xMin: 0,
                            xMax: <?php echo count($datesTension) - 1; ?>,
                            yMin: 0,
                            yMax: 84,
                            backgroundColor: 'rgba(144, 238, 144, 0.2)',
                            borderColor: 'rgba(144, 238, 144, 1)',
                            borderWidth: 0,
                            label: {
                                content: '84 et moins',
                                enabled: true,
                                position: 'end'
                            }
                        }]
                    }
                }
            }
        });
    </script>

</body>

</html>

