<!-- HEAD -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- STYLES -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" media="screen" type="text/css" title="style" href="assets/scss/style.css"/>
    
    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16x16.png">
    <link rel="manifest" href="assets/img/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffffff">
    
    <!-- TITRE -->
    <title><?php echo "CinéCaméo - " . $_SESSION['titre'] ?></title>
</head>
<body>

<!-- HEADER + NAV -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/cine.png" alt="logo" />
        </a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item  <?php if ($_SESSION['page'] == "accueil"){ echo 'active';} ?>">
                <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php if ($_SESSION['page'] == "seances"){ echo 'active';} ?> ">
                <a class="nav-link " href="seances.php">Séances</a>
            </li>
            <li class="nav-item  <?php if ($_SESSION['page'] == "nouveau"){ echo 'active';} ?> ">
                <a class="nav-link" href="nouveau.php">Ajouter</a>
            </li>
        </ul>
        
    </div>
    </nav>
</header>

<!-- MAIN -->
<main>
