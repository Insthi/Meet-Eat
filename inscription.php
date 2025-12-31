<?php
session_start();
require 'db.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "INSERT INTO users (email, mot_de_passe, date_creation)
             VALUES (?, ?, NOW())"
        );

        try {
            $stmt->execute([$email, $hash]);
            $id_user = $pdo->lastInsertId();

            // Création du profil vide associé
            $pdo->prepare(
                "INSERT INTO profils (id_user) VALUES (?)"
            )->execute([$id_user]);

            $_SESSION['id_user'] = $id_user;
            header('Location: profil.php');
            exit;

        } catch (PDOException $e) {
            $error = "Cet email est déjà utilisé";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription – MeatEat</title>
</head>
<body>

<h1>Inscription</h1>

<?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mot de passe</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">S'inscrire</button>
</form>

<p>Déjà un compte ?
    <a href="login.php">Se connecter</a>
</p>

</body>
</html>
