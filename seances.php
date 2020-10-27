<?php
    // Afficher le head + header
    $_SESSION["page"] = "seances";
    $_SESSION["titre"] = "Séances";
    include('elements/header.php');

?>

    <?php
    
        try {

          include('elements/config.php');	
        // INNER JOIN origine WHERE film.id = origine.id
          
          $resultat = $pdo->prepare('SELECT * FROM films 
          JOIN origines
          ON origines.origine_id = films.origine_id
                                                        ');
          $resultat->execute();
          
         
          while ($donnees = $resultat->fetch()) {
            $DonneeId = $donnees['film_id']
            ?>

                <section class="row">
                    <div class="col-10 offset-1 card card-seances center">

                        <div class="row no-gutters">

                            <div class="col-md-4 film-img">
                                <img src=" <?php echo $donnees['image']; ?>" class="card-img" alt=" <?php echo "affiche du film: " . $donnees['titre']; ?> ">
                            </div>

                            <div class="col-md-8">
                                <div class="card-body">
                                    <h2 class="card-title"> <?php echo $donnees['titre'] ?> </h2>
                                    <p class="card-text"> <?php echo $donnees['description'] ?> </p>
                                    <ul class="card-text film-infos">
                                        <li>Genre: <?php include('data/genres.php') ?> </li> 
                                        <li>Acteurs:  <?php include('data/acteurs.php') ?>
                                         </li>
                                        <li>Durée: <?php echo $donnees['duree'] ?> </li> 
                                        <li>Langue:  <?php echo $donnees['langue'] ?> <?php if ($donnees['age'] != ""){
                                             echo  " | "  . $donnees['age'];
                                        } ?> </li> 
                                        <li>Origine: <?php 
                                            if ($donnees['origine_id'] == $donnees['origine_id']){
                                                echo $donnees['pays'];
                                            }
                                        ?> </li>
                                    </ul>
                                </div>

                                
                            </div>
                            <a href="film.php?id=<?php echo $DonneeId; ?>" class="btn-absolute stretched-link"></a>

                        </div>

                    </div>
                </section>

            <?php
          }
          
        }

        catch(Exception $e) {
          // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
        }
    ?>


<?php
    // Afficher le footer
    include('elements/footer.php');
?>