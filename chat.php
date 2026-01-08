<?php
// --- INITIALISATION ---
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sécurité : Redirection si non connecté
if (!isset($_SESSION['id_user'])) {
    // Pour tes tests, on force l'ID 1 si la session est vide, 
    // mais à terme il faudra décommenter la redirection
    $id_user_connecte = 1; 
    // header('Location: login.php'); exit;
} else {
    $id_user_connecte = $_SESSION['id_user'];
}

$id_discussion_actuelle = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// --- 1. LOGIQUE POUR QUITTER LA DISCUSSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_quitter'])) {
    $stmt = $pdo->prepare("DELETE FROM participant_discussion WHERE id_discussion = ? AND id_user = ?");
    $stmt->execute([$id_discussion_actuelle, $id_user_connecte]);
    header("Location: chat.php"); 
    exit;
}

// --- 2. LOGIQUE POUR RE-CONTACTER (CHAT PRIVÉ) ---
if (isset($_GET['contact_id'])) {
    $id_ami = (int)$_GET['contact_id'];
    
    $stmt = $pdo->prepare("
        SELECT d.id_discussion 
        FROM discussion d
        JOIN participant_discussion p1 ON d.id_discussion = p1.id_discussion
        JOIN participant_discussion p2 ON d.id_discussion = p2.id_discussion
        WHERE p1.id_user = ? AND p2.id_user = ? AND (d.id_session IS NULL OR d.id_session = 0)
    ");
    $stmt->execute([$id_user_connecte, $id_ami]);
    $discussion_existante = $stmt->fetch();

    if ($discussion_existante) {
        header("Location: chat.php?id=" . $discussion_existante['id_discussion']);
    } else {
        $pdo->prepare("INSERT INTO discussion (nom_groupe) VALUES ('Chat Privé')")->execute();
        $nouvel_id = $pdo->lastInsertId();
        $pdo->prepare("INSERT INTO participant_discussion (id_discussion, id_user) VALUES (?, ?), (?, ?)")
            ->execute([$nouvel_id, $id_user_connecte, $nouvel_id, $id_ami]);
        header("Location: chat.php?id=" . $nouvel_id);
    }
    exit;
}

// --- 3. ENVOI DE MESSAGE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $contenu = trim($_POST['message']);
    $image_url = null;

    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
        $upload_dir = 'UPLOADS/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $file_name = uniqid('IMG_') . '.' . pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $upload_dir . $file_name)) {
            $image_url = $upload_dir . $file_name;
        }
    }

    if (!empty($contenu) || !empty($image_url)) {
        $stmt = $pdo->prepare("INSERT INTO message (id_discussion, id_user, contenu, image_url, date_envoi) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$id_discussion_actuelle, $id_user_connecte, $contenu, $image_url]);
        header("Location: chat.php?id=" . $id_discussion_actuelle);
        exit;
    }
}

// --- 4. RÉCUPÉRATION DES DONNÉES DE LA SIDEBAR ---
$search = $_GET['search'] ?? '';
$search_param = "%$search%";

