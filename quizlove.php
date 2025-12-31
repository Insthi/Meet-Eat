<?php
// Connexion à la base de données Meet-Eat
$host = 'localhost';
$dbname = 'Meet-Eat';
$user = 'root';
$pass = 'root'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération de l'ID de la question actuelle
$id_question = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Compte le nombre total de questions pour le quiz Amour
$total_query = $pdo->query("SELECT COUNT(*) FROM quiz_amour");
$total_questions = $total_query->fetchColumn();

// Si l'utilisateur a dépassé la dernière question, direction la page de validation
if ($id_question > $total_questions) {
    header("Location: validationlove.php");
    exit;
}

// Récupération de la question actuelle
$query = $pdo->prepare("SELECT * FROM quiz_amour WHERE id_question = ?");
$query->execute([$id_question]);
$question = $query->fetch();

// Sécurité au cas où l'ID est invalide
if (!$question) {
    header("Location: validationlove.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet & Eat - Quiz Amour</title>
    <link rel="stylesheet" href="quiz_love.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>
<body>

    <div class="header-logo">
        <a href="choix.php">
            <img src="IMAGES/logomeeteat.png?v=2" alt="Logo">
        </a>
    </div>

    <main class="quiz-container">
        
        <div class="progress-info">
            QUESTION <?php echo $id_question; ?> SUR <?php echo $total_questions; ?>
        </div>

        <h1 class="question-display">
            <?php echo htmlspecialchars($question['question']); ?>
        </h1>

        <form action="quizlove.php?id=<?php echo $id_question + 1; ?>" method="POST" class="quiz-form">
            <div class="options-wrapper">
                
                <label class="option-card">
                    <input type="radio" name="choix" value="1" required>
                    <div class="design-pill"><?php echo htmlspecialchars($question['choix_1']); ?></div>
                </label>

                <label class="option-card">
                    <input type="radio" name="choix" value="2">
                    <div class="design-pill"><?php echo htmlspecialchars($question['choix_2']); ?></div>
                </label>

                <label class="option-card">
                    <input type="radio" name="choix" value="3">
                    <div class="design-pill"><?php echo htmlspecialchars($question['choix_3']); ?></div>
                </label>

            </div>

            <div class="form-actions" style="display: flex; justify-content: center; align-items: center; gap: 20px; margin-top: 30px;">
                <?php if ($id_question > 1): ?>
                    <a href="quizlove.php?id=<?php echo $id_question - 1; ?>" class="btn-retour">Question précédente</a>
                <?php endif; ?>
                
                <button type="submit" class="btn-valider">Valider</button>
            </div>
        </form>

    </main>

    <img src="IMAGES/a-votre-sante.png" alt="" class="bg-decoration">

</body>
</html>