<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['id_user'];
$message = "";

// 1. Récupération des données actuelles
$stmt = $pdo->prepare("SELECT u.email, p.* FROM user u JOIN profil p ON u.id_user = p.id_user WHERE u.id_user = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // 2. Gestion de la Photo
        $photo_url = $_POST['current_photo'];
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['photo']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                $new_name = "profile_" . $id_user . "_" . time() . "." . $ext;
                if (!is_dir('UPLOADS')) mkdir('UPLOADS', 0777, true);
                if (move_uploaded_file($_FILES['photo']['tmp_name'], "UPLOADS/" . $new_name)) {
                    $photo_url = $new_name;
                }
            }
        }

        // 3. Mise à jour de la table USER (pour l'email)
        $stmt1 = $pdo->prepare("UPDATE user SET email = ? WHERE id_user = ?");
        $stmt1->execute([$_POST['email'], $id_user]);

        // 4. Mise à jour de la table PROFIL
        $stmt2 = $pdo->prepare("UPDATE profil SET 
            nom = ?, 
            prenom = ?, 
            photo_url = ?, 
            religion = ?, 
            genre = ?, 
            biographie = ? 
            WHERE id_user = ?");
        
        $stmt2->execute([
            $_POST['nom'],
            $_POST['prenom'],
            $photo_url,
            $_POST['religion'],
            $_POST['genre'],
            $_POST['biographie'],
            $id_user
        ]);

        $pdo->commit();
        header("Location: profil.php?success=1");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        $message = "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon Profil</title>
    <link rel="stylesheet" href="profil.css">
    <style>
        .edit-container { max-width: 600px; margin: 30px auto; background: white; padding: 25px; border-radius: 15px; shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { font-weight: bold; display: block; margin-bottom: 5px; color: #660601; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; }
        .btn-submit { background: #660601; color: white; border: none; padding: 15px; width: 100%; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .current-img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; border: 2px solid #660601; }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2 style="color:#660601; text-align:center;">Modifier mes informations</h2>

        <form method="POST" enctype="multipart/form-data">
            <div style="text-align: center;">
                <img src="UPLOADS/<?= htmlspecialchars($user['photo_url'] ?: 'default.png') ?>" class="current-img" alt="Photo">
                <input type="hidden" name="current_photo" value="<?= htmlspecialchars($user['photo_url']) ?>">
                <div class="form-group">
                    <label>Changer la photo</label>
                    <input type="file" name="photo">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Religion</label>
                    <select name="religion">
                        <option value="Chrétien" <?= $user['religion']=='Chrétien'?'selected':'' ?>>Chrétien</option>
                        <option value="Musulman" <?= $user['religion']=='Musulman'?'selected':'' ?>>Musulman</option>
                        <option value="Juif" <?= $user['religion']=='Juif'?'selected':'' ?>>Juif</option>
                        <option value="Bouddhiste" <?= $user['religion']=='Bouddhiste'?'selected':'' ?>>Bouddhiste</option>
                        <option value="Athée" <?= $user['religion']=='Athée'?'selected':'' ?>>Athée</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Genre</label>
                    <select name="genre">
                        <option value="Homme" <?= $user['genre']=='Homme'?'selected':'' ?>>Homme</option>
                        <option value="Femme" <?= $user['genre']=='Femme'?'selected':'' ?>>Femme</option>
                        <option value="Autre" <?= $user['genre']=='Autre'?'selected':'' ?>>Autre</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Biographie</label>
                <textarea name="biographie" rows="4"><?= htmlspecialchars($user['biographie']) ?></textarea>
            </div>

            <button type="submit" class="btn-submit">Sauvegarder les changements</button>
            <a href="profil.php" style="display:block; text-align:center; margin-top:10px; color:#660601; text-decoration:none;">Annuler</a>
        </form>
    </div>
</body>
</html>