<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['id_user'];
$message = "";
$error = "";

// Récupération des infos actuelles pour pré-remplir le formulaire
$stmt = $pdo->prepare("SELECT email FROM user WHERE id_user = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_email = trim($_POST['email']);
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        $pdo->beginTransaction();

        // 1. Mise à jour de l'Email
        $stmt = $pdo->prepare("UPDATE user SET email = ? WHERE id_user = ?");
        $stmt->execute([$new_email, $id_user]);
        $message = "Email mis à jour avec succès. ";

        // 2. Mise à jour du Mot de passe (seulement si rempli)
        if (!empty($new_password)) {
            if ($new_password === $confirm_password) {
                if (strlen($new_password) >= 6) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    // Correction ici : la colonne s'appelle 'mot_de_passe'
                    $stmt2 = $pdo->prepare("UPDATE user SET mot_de_passe = ? WHERE id_user = ?");
                    $stmt2->execute([$hashed_password, $id_user]);
                    $message .= "Mot de passe modifié.";
                } else {
                    $error = "Le mot de passe doit faire au moins 6 caractères.";
                }
            } else {
                $error = "Les mots de passe ne correspondent pas.";
            }
        }

        if (empty($error)) {
            $pdo->commit();
        } else {
            $pdo->rollBack();
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = "Erreur lors de la mise à jour : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mes accès</title>
    <link rel="stylesheet" href="profil.css">
    <style>
        .access-container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #660601; }
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; }
        .btn-submit { background: #660601; color: white; border: none; padding: 12px; width: 100%; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 10px; }
        .msg { padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #660601; text-decoration: none; }
    </style>
</head>
<body>
    <div class="access-container">
        <h2>Modifier mes accès</h2>

        <?php if($message): ?> <div class="msg success"><?= $message ?></div> <?php endif; ?>
        <?php if($error): ?> <div class="msg error"><?= $error ?></div> <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
            <p style="font-size: 0.8em; color: #666;">Laissez vide pour ne pas changer le mot de passe</p>

            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <input type="password" name="password">
            </div>

            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="confirm_password">
            </div>

            <button type="submit" class="btn-submit">Sauvegarder</button>
            <a href="profil.php" class="back-link">Retour au profil</a>
        </form>
    </div>
</body>
</html>