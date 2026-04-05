<?php $session = session(); //initialisation de la session ?>
<html>
<head>
    <title>Projet Atlantik</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo site_url('acceuil') ?>">Projet Atlantik</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php
        if ($session->get('MEL') == 'Client') {
          echo '<li class="nav-item"><a class="nav-link" href="' . site_url('deconnecter') . '">Se déconnecter</a></li>';
        } else {
          echo '<li class="nav-item"><a class="nav-link" href="' . site_url('seconnecter') . '">Se connecter</a></li>';
          echo '<li class="nav-item"><a class="nav-link" href="' . site_url('creercompte') . '">Créer un compte</a></li>';
        }
        echo '<li class="nav-item"><a class="nav-link" href="' . site_url('afficherliaisons') . '">Afficher les liaisons</a></li>';
      ?>
      </ul>
    </div>
  </div>
</nav>
<h6> Connecté en tant que : <?php echo $session->get('MEL') ?? 'Visiteur'; ?> </h6>