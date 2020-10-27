<?php
    // Afficher le head + header
    $_SESSION["page"] = "film";
    $_SESSION["titre"] = "Film";
    include('elements/header.php');

    require_once("elements/config.php");

    $DonneeId = $_GET['id'];

    $film = $pdo->prepare("SELECT * FROM films 
            JOIN origines
            ON origines.origine_id = films.origine_id WHERE film_id = $_GET[id]");

    $film->execute();

    while($donnees = $film->fetch()) {
        ?>
        <div class="film-img-header" style="background-image:url(<?php echo $donnees['image2']; ?>)" ></div>
            <section class=" fiche-film">

                <div class="row no-gutters titre-description">

                    <div class="col-md-4 film-img">
                        <img src=" <?php echo $donnees['image']; ?>" class="card-img" alt=" <?php echo "affiche du film: " . $donnees['titre']; ?> ">
                    </div>

                    <div class="col-md-8">
                        <div class="card-body">
                            <h2 class="card-title"> <?php echo $donnees['titre'] ?> </h2>
                            <p class="card-text"> <?php echo $donnees['description'] ?> </p>

                        
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <h3>Informations</h3>
                        <p>Genre: <?php include('data/genres.php') ?> </p> 
                        <p>Acteurs:  <?php include('data/acteurs.php') ?></p>
                        <p>Durée: <?php echo $donnees['duree'] ?> </p> 
                        <p>Langue:  <?php echo $donnees['langue'] ?> <?php if ($donnees['age'] != ""){
                                echo  " | "  . $donnees['age'];
                        } ?> </p> 
                        <p>Origine: <?php 
                            if ($donnees['origine_id'] == $donnees['origine_id']){
                                echo $donnees['pays'];
                            }
                        ?> </p>
                    </div>
                    <div class="col-12">
                        
                        <h3>Bande annonce</h3>
                        <iframe src="http://www.youtube.com/embed/<?php echo substr($donnees['video'], -11); ?>" width="100%" height="420" frameborder="0" allowfullscreen></iframe> 
                    </div>
                    
                </div>
                    
        

            </section>
<?php
    }

    // Afficher le footer
    include('elements/footer.php');
?>