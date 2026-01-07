<?php
// --- INITIALISATION ---
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_user_connecte = 1; // À remplacer par $_SESSION['id_user'] en production
$id_discussion_actuelle = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// --- 1. LOGIQUE POUR QUITTER LA DISCUSSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_quitter'])) {
    $stmt = $pdo->prepare("DELETE FROM participant_discussion WHERE id_discussion = ? AND id_user = ?");
    $stmt->execute([$id_discussion_actuelle, $id_user_connecte]);
    header("Location: chat.php"); 
    exit;
}

// --- 2. LOGIQUE POUR RE-CONTACTER (RECHERCHER OU CRÉER UN CHAT PRIVÉ) ---
if (isset($_GET['contact_id'])) {
    $id_ami = (int)$_GET['contact_id'];
    
    $stmt = $pdo->prepare("
        SELECT d.id_discussion 
        FROM discussion d
        JOIN participant_discussion p1 ON d.id_discussion = p1.id_discussion
        JOIN participant_discussion p2 ON d.id_discussion = p2.id_discussion
        WHERE p1.id_user = ? AND p2.id_user = ? AND d.id_session IS NULL
    ");
    $stmt->execute([$id_user_connecte, $id_ami]);
    $discussion_existante = $stmt->fetch();

    if ($discussion_existante) {
        $id_disc = $discussion_existante['id_discussion'];
        $check = $pdo->prepare("SELECT * FROM participant_discussion WHERE id_discussion = ? AND id_user = ?");
        $check->execute([$id_disc, $id_user_connecte]);
        if (!$check->fetch()) {
            $pdo->prepare("INSERT INTO participant_discussion (id_discussion, id_user) VALUES (?, ?)")
                ->execute([$id_disc, $id_user_connecte]);
        }
        header("Location: chat.php?id=" . $id_disc);
    } else {
        $pdo->prepare("INSERT INTO discussion (nom_groupe) VALUES ('Chat Privé')")->execute();
        $nouvel_id = $pdo->lastInsertId();
        $pdo->prepare("INSERT INTO participant_discussion (id_discussion, id_user) VALUES (?, ?), (?, ?)")
            ->execute([$nouvel_id, $id_user_connecte, $nouvel_id, $id_ami]);
        header("Location: chat.php?id=" . $nouvel_id);
    }
    exit;
}

// --- 3. ENVOI DE MESSAGE OU PHOTO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action_quitter'])) {
    $contenu = $_POST['message'] ?? null;
    $image_url = null;

    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
        $upload_dir = 'UPLOADS/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $file_name = uniqid('IMG_') . '.' . pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
        $dest_path = $upload_dir . $file_name;
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $dest_path)) {
            $image_url = $dest_path;
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

// 4a. Mes Groupes
$groupes_stmt = $pdo->prepare("
    SELECT d.id_discussion, r.nom as resto_nom 
    FROM discussion d 
    JOIN participant_discussion pd ON d.id_discussion = pd.id_discussion 
    JOIN session s ON d.id_session = s.id_session 
    JOIN restaurant r ON s.id_restaurant = r.id_restaurant 
    WHERE pd.id_user = ? AND r.nom LIKE ?
");
$groupes_stmt->execute([$id_user_connecte, $search_param]);
$mes_groupes = $groupes_stmt->fetchAll();

// 4b. Messages Privés (Actifs)
$prives_stmt = $pdo->prepare("
    SELECT d.id_discussion, p.prenom, p.photo
    FROM discussion d
    JOIN participant_discussion pd1 ON d.id_discussion = pd1.id_discussion
    JOIN participant_discussion pd2 ON d.id_discussion = pd2.id_discussion
    JOIN profil p ON pd2.id_user = p.id_user
    WHERE pd1.id_user = ? AND pd2.id_user != ? AND d.id_session IS NULL AND p.prenom LIKE ?
");
$prives_stmt->execute([$id_user_connecte, $id_user_connecte, $search_param]);
$mes_prives = $prives_stmt->fetchAll();

// 4c. Démarrer une discussion (Contacts filtrés pour éviter les doublons)
$contacts_stmt = $pdo->prepare("
    SELECT id_user, prenom, photo 
    FROM profil 
    WHERE id_user != ? 
    AND prenom LIKE ? 
    AND id_user NOT IN (
        SELECT pd2.id_user
        FROM discussion d
        JOIN participant_discussion pd1 ON d.id_discussion = pd1.id_discussion
        JOIN participant_discussion pd2 ON d.id_discussion = pd2.id_discussion
        WHERE pd1.id_user = ? AND d.id_session IS NULL
    )
    LIMIT 15
");
$contacts_stmt->execute([$id_user_connecte, $search_param, $id_user_connecte]);
$tous_les_contacts = $contacts_stmt->fetchAll();

// --- 5. INFOS DU CHAT ACTUEL ET MESSAGES ---
$query = $pdo->prepare("
    SELECT d.*, r.nom AS resto_nom, r.photo AS resto_photo, s.date_session,
    (SELECT p.prenom FROM profil p JOIN participant_discussion pd ON p.id_user = pd.id_user WHERE pd.id_discussion = d.id_discussion AND p.id_user != ? LIMIT 1) as nom_ami,
    (SELECT p.photo FROM profil p JOIN participant_discussion pd ON p.id_user = pd.id_user WHERE pd.id_discussion = d.id_discussion AND p.id_user != ? LIMIT 1) as photo_ami
    FROM discussion d
    LEFT JOIN session s ON d.id_session = s.id_session
    LEFT JOIN restaurant r ON s.id_restaurant = r.id_restaurant
    WHERE d.id_discussion = ?
");
$query->execute([$id_user_connecte, $id_user_connecte, $id_discussion_actuelle]);
$chat_info = $query->fetch(PDO::FETCH_ASSOC);

$is_prive = is_null($chat_info['id_session'] ?? null);
$titre_chat = $is_prive ? ($chat_info['nom_ami'] ?? "Chat Privé") : ($chat_info['resto_nom'] ?? "Groupe");
$photo_chat = $is_prive ? ($chat_info['photo_ami'] ?? 'IMAGES/default.png') : ($chat_info['resto_photo'] ?? 'IMAGES/logo_groupe.png');

$msg_query = $pdo->prepare("SELECT m.*, p.prenom, p.photo FROM message m JOIN profil p ON m.id_user = p.id_user WHERE m.id_discussion = ? ORDER BY m.date_envoi ASC");
$msg_query->execute([$id_discussion_actuelle]);
$messages = $msg_query->fetchAll(PDO::FETCH_ASSOC);
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

    <div id="settingsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="toggleSettings()">&times;</span>
            <h3>Paramètres</h3>
            
            <div class="setting-item">
                <span>Notifications</span>
                <label class="switch">
                    <input type="checkbox" id="notifToggle" checked onchange="updateBell()">
                    <span class="slider"></span>
                </label>
            </div>

            <div class="group-info-card">
                <?php if (!$is_prive && $chat_info): ?>
                    <p><i class="fa-solid fa-utensils"></i> <?php echo htmlspecialchars($chat_info['resto_nom']); ?></p>
                    <p><i class="fa-solid fa-calendar"></i> <?php echo date('d/m/Y', strtotime($chat_info['date_session'])); ?></p>
                <?php elseif ($is_prive && $chat_info): ?>
                    <p>Discussion privée avec <?php echo htmlspecialchars($chat_info['nom_ami']); ?></p>
                <?php endif; ?>
            </div>

            <form method="POST">
                <button type="submit" name="action_quitter" class="leave-btn">Quitter la discussion</button>
            </form>
        </div>
    </div>

    <aside class="sidebar">
        <div class="logo-container"><img src="IMAGES/logoinverse.png"></div>
        <form class="search-container" method="GET" action="chat.php">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" name="search" class="search-bar" placeholder="Rechercher..." value="<?php echo htmlspecialchars($search); ?>">
        </form>
        
        <div class="discussion-list">
            <p class="section-title">Mes Groupes</p>
            <?php foreach ($mes_groupes as $g): ?>
                <a href="chat.php?id=<?php echo $g['id_discussion']; ?>" class="discussion-item <?php echo ($g['id_discussion'] == $id_discussion_actuelle) ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($g['resto_nom']); ?>
                </a>
            <?php endforeach; ?>

            <p class="section-title">Messages Privés</p>
            <?php foreach ($mes_prives as $p): ?>
                <a href="chat.php?id=<?php echo $p['id_discussion']; ?>" class="discussion-item <?php echo ($p['id_discussion'] == $id_discussion_actuelle) ? 'active' : ''; ?>">
                    <div class="user-row">
                        <img src="<?php echo $p['photo']; ?>" class="mini-avatar">
                        <span><?php echo htmlspecialchars($p['prenom']); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>

            <p class="section-title">Démarrer une discussion</p>
            <?php foreach ($tous_les_contacts as $c): ?>
                <a href="chat.php?contact_id=<?php echo $c['id_user']; ?>" class="discussion-item">
                    <div class="user-row" style="opacity: 0.8;">
                        <img src="<?php echo $c['photo']; ?>" class="mini-avatar">
                        <span><?php echo htmlspecialchars($c['prenom']); ?></span>
                        <i class="fa-solid fa-plus" style="margin-left: auto; font-size: 10px;"></i>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </aside>

    <main class="chat-main">
        <header class="chat-header">
            <div class="header-info">
                <img src="<?php echo $photo_chat; ?>" class="resto-photo-header">
                <h2><?php echo htmlspecialchars($titre_chat); ?></h2>
            </div>
            <div class="header-icons">
                <i id="bellIcon" class="fa-regular fa-bell" onclick="quickBellToggle()"></i>
                <i class="fa-solid fa-gear" onclick="toggleSettings()"></i>
            </div>
        </header>

        <section class="messages-container" id="chatBox">
            <?php if (empty($messages)): ?>
                <div style="text-align: center; margin-top: 50px; opacity: 0.5;">Commencez la conversation...</div>
            <?php endif; ?>
            <?php foreach ($messages as $m): ?>
                <div class="message-row <?php echo ($m['id_user'] == $id_user_connecte) ? 'me' : 'others'; ?>">
                    <img src="<?php echo $m['photo']; ?>" class="avatar-msg">
                    <div class="bubble-wrapper">
                        <div class="bubble">
                            <?php if ($m['image_url']): ?><img src="<?php echo $m['image_url']; ?>" class="chat-image"><?php endif; ?>
                            <?php echo htmlspecialchars($m['contenu']); ?>
                            <span class="msg-time"><?php echo date('H:i', strtotime($m['date_envoi'])); ?></span>
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
            m.style.display = (m.style.display === "block") ? "none" : "block";
        }

        function updateBell() {
            const isChecked = document.getElementById('notifToggle').checked;
            const bell = document.getElementById('bellIcon');
            bell.className = isChecked ? "fa-regular fa-bell" : "fa-solid fa-bell-slash";
        }

        function quickBellToggle() {
            const checkbox = document.getElementById('notifToggle');
            checkbox.checked = !checkbox.checked;
            updateBell();
        }
    </script>
</body>
</html>