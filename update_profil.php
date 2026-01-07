<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['id_user'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // 1. Gestion de la Photo
        $photo_url = $_POST['current_photo'];
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $new_name = "profile_" . $id_user . "_" . time() . "." . $ext;
            if (!is_dir('UPLOADS')) mkdir('UPLOADS', 0777, true);
            if (move_uploaded_file($_FILES['photo']['tmp_name'], "UPLOADS/" . $new_name)) {
                $photo_url = $new_name;
            }
        }

        // 2. Mise à jour de l'email (Table USER)
        $stmt1 = $pdo->prepare("UPDATE user SET email = ? WHERE id_user = ?");
        $stmt1->execute([$_POST['email'], $id_user]);

        // 3. Mise à jour des infos (Table PROFIL) 
        $stmt2 = $pdo->prepare("UPDATE profil SET 
            nom = ?, prenom = ?, biographie = ?, ville = ?, 
            metier = ?, genre = ?, orientation = ?, 
            type_relation = ?, taille = ?, religion = ?, photo_url = ? 
            WHERE id_user = ?");
        
        $stmt2->execute([
            $_POST['nom'], $_POST['prenom'], $_POST['biographie'], $_POST['ville'],
            $_POST['metier'], $_POST['genre'], $_POST['orientation'],
            $_POST['type_relation'], $_POST['taille'], $_POST['religion'],
            $photo_url, $id_user
        ]);

        $pdo->commit();
        header('Location: profil.php');
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $message = "Erreur : " . $e->getMessage();
    }
}

// Récupération des données pour remplir le formulaire
$stmt = $pdo->prepare("SELECT u.email, p.* FROM user u JOIN profil p ON u.id_user = p.id_user WHERE u.id_user = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Modifier Profil - Meet&Eat</title>
    <link rel="stylesheet" href="profil.css">
    <style>
        .edit-container { max-width: 600px; margin: 20px auto; background: white; padding: 25px; border-radius: 15px; border: 2px solid #660601; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; color: #660601; font-weight: bold; margin-bottom: 5px; }
        input, textarea, select { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; box-sizing: border-box; }
        .taille-val { color: #660601; font-weight: bold; float: right; }
        .btn-submit { background: #660601; color: white; border: none; padding: 15px; width: 100%; border-radius: 25px; cursor: pointer; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body style="background-color: #FFFAED;">
    <div class="edit-container">
        <h2 style="color: #660601; text-align: center;">Modifier mon profil public</h2>
        
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="current_photo" value="<?= htmlspecialchars($user['photo_url'] ?? '') ?>">
            
            <div style="text-align:center; margin-bottom:20px;">
                <img src="UPLOADS/<?= $user['photo_url'] ?: 'default.png' ?>" style="width:100px; height:100px; border-radius:50%; border:2px solid #660601; object-fit: cover;"><br>
                <input type="file" name="photo" style="margin-top:10px; border:none;">
            </div>

            <div class="form-group">
                <label>Prénom / Nom</label>
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
                    <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="form-group">
                <label>Ma taille : <span id="taille_display" class="taille-val"><?= $user['taille'] ?: '170' ?> cm</span></label>
                <input type="range" name="taille" min="140" max="220" value="<?= $user['taille'] ?: '170' ?>" 
                       oninput="document.getElementById('taille_display').innerText = this.value + ' cm'">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Ville</label>
                    <input type="text" name="ville" list="villes" value="<?= htmlspecialchars($user['ville']) ?>">
                    <datalist id="villes">
                        <option value="Paris"><option value="Lyon"><option value="Marseille"><option value="Bordeaux">
                    </datalist>
                </div>

                <div class="form-group">
                    <label>Métier</label>
                    <input type="text" name="metier" list="metiers" value="<?= htmlspecialchars($user['metier']) ?>">
                    <datalist id="metiers">
                        <option value="Étudiant"><option value="Cadre"><option value="Artisan"><option value="Freelance">
                    </datalist>
                </div>

                <div class="form-group">
                    <label>Religion</label>
                    <select name="religion">
                        <option value="Non renseigné" <?= $user['religion']=='Non renseigné'?'selected':'' ?>>Préfère ne pas dire</option>
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
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Biographie</label>
                <textarea name="biographie" rows="3"><?= htmlspecialchars($user['biographie']) ?></textarea>
            </div>

            <input type="hidden" name="orientation" value="<?= $user['orientation'] ?>">
            <input type="hidden" name="type_relation" value="<?= $user['type_relation'] ?>">

            <button type="submit" class="btn-submit">Sauvegarder les changements</button>
            <a href="profil.php" style="display:block; text-align:center; margin-top:10px; color:#660601; text-decoration:none;">Annuler</a>
        </form>
    </div>
</body>
</html>