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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        // 1. Mise à jour de l'Email
        $stmt = $pdo->prepare("UPDATE user SET email = ? WHERE id_user = ?");
        $stmt->execute([$new_email, $id_user]);
        $message = "Email mis à jour avec succès ! ";

        // 2. Mise à jour du Mot de passe (seulement si rempli)
        if (!empty($new_password)) {
            if ($new_password === $confirm_password) {
                // On hache le mot de passe pour la sécurité
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt2 = $pdo->prepare("UPDATE user SET password = ? WHERE id_user = ?");
                $stmt2->execute([$hashed_password, $id_user]);
                $message .= "Mot de passe modifié.";
            } else {
                $error = "Les mots de passe ne correspondent pas.";
            }
        }
    } catch (Exception $e) {
        $error = "Erreur : " . $e->getMessage();
    }
}

// On récupère l'email actuel
$stmt = $pdo->prepare("SELECT email FROM user WHERE id_user = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Modifier mes accès - Meet&Eat</title>
    <style>
        body { font-family: sans-serif; background-color: #FFFAED; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .access-container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; border: 2px solid #660601; }
        h2 { color: #660601; text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #660601; }
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; }
        .btn-save { background: #660601; color: white; border: none; padding: 12px; width: 100%; border-radius: 25px; cursor: pointer; font-weight: bold; margin-top: 10px; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #660601; text-decoration: none; font-size: 0.9em; }
        .msg { padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="access-container">
    <h2>Modifier mes accès</h2>

    <?php if($message): ?> <div class="msg success"><?= $message ?></div> <?php endif; ?>
    <?php if($error): ?> <div class="msg error"><?= $error ?></div> <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nouvel Email</label>
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

        <button type="submit" class="btn-save">Mettre à jour mes accès</button>
        <a href="profil.php" class="btn-back">Retour au profil</a>
    </form>
</div>

</body>
</html>