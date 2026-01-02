<?php
session_start();
// Connexion BDD
$pdo = new PDO("mysql:host=localhost;dbname=v2meet-eat;charset=utf8", "root", "");

$est_connecte = isset($_SESSION['nom']);
$nom_affichage = $est_connecte ? " " . htmlspecialchars($_SESSION['nom']) : "";
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MeetEat — Accueil</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&family=Gloock&family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="reserver_styles.css" />
  <link rel="stylesheet" href="accueil_styles.css" />
  <link rel="stylesheet" href="choix.css" />
</head>
<body>

  <div class="app">
    <header class="nav">
      <div class="brand">
        <div class="logo"><img src="assets/logomeeteat.png" class="logo-img" /></div>
        <div class="txt">MEET<br/>EAT</div>
      </div>
      <nav class="navlinks">
        <a href="accueil.php">Accueil</a>
        <a href="restaurants.php">Réserver</a>
        <a href="#">Discussions</a>
        <a href="#">Témoignages</a>
      </nav>
      <div class="navicons">
        <button class="iconbtn">
           <svg viewBox="0 0 24 24" fill="none" stroke="white" width="24"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" stroke-width="2"/><path d="M4 20a8 8 0 0 1 16 0" stroke-width="2"/></svg>
        </button>
      </div>
    </header>

    <section class="hero-container">
      <div class="hero-text-box">
        <div class="bg-red-box"><h1 class="hero-title">Rencontrer</h1></div>
        <div class="bg-red-box"><p class="hero-subtitle">n'a jamais eu aussi bon goût.</p></div>
      </div>
    </section>

    <section class="welcome-area">
      <h2 class="welcome-title">Bienvenue<?php echo $nom_affichage; ?>!</h2>
      <a href="#choix-section" class="btn-explore">Commencer l'expérience</a>
    </section>

    <section class="presentation-section">
        <p class="presentation-text">
            Avec Meat & Eat, réalisez des ateliers culinaires en compagnie des personnes qui vous correspondent. 
            Pour cela, répondez à un quiz basé sur vos préférences et votre vision des relations, 
            réservez un restaurant à plusieurs, et laissez-vous porter par l'expérience de la cuisine ensemble.
        </p>
    </section>

    <main id="choix-section" class="split-container">
        <section class="pane love-pane">
            <h1 class="side-title left-align">Vous êtes</h1>
            <div class="content">
                <div class="emoji">🥂</div>
                <h2 class="category-title">Amour</h2>
                <p class="align-right">Choisir l’amour, c’est choisir les frissons et la tendresse. Prêts à fondre comme un chocolat et à faire frétiller les cœurs comme des bulles de champagne ?</p>
                <a href="quizlove.php" class="btn btn-white">C'est pour moi !</a>
            </div>
        </section>

        <section class="pane friendship-pane">
            <h1 class="side-title right-align">plutôt quoi ?</h1>
            <div class="content">
                <div class="emoji">🍕</div>
                <h2 class="category-title">Amitié</h2>
                <p class="align-right">L’amitié se savoure comme un moment délicieux. Prêts à croquer la vie comme une part de pizza et à remplir les cœurs de joie ?</p>
                <a href="quizfriend.php" class="btn btn-dark">C'est pour moi !</a>
            </div>
        </section>
    </main>

    <footer class="footer">
      <div class="footer-bottom" style="text-align: center; padding: 40px 20px;">
        © 2026 MeetEat. Tous droits réservés.
      </div>
    </footer>
  </div>
</body>
</html>