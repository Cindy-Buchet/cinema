<?php
    // Afficher le head + header
    $_SESSION['page'] = "nouveau";
    $_SESSION['titre'] = "Ajouter un nouveau film";
    require_once('elements/header.php');
    require_once('elements/config.php');
    require_once('elements/erreurs.php');
    include('forms/form-nouveau.php');

?>

        <div class="container">
            <h1>Ajouter un nouveau film</h1>
            <form method="post" action="nouveau.php">
                <div class="form-group">
                    <label>Titre</label>
                    <input type="text" class="form-control" placeholder="Entrer un titre" name="titre" 
                    <?php 
                        if(isset($_POST['submit'])){ echo 'value="' . $valeurs['titre'] . '"';
                        if($_POST['titre'] == ""){ echo 'style="border: 1px solid red;"';} }  
                    ?>  >
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea type="text" class="form-control" placeholder="Entrer la description" name="description" rows="4" style="resize: none;" <?php 
                        if(isset($_POST['submit']) AND $_POST['description'] == "" ){ echo 'style="border: 1px solid red;"';}
                    ?>><?php if(isset($_POST['submit'])){ echo $valeurs['description']; } ?></textarea>
                </div>
                <div class="form-group">
                    <label>Durée</label>
                    <input type="time" step="2" class="form-control" placeholder="Entrer la durée" name="duree"   
                    <?php 
                        if(isset($_POST['submit'])){ echo 'value="' . $valeurs['duree'] . '"';
                        if($_POST['duree'] == ""){ echo 'style="border: 1px solid red;"';} }  
                    ?>  >
                </div>
                <div class="form-group">
                    <label>Âge</label>
                    <input type="text" class="form-control" placeholder="Entrer l'âge" name="age"
                    <?php 
                        if(isset($_POST['submit'])){ echo 'value="' . $valeurs['age'] . '"';
                        if($_POST['age'] == ""){ echo 'style="border: 1px solid red;"';} }
                    ?>  >
                </div>
                <div class="form-group">
                    <label>Bande</label>
                    <input type="text" class="form-control" placeholder="Entrer le lien de la bande annonce" name="video"
                    <?php 
                        if(isset($_POST['submit'])){ echo 'value="' . $valeurs['video'] . '"';
                        if($_POST['video'] == ""){ echo 'style="border: 1px solid red;"';} }
                    ?>  >
                </div>
                <div class="form-group">
                    <label>Année de production</label>
                    <input type="text" class="form-control" placeholder="Entrer l'année de production" name="annee"
                    <?php 
                        if(isset($_POST['submit'])){ echo 'value="' . $valeurs['annee'] . '"';
                        if($_POST['annee'] == ""){ echo 'style="border: 1px solid red;"';} }
                    ?>  >
                </div>
                <div class="form-group-origine">
                    <label class="label-origine">Origine</label>
                    <div class="check-origine">
                        <?php
                            $selectOrigine = $pdo->prepare("SELECT * FROM origines");

                            $selectOrigine->execute();

                            while ($donneesOrigine = $selectOrigine->fetch()){
                                echo '<div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="origine_id" value="' . $donneesOrigine['origine_id'] . '"' ;
                                        
                                        if(isset($_POST['submit']) AND isset($_POST['origine_id']) AND $_POST['origine_id'] == $donneesOrigine['origine_id']){ echo "checked"; }
                                        
                                        echo'>
                                        <label class="form-check-label"';
                                        if(isset($_POST['submit']) AND !isset($_POST['origine_id'])){ echo "style='color: red;'";}
                                        echo'>' . $donneesOrigine['pays'] . '</label>
                                    </div>';
                            }

                        ?>

                    </div>
                    
                </div>
                <div class="form-group">
                    <label>Affiche du film</label>
                    <input type="text" class="form-control" placeholder="Entrer le lien de limage" name="image"
                    <?php 
                        if(isset($_POST['submit'])){ echo 'value="' . $valeurs['image'] . '"';
                        if($_POST['image'] == ""){ echo 'style="border: 1px solid red;"';} }
                    ?>  >
                </div>
                <div class="form-group">
                    <label>Deuxième image</label>
                    <input type="text" class="form-control" placeholder="Entrer le lien de limage" name="image"
                    <?php 
                        if(isset($_POST['submit'])){ echo 'value="' . $valeurs['image2'] . '"';
                        if($_POST['image2'] == ""){ echo 'style="border: 1px solid red;"';} }
                    ?>  >
                </div>
                <div class="form-group">
                    <label>Langue</label>
                    <input type="text" class="form-control" placeholder="Entrer la langue" name="langue"
                    <?php 
                        if(isset($_POST['submit'])){ echo 'value="' . $valeurs['langue'] . '"';
                        if($_POST['langue'] == ""){ echo 'style="border: 1px solid red;"';} }
                    ?>  >
                </div>
                <div class="form-group">
                    <label class="label-genre">Genres</label>
                    <div class="check-genre">
                        <?php
                            $selectGenre = $pdo->prepare("SELECT * FROM genres");

                            $selectGenre->execute();

                            while ($donneesgenre = $selectGenre->fetch()){
                                echo '<div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="genre_id[]" value="' . $donneesgenre['genre_id'] . '"';
                                        
                                        if(isset($_POST['submit']) AND isset($_POST['genre_id']) AND in_array($donneesgenre['genre_id'], $arrayGenre)){ echo "checked"; }
                                        
                                        echo'>
                                        <label class="form-check-label"';
                                        if(isset($_POST['submit']) AND !isset($_POST['genre_id'])){ echo "style='color: red;'";}
                                        
                                        echo'>' . $donneesgenre['genre'] . '</label>
                                    </div>';
                            }

                        ?>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label>Acteurs</label>
                    <input type="text" class="form-control" placeholder="Entrer les acteurs" name="acteurs"
                    <?php 
                        if(isset($_POST['submit'])){ echo 'value="' . $valeurs['acteurs'] . '"';
                        if($_POST['acteurs'] == ""){ echo 'style="border: 1px solid red;"';} }
                    ?>  >
                    <small></small>
                    <small class="form-text text-muted">Séparer les acteurs par des virgules</small>
                </div>
                <div class="form-group">
                    <label>Réalisateur(s)</label>
                    <input type="text" class="form-control" placeholder="Entrer le(s) réalisateur(s)" name="realisateurs"
                    <?php 
                        if(isset($_POST['submit'])){ echo 'value="' . $valeurs['realisateurs'] . '"';
                        if($_POST['realisateurs'] == ""){ echo 'style="border: 1px solid red;"';} }
                    ?>  >
                    <small></small>
                    <small class="form-text text-muted">Séparer les réalisateurs par des virgules</small>
                </div>

                <button type="submit" name="submit" value="submit" class="btn btn-primary">Envoyer</button>
                <p class="text-error font-weight-bold"> <?php echo $_SESSION['validationFilm']; unset($_SESSION['validationFilm']); ?> </p>    
            </form>
        </div>

<?php
    // Afficher le footer
    include('elements/footer.php');
?>
    