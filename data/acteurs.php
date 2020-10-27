
<?php

	
    
    $acteur = $pdo->prepare('
        SELECT * from films
        JOIN films_acteurs, acteurs
        WHERE films_acteurs.films_film_id = films.film_id 
        AND films_acteurs.acteurs_acteur_id = acteurs.acteur_id
        AND films.film_id =' . $DonneeId
    );

    $acteur->execute();
    $tabActeur = array();
    $boucle = 1;
   
    while ($donneesacteur = $acteur->fetch()) {
      array_push($tabActeur, $donneesacteur['acteur']);
    }

    $cmpt = count($tabActeur);

    foreach($tabActeur as $value) {
      if ($boucle < $cmpt){
        echo $value . ", ";
      } else {
        echo $value;
      }
      $boucle = $boucle + 1;
        
    }
    


?>