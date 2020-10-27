<?php

if(!isset($arrayGenre)){ $arrayGenre = [];}
try { 
     
    if(isset($_POST["submit"])){
        if(!isset($_POST['origine_id'])){
            $_POST['origine_id'] = NULL;
        }

        // Stocker les genres dans un tableau
        $arrayGenre = [];

        if(!empty($_POST['genre_id'])){
            foreach($_POST['genre_id'] as $selected){
                array_push($arrayGenre,$selected);
            }
        }

        // Stocker les post dans un tableau
        $valeurs = [
            "titre" => $_POST['titre'],
            "description" => $_POST['description'],
            "duree" => $_POST['duree'],
            "age" => $_POST['age'],
            "video" => $_POST['video'],
            "annee" => $_POST['annee'],
            "origine" => $_POST['origine_id'],
            "image" => $_POST['image'],
            "langue" => $_POST['langue'],
            "acteurs" => $_POST['acteurs'],
            "realisateurs" => $_POST['realisateurs'],
            "genres" => $arrayGenre
        ];
        

        var_dump($valeurs);

        echo "</br>";

        // Vérifier que tout les POST sont bien complétés
        if($_POST['titre'] != "" AND $_POST['description'] != "" AND $_POST['duree'] != "" AND $_POST['age'] != "" AND $_POST['video'] != "" AND $_POST['annee'] != "" AND $_POST['origine_id'] != "" AND $_POST['image'] != "" AND $_POST['langue'] != "" AND $_POST['acteurs'] != "" AND $_POST['realisateurs'] != ""){
            
            $prepareFilm = $pdo->prepare('INSERT INTO films (titre, description, duree, age, video, annee, origine_id, image, langue) VALUES (:titre, :description, :duree, :age, :video, :annee, :origine_id, :image, :langue)');
            
            $prepareFilm->execute(array(
                ":titre" => $_POST['titre'],
                ":description" => $_POST['description'],
                ":duree" => $_POST['duree'],
                ":age" => $_POST['age'],
                ":video" => $_POST['video'],
                ":annee" => $_POST['annee'],
                ":origine_id" => $_POST['origine_id'],
                ":image" => $_POST['image'],
                ":image2" => $_POST['image2'],
                ":langue" => $_POST['langue']
            ));
            $idMovie = $pdo->lastInsertId();
            
            $_SESSION['validationFilm'] = "Les données ont bien été ajoutées";

            // REALISATEURS
            $realisateurs = explode(",",$valeurs['realisateurs']);

            for ($c = 0; $c < count($realisateurs); $c++){

                // Vérifier si il y a déjà le réalisateur dans le tableau "réalisateurs"
                $verifRealisateur = $pdo->prepare("SELECT realisateur_id FROM realisateurs WHERE realisateur = '$realisateurs[$c]'");
                $verifRealisateur->execute();

                if($verifRealisateur->rowCount() == 0) {
                    $sql = $pdo->prepare("INSERT INTO realisateurs (realisateur) VALUES ('$realisateurs[$c]')");
                    $sql->execute();
                    $realisateursId = $pdo->lastInsertId();
                    
                    $sql = $pdo->prepare("INSERT INTO films_realisateurs (realisateurs_realisateur_id, films_film_id) "
                        . "VALUES ('$realisateursId','$idMovie')");
                    
                    $sql->execute();  
                } else {
                    $row = $verifRealisateur->fetch();
                    $realisateursId = $row['realisateur_id'];

                    $sql = $pdo->prepare("INSERT INTO films_realisateurs (realisateurs_realisateur_id, films_film_id) "
                            . "VALUES ('$realisateursId','$idMovie')");
                    $sql->execute();
                }

            }

            // ACTEURS
            $acteurs = explode(",",$valeurs['acteurs']);

            for ($b = 0; $b < count($acteurs); $b++){

                $verifActeur = $pdo->prepare("SELECT acteur_id FROM acteurs WHERE acteur = '$acteurs[$b]'");
                $verifActeur->execute();

                if($verifActeur->rowCount() == 0) {
                    $sql = $pdo->prepare("INSERT INTO acteurs (acteur) VALUES ('$acteurs[$b]')");
                    $sql->execute();
                    $acteursId = $pdo->lastInsertId();
                    
                    $sql = $pdo->prepare("INSERT INTO films_acteurs (acteurs_acteur_id, films_film_id) "
                        . "VALUES ('$acteursId','$idMovie')");
                    
                    $sql->execute();  
                } else {
                    $row = $verifActeur->fetch();
                    $acteursId = $row['acteur_id'];

                    $sql = $pdo->prepare("INSERT INTO films_acteurs (acteurs_acteur_id, films_film_id) "
                            . "VALUES ('$acteursId','$idMovie')");
                    $sql->execute();
                }

            }
        
            // GENRES
            $insert = 'INSERT INTO films_genres (genres_genre_id, films_film_id) VALUES ';
            foreach($arrayGenre AS $keyGenre => $valGenre ) {
                $insert.= '(' .$valGenre. ', ' . $idMovie . ')'; 
                if ( $keyGenre !== sizeof($arrayGenre)-1 ){$insert.= ', ';}
            }
            $prepareGenre = $pdo->prepare($insert);
            $prepareGenre->execute();

            // SUPPRIMER LES POST
            $valeurs = [
                "titre" => "",
                "description" => "",
                "duree" => "",
                "age" => "",
                "video" => "",
                "annee" => "",
                "origine" => "",
                "image" => "",
                "langue" => "",
                "acteurs" => "",
                "realisateurs" => ""
            ];
            $arrayGenre = [];
            $_POST['origine_id'] = "";
        }
    }

} catch(Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}


?>