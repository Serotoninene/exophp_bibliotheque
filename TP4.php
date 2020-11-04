<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<?php

$connexionBdd = mysqli_connect("localhost", "root", "root");
mysqli_set_charset($connexionBdd, "utf8");
$selectionBdd = mysqli_select_db($connexionBdd, "bibliotheque");

$requete = "SELECT l.titre, l.resume, l.annee, l.date_emprunt, a.nom AS nom_auteur, a.prenom, p.intitule, p.code_pays, i.id, lec.nom, lec.adresse, lec.date_naissance FROM livre l INNER JOIN auteur a ON a.id = l.auteur_id INNER JOIN pays p ON a.pays_id = p.id INNER JOIN illustration i ON l.illustration_id = i.id LEFT JOIN lecteur lec ON l.lecteur_id = lec.id";

$resultat = mysqli_query($connexionBdd, $requete);

?>

<body class="container">
    <h1 class="my-5" style="text-align:center">Ma belle bibliothèque</h1>

        <?php

        function sinceWhen($date)
        {
            $then = strtotime($date);
            $now = strtotime(date('F j Y'));
            $difference_nowThen = ($now - $then);
            $jours = $difference_nowThen / (60 * 60 * 24);
            return $jours;
        }


        while ($ligne_resultat = mysqli_fetch_assoc($resultat)) {
    //INSTANCIATION 
            $titre = $ligne_resultat['titre'];
            $annee = $ligne_resultat['annee'];
            $resume = $ligne_resultat['resume'];
            $nom_auteur = $ligne_resultat['nom_auteur'];
            $prenom_auteur = $ligne_resultat['prenom'];
            $resume = $ligne_resultat['resume'];
            $nom_lecteur = $ligne_resultat['nom'];
            $id_couv = $ligne_resultat['id'];
            $date_emprunt = $ligne_resultat['date_emprunt'];
            $code_pays = $ligne_resultat['code_pays'];
            $adresse = $ligne_resultat['adresse'];
            $date_naissance = $ligne_resultat['date_naissance'];
            
            var_dump(strftime($date_naissance));

            echo "<section class='row justify-content-between'>";
            echo "<div class='col-6'>";
    //TITRE
            echo "<h2>$titre - $annee</h2>";
    // AUTEUR
            echo "<p>Ecrit par $prenom_auteur $nom_auteur <img src='https://www.countryflags.io/".$code_pays."/flat/64.png'> </p>";
    // RESUME
            echo "<p>$resume </p>";

    // Lecteur 
            if ($nom_lecteur !== NULL) {

                echo "<p style ='color: red'>";
                // ANNIVERSAIRE OU PAS ANNIVERSAIRE ?  
                if($date_naissance == date('Y-m-d')){
                    echo "BABABABABA";
                }
                echo "Emprunté par $nom_lecteur (qui habite à $adresse et est né le $date_naissance) depuis " . sinceWhen($date_emprunt) . " jours.</p>";
            } else {
                echo "<p style ='color: green'>Disponible<p>";
            }
            echo "</div>";

    // Couverture
            echo "<div class='couverture row col-6 justify-content-center'>";
            echo "<img src='couvertures/" . $id_couv . ".jpg' class='img-fluid'>";
            echo "</div>";

            echo "</section>";
            echo "<br>";
        }
        ?>
</body>

</html>

<?php
/* (5) Fermeture de la connexion au serveur MySQL */
mysqli_close($connexionBdd);
?>