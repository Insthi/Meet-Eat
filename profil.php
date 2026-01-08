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
    // 2. Récupération des infos utilisateur et profil
    // Note : On utilise les noms de colonnes de ton SQL (nom, prenom, bio, photo, etc.)
    $stmt = $pdo->prepare("SELECT u.email, p.* FROM user u JOIN profil p ON u.id_user = p.id_user WHERE u.id_user = ?");
    $stmt->execute([$id_user]);
    $user = $stmt->fetch();

    if (!$user) {
        // Si pas de profil, on déconnecte ou on redirige vers inscription
        header('Location: login.php'); 
        exit;
    }

    // 3. Récupération des réponses au quiz pour afficher les traits de personnalité
    $stmt_quiz = $pdo->prepare("SELECT reponse FROM reponse_quiz WHERE id_user = ?");
    $stmt_quiz->execute([$id_user]);
    $reponses_quiz = $stmt_quiz->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) { 
    die("Erreur : " . $e->getMessage()); 
}

// 4. Calcul de l'âge
$age = 'Âge non défini';
if (!empty($user['date_naissance'])) {
    $date_naiss = new DateTime($user['date_naissance']);
    $aujourdhui = new DateTime();
    $age = $date_naiss->diff($aujourdhui)->y . ' ans';
}

// 5. Gestion de la photo de profil
$photo_profil = !empty($user['photo_url']) ? 'UPLOADS/' . $user['photo_url'] : 'IMAGES/default-avatar.png';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Meet Eat</title>
    <link rel="stylesheet" href="profil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header>
        <div class="logo-section">
            <img src="IMAGES/logomeeteat.png" alt="Logo">
        </div>
        <nav>
            <a href="accueil.php">Accueil</a>
            <a href="restaurants.php">Restaurants</a>
            <a href="index-test.php">Mes réservations</a>
            <a href="chat.php">Messages</a>
        </nav>
        <div class="nav-right">
            <a href="profil.php" class="active"><i class="fa-solid fa-user"></i></a>
        </div>
    </header>

    <main class="profile-container">
        
        <div class="profile-header">
            <div class="avatar-container">
                <img src="<?= htmlspecialchars($photo_profil) ?>" alt="Photo de profil" class="profile-pic">
                <a href="updateprofil.php" class="edit-avatar-btn"><i class="fa-solid fa-camera"></i></a>
            </div>
            
            <h1 class="user-name">
                <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>, <?= $age ?>
            </h1>
            <p class="user-meta">
                <?= htmlspecialchars($user['pronoms']) ?> | <?= htmlspecialchars($user['orientation']) ?>
            </p>
        </div>

        <div class="section-title">À propos de moi</div>
        <div class="bio-box">
            <?= nl2br(htmlspecialchars($user['bio'] ?? "Aucune description pour le moment...")) ?>
        </div>

        <div class="section-title">Mes traits de personnalité</div>
        <div class="traits-container">
            <?php if (!empty($reponses_quiz)): ?>
                <?php foreach ($reponses_quiz as $trait): ?>
                    <span class="trait-tag"><?= htmlspecialchars($trait) ?></span>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="opacity:0.6;">Faites le quiz pour afficher vos traits !</p>
            <?php endif; ?>
        </div>

        <hr>

        <div class="section-title">Informations de compte</div>
        <div class="info-grid">
            <div class="info-card">
                <i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($user['email']) ?>
            </div>
            <div class="info-card">
                <i class="fa-solid fa-lock"></i> Mot de passe : ••••••••
            </div>
        </div>

        <div class="actions-footer">
            <a href="updateperso.php" class="btn-edit-info"><i class="fa-solid fa-pencil"></i> Modifier mes accès</a>
            <a href="logout.php" class="btn-logout">Se déconnecter</a>
        </div>

    </main>

    <footer>
        <p>© 2026 MeetEat. Tous droits réservés.</p>
    </footer>

</body>
</html>