// 4a. Mes Groupes (Basés sur les tables 'sessions' et 'restaurants' de ton SQL)
$groupes_stmt = $pdo->prepare("
    SELECT d.id_discussion, r.name as resto_nom 
    FROM discussion d 
    JOIN participant_discussion pd ON d.id_discussion = pd.id_discussion 
    JOIN sessions s ON d.id_session = s.id_session 
    JOIN restaurants r ON s.id_restaurant = r.id 
    WHERE pd.id_user = ? AND r.name LIKE ?
");
$groupes_stmt->execute([$id_user_connecte, $search_param]);
$mes_groupes = $groupes_stmt->fetchAll();

// 4b. Messages Privés
$prives_stmt = $pdo->prepare("
    SELECT d.id_discussion, p.prenom, p.photo
    FROM discussion d
    JOIN participant_discussion pd1 ON d.id_discussion = pd1.id_discussion
    JOIN participant_discussion pd2 ON d.id_discussion = pd2.id_discussion
    JOIN profil p ON pd2.id_user = p.id_user
    WHERE pd1.id_user = ? AND pd2.id_user != ? AND (d.id_session IS NULL OR d.id_session = 0) AND p.prenom LIKE ?
");
$prives_stmt->execute([$id_user_connecte, $id_user_connecte, $search_param]);
$mes_prives = $prives_stmt->fetchAll();

// 4c. Liste des contacts pour démarrer un chat
$contacts_stmt = $pdo->prepare("SELECT id_user, prenom, photo FROM profil WHERE id_user != ? AND prenom LIKE ? LIMIT 10");
$contacts_stmt->execute([$id_user_connecte, $search_param]);
$tous_les_contacts = $contacts_stmt->fetchAll();

// --- 5. DONNÉES DU CHAT ACTUEL ---
$query_info = $pdo->prepare("
    SELECT d.*, r.name AS resto_nom,
    (SELECT p.prenom FROM profil p JOIN participant_discussion pd ON p.id_user = pd.id_user WHERE pd.id_discussion = d.id_discussion AND p.id_user != ? LIMIT 1) as nom_ami,
    (SELECT p.photo FROM profil p JOIN participant_discussion pd ON p.id_user = pd.id_user WHERE pd.id_discussion = d.id_discussion AND p.id_user != ? LIMIT 1) as photo_ami
    FROM discussion d
    LEFT JOIN sessions s ON d.id_session = s.id_session
    LEFT JOIN restaurants r ON s.id_restaurant = r.id
    WHERE d.id_discussion = ?
");
$query_info->execute([$id_user_connecte, $id_user_connecte, $id_discussion_actuelle]);
$chat_info = $query_info->fetch();

$titre_chat = $chat_info['resto_nom'] ?? ($chat_info['nom_ami'] ?? "Discussion");
$photo_chat = $chat_info['photo_ami'] ?? 'IMAGES/default.png';

$messages = [];
if ($id_discussion_actuelle) {
    $msg_query = $pdo->prepare("SELECT m.*, p.prenom, p.photo FROM message m JOIN profil p ON m.id_user = p.id_user WHERE m.id_discussion = ? ORDER BY m.date_envoi ASC");
    $msg_query->execute([$id_discussion_actuelle]);
    $messages = $msg_query->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Meet-Eat Chat</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="chat.css">
</head>
<body>

    <div id="settingsModal" class="modal" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:white; padding:30px; border-radius:15px; text-align:center;">
            <h3>Options</h3>
            <form method="POST">
                <button type="submit" name="action_quitter" style="background:#660601; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">Quitter la discussion</button>
            </form>
            <button onclick="toggleSettings()" style="margin-top:15px; background:none; border:none; text-decoration:underline; cursor:pointer;">Fermer</button>
        </div>
    </div>

    <aside class="sidebar">
        <div class="logo-container"><img src="IMAGES/logoinverse.png" alt="Logo"></div>
        
        <form class="search-container" method="GET">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" name="search" class="search-bar" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>">
        </form>
        
        <div class="discussion-list">
            <p class="section-title">Mes Groupes</p>
            <?php foreach ($mes_groupes as $g): ?>
                <a href="chat.php?id=<?= $g['id_discussion'] ?>" class="discussion-item <?= ($g['id_discussion'] == $id_discussion_actuelle) ? 'active' : '' ?>">
                    <?= htmlspecialchars($g['resto_nom']) ?>
                </a>
            <?php endforeach; ?>

            <p class="section-title">Messages Privés</p>
            <?php foreach ($mes_prives as $p): ?>
                <a href="chat.php?id=<?= $p['id_discussion'] ?>" class="discussion-item <?= ($p['id_discussion'] == $id_discussion_actuelle) ? 'active' : '' ?>">
                    <div class="user-row">
                        <img src="<?= $p['photo'] ?>" class="mini-avatar">
                        <span><?= htmlspecialchars($p['prenom']) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>

            <p class="section-title">Nouveau Chat</p>
            <?php foreach ($tous_les_contacts as $c): ?>
                <a href="chat.php?contact_id=<?= $c['id_user'] ?>" class="discussion-item">
                    <div class="user-row" style="opacity:0.7;">
                        <img src="<?= $c['photo'] ?>" class="mini-avatar">
                        <span><?= htmlspecialchars($c['prenom']) ?></span>
                        <i class="fa-solid fa-plus" style="margin-left:auto;"></i>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </aside>

    <main class="chat-main">
        <header class="chat-header">
            <div class="header-info">
                <img src="<?= $photo_chat ?>" class="resto-photo-header">
                <h2><?= htmlspecialchars($titre_chat) ?></h2>
            </div>
            <div class="header-icons">
                <i id="bellIcon" class="fa-regular fa-bell" onclick="quickBellToggle()"></i>
                <i class="fa-solid fa-gear" onclick="toggleSettings()"></i>
            </div>
        </header>

        <section class="messages-container" id="chatBox">
            <?php foreach ($messages as $m): ?>
                <div class="message-row <?= ($m['id_user'] == $id_user_connecte) ? 'me' : 'others' ?>">
                    <img src="<?= $m['photo'] ?>" class="avatar-msg">
                    <div class="bubble-wrapper">
                        <div class="bubble">
                            <?php if ($m['image_url']): ?>
                                <img src="<?= $m['image_url'] ?>" class="chat-image" style="max-width:200px; display:block; margin-bottom:5px; border-radius:10px;">
                            <?php endif; ?>
                            <?= htmlspecialchars($m['contenu']) ?>
                            <span class="msg-time"><?= date('H:i', strtotime($m['date_envoi'])) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <form class="input-area" method="POST" enctype="multipart/form-data">
            <div class="input-wrapper">
                <label for="image_file" class="upload-btn"><i class="fa-solid fa-image"></i></label>
                <input type="file" name="image_file" id="image_file" style="display:none;">
                <input type="text" name="message" placeholder="Votre message..." autocomplete="off">
                <button type="submit" class="send-btn"><i class="fa-solid fa-paper-plane"></i></button>
            </div>
        </form>
    </main>

    <script>
        const chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;

        function toggleSettings() {
            const m = document.getElementById('settingsModal');
            m.style.display = (m.style.display === "flex") ? "none" : "flex";
        }

        function quickBellToggle() {
            const bell = document.getElementById('bellIcon');
            bell.classList.toggle('fa-regular');
            bell.classList.toggle('fa-solid');
            bell.classList.toggle('fa-bell');
            bell.classList.toggle('fa-bell-slash');
        }
    </script>
</body>
</html>