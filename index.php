<?php
    // Afficher le head + header
    $_SESSION["page"] = "accueil";
    $_SESSION['titre'] = "Accueil";
    include('elements/header.php');

?>

<section class="container">
    <a href="seances.php" class="btn btn-primary btn-lg btn-block" role="button" aria-disabled="true">Voir les films</a>
    <a href="nouveau.php" class="btn btn-secondary btn-lg btn-block" role="button" aria-disabled="true">Ajouter un film</a>
</section>


<?php
    // Afficher le footer
    include('elements/footer.php');
?>