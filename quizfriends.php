<?php
session_start();

$host = 'localhost'; 
$dbname = 'v2meet-eat'; 
$user = 'root'; 
$pass = ''; 

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4", 
        $user, 
        $pass, 
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) { 
    die("Erreur de connexion : " . $e->getMessage()); 
}

/* --- PROGRESSION --- */

$id_question = isset($_GET['q']) ? (int)$_GET['q'] : 0;

$total_questions = $pdo->query("SELECT COUNT(*) FROM quiz_amitie")->fetchColumn();

if ($id_question === 0) { 
    $_SESSION['reponses_amitie'] = []; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['choix'])) {
    $id_repondue = $id_question - 1;

    if ($id_repondue >= 1) { 
        $_SESSION['reponses_amitie'][$id_repondue] = $_POST['choix']; 
    }
}

/* --- RÉCUPÉRATION --- */

$requete = $pdo->prepare("SELECT * FROM quiz_amitie WHERE id_question = ?");
$requete->execute([$id_question]);
$question = $requete->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet-Eat – Quiz Amitié</title>
    <link rel="stylesheet" href="quiz_styles.css">
</head>

<body class="theme-amitie">

    <div class="header-logo">
        <a href="choix.php">
            <img src="IMAGES/logomeeteat_inverse.png" alt="Logo">
        </a>
    </div>

    <main class="quiz-container">

        <?php if ($id_question === 0) : ?>

            <h1 class="question-display" style="font-size: 1.3rem; font-weight: 400; text-align: left;">
                En répondant à ces quelques questions sur vos préférences culinaires 
                et vos envies de rencontre amicale, vous nous permettez de vous 
                proposer des profils qui font sens pour vous.
            </h1>

            <a href="quizfriends.php?q=1" class="btn-main" style="width: 250px; margin: 0 auto;">
                Je me lance !
            </a>

        <?php elseif ($id_question > 0 && !$question) : ?>

            <div class="validation-box">
                <h1 class="question-display" style="font-size: 2.2rem; margin-bottom: 20px;">Vos réponses ont bien été enregistrées !</h1>
                
                <p class="congrats-text" style="font-size: 1.3rem; line-height: 1.6; margin-bottom: 50px;">
                    Nous avons tout ce qu’il faut <br>
                    pour vous faire correspondre au mieux avec nos utilisateurs.
                </p>

                <div class="form-actions" style="flex-direction: column; gap: 20px;">
                    <a href="reservation.php" class="btn-main">Réserver maintenant</a>
                    <a href="index.php" class="btn-sub">Continuer ma visite</a>
                </div>
            </div>

        <?php else : ?>

            <div class="progress-info">
                QUESTION <?= $id_question ?> SUR <?= $total_questions ?>
            </div>

            <div class="progression-bar-container">
                <div class="bar-bg">
                    <?php $pourcentage = ($id_question / $total_questions) * 100; ?>
                    <div class="bar-fill" style="width: <?= $pourcentage ?>%;"></div>
                </div>
            </div>

            <h1 class="question-display">
                <?= htmlspecialchars($question['question']) ?>
            </h1>

            <form method="POST" action="quizfriends.php?q=<?= $id_question + 1 ?>" autocomplete="off">
                
                <div class="options-wrapper">

                    <?php for($i=1; $i<=3; $i++): ?>
                        <?php if(!empty($question["choix_$i"])): ?>
                            
                            <label class="option-card">
                                <input type="radio" name="choix" value="<?= $i ?>" 
                                    <?= (($_SESSION['reponses_amitie'][$id_question] ?? null) == $i) ? 'checked' : '' ?> 
                                    required>
                                <div class="design-pill">
                                    <?= htmlspecialchars($question["choix_$i"]) ?>
                                </div>
                            </label>

                        <?php endif; ?>
                    <?php endfor; ?>

                </div>

                <div class="form-actions">
                    <?php if ($id_question > 1) : ?>
                        <a href="quizfriends.php?q=<?= $id_question - 1 ?>" class="btn-sub">
                            Question précédente
                        </a>
                    <?php else : ?>
                        <a href="quizfriends.php?q=0" class="btn-sub">
                            Précédent
                        </a>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn-main">
                        <?= ($id_question == $total_questions) ? "Valider" : "Suivant" ?>
                    </button>
                </div>

            </form>

        <?php endif; ?>

    </main>

    <img src="IMAGES/pizza.png" alt="" class="bg-decor">

</body>
</html>