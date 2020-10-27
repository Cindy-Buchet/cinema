
<?php



$genre = $pdo->prepare('
    SELECT * from films
    JOIN films_genres, genres
    WHERE films_genres.films_film_id = films.film_id 
    AND films_genres.genres_genre_id = genres.genre_id
    AND films.film_id =' . $DonneeId
);


  $genre->execute();
  $tabGenre = array();
  $boucle = 1;
  
  while ($donneesgenre = $genre->fetch()) {
    array_push($tabGenre, $donneesgenre['genre']);
  }

  $cmpt = count($tabGenre);

  foreach($tabGenre as $value) {
    if ($boucle < $cmpt){
      echo $value . ", ";
    } else {
      echo $value;
    }
    $boucle = $boucle + 1;
      
  }



?>