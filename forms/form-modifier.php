<?php
$id = $_GET['update'];

function trim_value(&$value){
    $value = trim($value);
}

if(!isset($arrayGenre)){ $arrayGenre = [];}
try { 
         
    if(isset($_POST["submit"])){
        if(!isset($_POST['origine_id'])){
            $_POST['origine_id'] = NULL;
        }


        if($_POST['titre'] != "" AND $_POST['description'] != "" AND $_POST['duree'] != "" AND $_POST['age'] != "" AND $_POST['video'] != "" AND $_POST['annee'] != "" AND $_POST['origine_id'] != "" AND $_POST['image'] != "" AND $_POST['langue'] != "" AND $_POST['acteurs'] != "" AND $_POST['realisateurs'] != ""){
            
            $prepareFilm = $pdo->prepare('UPDATE films SET titre= :titre, description= :description, duree=:duree , age=:age, video=:video, annee=:annee, origine_id=:origine_id, image=:image, langue=:langue, image2=:image2 WHERE film_id =' . $id . '');
            
            $prepareFilm->execute(array(
                ":titre" => $_POST['titre'],
                ":description" => $_POST['description'],
                ":duree" => $_POST['duree'],
                ":age" => $_POST['age'],
                ":video" => $_POST['video'],
                ":annee" => $_POST['annee'],
                ":origine_id" => $_POST['origine_id'],
                ":image" => $_POST['image'],
                ":langue" => $_POST['langue'],
                ":image2" => $_POST['image2']
            )); 
            $idMovie = $pdo->lastInsertId();
            
            $_SESSION['validationFilm'] = "Les données ont bien été modifiées";

    
            // -------------- GENRES ----------------
            // Stocker les genres cochés dans un tableau
            $arrayGenre = [];

            if(!empty($_POST['genre_id'])){
                foreach($_POST['genre_id'] as $selected){
                    array_push($arrayGenre,$selected);
                }
            }

            // Récupérer les genres de la DB
            $selectAncienGenre = $pdo->prepare(" SELECT genre_id FROM genres
                                                LEFT JOIN films_genres on films_genres.genres_genre_id = genres.genre_id
                                                LEFT JOIN films on films.film_id = films_genres.films_film_id
                                                WHERE films.film_id = $id ");
            $selectAncienGenre->execute();
            // Insérer les genres de la DB dans un tableau
            $arrayAncienGenre = [];
            while($ancienGenre = $selectAncienGenre->fetch()){
                array_push($arrayAncienGenre, $ancienGenre['genre_id']);
            }

            // COMPARER LES 2 TABLEAUX
            $result1 = array_diff($arrayGenre, $arrayAncienGenre); // Nouvelles entrées
            $result2 = array_diff($arrayAncienGenre, $arrayGenre); // Anciennes entrées
            
            
            if(count($result1) != 0){
                // Ajouter les nouveaux genres
                $insert = 'INSERT INTO films_genres (genres_genre_id, films_film_id) VALUES ';
                $p = 1;
                
                foreach($result1 AS $keyGenre => $valGenre ) {
                    $insert.= '(' .$valGenre. ', ' . $id . ')'; 
                    if ( $p !== count($result1) ){$insert.= ', ';}
                    $p++;
                }

                $prepareGenre = $pdo->prepare($insert);
                $prepareGenre->execute();
            }

            if(count($result2) != 0){
                // Supprimer les anciens genres
                foreach($result2 AS $keyDelete => $valDelete ) {
                    $deleteGenre = $pdo->prepare(" DELETE FROM films_genres WHERE genres_genre_id = $valDelete AND films_film_id = $id ");
                    $deleteGenre->execute();
                }
            }
            

            // -------------- ACTEURS ---------------
            $acteurs = explode(",",$_POST['acteurs']); // exploser le texte avec les ,

            
            // Récupérer les acteurs de la DB
            $selectAncienActeurs = $pdo->prepare(" SELECT acteur_id, acteur FROM acteurs
                                                LEFT JOIN films_acteurs on films_acteurs.acteurs_acteur_id = acteurs.acteur_id
                                                LEFT JOIN films on films.film_id = films_acteurs.films_film_id
                                                WHERE films.film_id = $id ");
            $selectAncienActeurs->execute();
            // Insérer les acteurs de la DB dans un tableau
            $arrayAncienActeur = [];
            while($ancienActeur = $selectAncienActeurs->fetch()){
                array_push($arrayAncienActeur, $ancienActeur['acteur']);
            }

            array_walk($acteurs, 'trim_value');
            array_walk($arrayAncienActeur, 'trim_value');
            
            // COMPARER LES 2 TABLEAUX
            $result1Acteur = array_diff($acteurs, $arrayAncienActeur); // Nouvelles entrées
            $result2Acteur = array_diff($arrayAncienActeur, $acteurs); // Anciennes entrées

            
            if(count($result1Acteur) != 0){ // Vérifier si il y a une donnée dans le 1e tableau
                foreach($result1Acteur as $keyActeur => $valActeur){
                    // Vérifier si l'acteur existe dans le tableau 'acteurs'
                    $verifActeur = $pdo->prepare("SELECT acteur_id FROM acteurs WHERE acteur = '$valActeur'");
                    $verifActeur->execute();

                    // Si il n'existe pas
                    if($verifActeur->rowCount() == 0) {
                        // Insérer l'acteur dans le tableau acteurs
                        $sql = $pdo->prepare("INSERT INTO acteurs (acteur) VALUES ('$valActeur')");
                        $sql->execute();
                        $acteursId = $pdo->lastInsertId(); // Récuperer son ID
                        
                        // Insérer l'acteur dans le tableau films_acteurs
                        $sql = $pdo->prepare("INSERT INTO films_acteurs (acteurs_acteur_id, films_film_id) "
                            . "VALUES ('$acteursId','$id')");
                        $sql->execute(); 

                    } 
                    // Si il existe
                    else {
                        // Récuperer le ID de l'acteur 
                        $row = $verifActeur->fetch();
                        $acteursId = $row['acteur_id'];

                        $sql = $pdo->prepare("INSERT INTO films_acteurs (acteurs_acteur_id, films_film_id) "
                                . "VALUES ('$acteursId','$id')");
                        $sql->execute();
                    }
                }


            }

            // Supprimer les anciens acteurs 
            if(count($result2Acteur) != 0){
                
                foreach($result2Acteur AS $keyDeleteActeur => $valDeleteActeur ) {
                    
                    $verifActeurDelete = $pdo->prepare("SELECT acteur_id FROM acteurs WHERE acteur = '$valDeleteActeur'");
                    $verifActeurDelete->execute();
                    $rowDelete = $verifActeurDelete->fetch();
                    $acteursIdDelete = $rowDelete['acteur_id'];

                    $deleteGenre = $pdo->prepare(" DELETE FROM films_acteurs WHERE acteurs_acteur_id = $acteursIdDelete AND films_film_id = $id ");
                    $deleteGenre->execute();
                }
            }
        }
    }
    
    $select = $pdo->prepare("SELECT * FROM films WHERE film_id = $id");
    $select->execute();
    $donnees = $select->fetch();
        
    $valeurs = [
        "titre" => $donnees['titre'],
        "description" => $donnees['description'],
        "duree" => $donnees['duree'],
        "age" => $donnees['age'],
        "video" => $donnees['video'],
        "annee" => $donnees['annee'],
        "origine" => $donnees['origine_id'],
        "image" => $donnees['image'],
        "langue" => $donnees['langue']
    ];
    //var_dump($valeurs);

} catch(Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}


?>