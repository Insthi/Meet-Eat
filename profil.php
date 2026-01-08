<?php
session_start();
require 'db.php';

// 1. Vérification de la session
if (!isset($_SESSION['id_user'])) { 
    header('Location: login.php'); 
    exit; 
}

$id_user = $_SESSION['id_user'];

try {
    // 2. Récupération des infos utilisateur (email) et profil (tout le reste)
    $stmt = $pdo->prepare("SELECT u.email, p.* FROM user u JOIN profil p ON u.id_user = p.id_user WHERE u.id_user = ?");
    $stmt->execute([$id_user]);
    $user = $stmt->fetch();

    if (!$user) {
        header('Location: logout.php'); 
        exit;
    }

    // 3. Récupération des traits du quiz
    $stmt_quiz = $pdo->prepare("SELECT reponse FROM reponse_quiz WHERE id_user = ?");
    $stmt_quiz->execute([$id_user]);
    $reponses_quiz = $stmt_quiz->fetchAll();
} catch (PDOException $e) { 
    die("Erreur : " . $e->getMessage()); 
}

// 4. Calcul de l'âge dynamique
$age = !empty($user['date_naissance']) ? (new DateTime($user['date_naissance']))->diff(new DateTime())->y . ' ans' : 'À définir';

// 5. Fonction de sécurité pour l'affichage (évite les erreurs si champ vide)
function getSafeVal($data, $key, $suffix = "") {
    return (isset($data[$key]) && !empty($data[$key])) ? htmlspecialchars($data[$key]) . $suffix : "À définir";
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Meet&Eat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="profil.css">
</head>
<body>

    <header>
        <div class="logo-section">
            <img src="assets/logomeeteat.png" alt="Logo">
        </div>
        <nav>
            <a href="accueil.php">Accueil</a>
            <a href="#">Concept</a>
            <a href="#">Catégories</a>
            <a href="#">Mes réservations</a>
            <a href="#">Contact</a>
        </nav>
        <div class="nav-right">
            <a href="profil.php"><i class="fa-regular fa-user"></i></a>
        </div>
    </header>

    <div class="container">
        <a href="accueil.php" class="btn-back">Retour</a>
        
        <div class="profile-header">
    <img src="<?= !empty($user['photo_url']) ? 'UPLOADS/'.$user['photo_url'] : 'IMAGES/default.png' ?>" 
         class="profile-img" 
         id="profilePreview">
    
    <div class="edit-icons">
        <i class="fa-solid fa-pencil" onclick="document.getElementById('fileInput').click();" style="cursor:pointer;"></i>
        <i class="fa-solid fa-plus" onclick="document.getElementById('fileInput').click();" style="cursor:pointer;"></i>
    </div>
</div>

<input type="file" id="fileInput" name="photo" style="display:none;" onchange="previewImage(this)">
<input type="hidden" name="current_photo" value="<?= htmlspecialchars($user['photo_url']) ?>">

<input type="file" id="fileInput" name="photo" style="display:none;" onchange="previewImage(this)">
<input type="hidden" name="current_photo" value="<?= htmlspecialchars($user['photo_url']) ?>">
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            // Met à jour l'image dans le cercle bordeaux
            document.getElementById('profilePreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

        <h1>Bienvenue, <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?> !</h1>

        <hr>

        <div class="section-title">Informations publiques</div>
        <a href="updateprofil.php" class="edit-link"><i class="fa-solid fa-pencil"></i> Modifier mon profil public</a>

        <div class="bio-box">
            <?= !empty($user['biographie']) ? nl2br(htmlspecialchars($user['biographie'])) : "Aucune biographie renseignée." ?>
        </div>

        <div class="info-grid">
            <div class="info-card"><i class="fa-regular fa-user"></i> <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></div>
            <div class="info-card"><i class="fa-regular fa-calendar"></i> <?= $age ?></div>
            <div class="info-card"><i class="fa-solid fa-venus-mars"></i> <?= getSafeVal($user, 'genre') ?></div>
            <div class="info-card"><i class="fa-regular fa-heart"></i> <?= getSafeVal($user, 'orientation') ?></div>
            <div class="info-card"><i class="fa-solid fa-house"></i> <?= getSafeVal($user, 'ville') ?></div>
            <div class="info-card"><i class="fa-solid fa-briefcase"></i> <?= getSafeVal($user, 'metier') ?></div>
            <div class="info-card"><i class="fa-solid fa-magnifying-glass"></i> <?= getSafeVal($user, 'type_relation') ?></div>
            <div class="info-card"><i class="fa-solid fa-user-tag"></i> <?= getSafeVal($user, 'religion') ?></div>
        </div>

        <hr>

        <div class="section-title">Mon quiz</div>
        <a href="choix.php" class="edit-link"><i class="fa-solid fa-pencil"></i> Repasser mon quiz</a>

        <div class="info-grid">
            <?php if ($reponses_quiz): ?>
                <?php foreach ($reponses_quiz as $rep): ?>
                    <div class="info-card"><i class="fa-solid fa-circle-info"></i> <?= htmlspecialchars($rep['reponse']) ?></div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:left; grid-column: span 2; opacity:0.6;">Aucun trait défini.</p>
            <?php endif; ?>
        </div>

        <hr>

        <div class="section-title">Informations personnelles</div>
        <a href="updateperso.php" class="edit-link"><i class="fa-solid fa-pencil"></i> Modifier mes accès</a>

        <div class="info-grid">
            <div class="info-card">
                <i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($user['email']) ?>
            </div>
            <div class="info-card">
                <i class="fa-solid fa-lock"></i> Mot de passe (********)
            </div>
        </div>

        <div class="logout-container">
            <a href="logout.php" class="btn-logout-bottom">Se déconnecter</a>
        </div>

        <footer>
            <div style="margin-bottom: 10px;">
                <a href="#" style="color:inherit; text-decoration:none; display:block;">À propos de MeetEat</a>
                <a href="#" style="color:inherit; text-decoration:none; display:block;">Conseils de rencontres</a>
            </div>
            <div class="social-icons">
                <i class="fa-brands fa-x-twitter"></i>
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-youtube"></i>
                <i class="fa-brands fa-linkedin"></i>
            </div>
        </footer>
    </div>
</body>
</html>