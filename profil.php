<?php
session_start();
require 'db.php'; // Connexion PDO

if(!isset($_SESSION['id_user'])){
    header('Location: login.php');
    exit;
}

// Récupération du profil
$stmt = $pdo->prepare("SELECT * FROM users JOIN profils ON users.id_user = profils.id_user WHERE users.id_user = ?");
$stmt->execute([$_SESSION['id_user']]);
$profil = $stmt->fetch();

// Hobbies
$hobbies = $pdo->query("SELECT * FROM hobbies")->fetchAll();
$userHobbies = $pdo->prepare("SELECT id_hobby FROM profils_hobbies WHERE id_user = ?");
$userHobbies->execute([$_SESSION['id_user']]);
$userHobbies = $userHobbies->fetchAll(PDO::FETCH_COLUMN);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>MeetEat — Profil</title>
  <link rel="stylesheet" href="profil_styles.css">
</head>
<body>
<div class="bg-qm"></div>
<div class="page">
  <header>
    <div class="brand">
      <div class="mark">M</div>
      <div><small>MEET</small><small>EAT</small></div>
    </div>
    <div class="top-actions">
      <div class="icon-user" title="Compte">👤</div>
      <button class="btn dark" onclick="window.location.href='logout.php'">Se déconnecter</button>
    </div>
  </header>

  <main>
    <div class="profile">
      <div class="avatar-wrap" id="avatarWrap">
        <img id="avatarImg" src="<?= htmlspecialchars($profil['photo'] ?: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=500&q=70') ?>" alt="Photo de profil"/>
        <button class="icon-btn" id="editPhotoBtn" title="Modifier la photo">✎</button>
      </div>
      <div>
        <h1>
          Bienvenue, 
          <span id="fullName"><?= htmlspecialchars($profil['prenom'] . ' ' . $profil['nom']) ?></span> !
          <button class="icon-btn small" data-field="prenom" data-last="<?= htmlspecialchars($profil['prenom']) ?>">✎</button>
          <button class="icon-btn small" data-field="nom" data-last="<?= htmlspecialchars($profil['nom']) ?>">✎</button>
        </h1>
        <div class="sub">
          <span class="badge" id="ville"><?= htmlspecialchars($profil['ville'] ?? '-') ?></span>
          <button class="icon-btn small" data-field="ville" data-last="<?= htmlspecialchars($profil['ville'] ?? '') ?>">✎</button>
          <span class="badge" id="relation"><?= htmlspecialchars($profil['relation'] ?? '-') ?></span>
          <button class="icon-btn small" data-field="relation" data-last="<?= htmlspecialchars($profil['relation'] ?? '') ?>">✎</button>
          <?php if($userHobbies): ?>
            <?php foreach($userHobbies as $id): ?>
              <?php
                $h = array_filter($hobbies, fn($h) => $h['id_hobby']==$id);
                $h = array_values($h)[0] ?? null;
                if($h) echo '<span class="badge">'.htmlspecialchars($h['nom_hobby']).'</span>';
              ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="hr"></div>

    <section>
      <div class="section-head">
        <div class="section-title">Biographie</div>
        <button class="icon-btn" id="editBioBtn">✎</button>
      </div>
      <div class="bio-card">
        <textarea id="bioText" disabled><?= htmlspecialchars($profil['biographie'] ?? '') ?></textarea>
      </div>
    </section>

    <section>
      <div class="section-head">
        <div class="section-title">Sécurité</div>
      </div>
      <div class="panel">
        <div class="chips" style="grid-template-columns:1fr 1fr; gap:12px;">
          <div class="chip" style="align-items:center;">
            <span style="opacity:.8">ⓘ</span>
            <input type="email" id="emailField" value="<?= htmlspecialchars($profil['email']) ?>" disabled style="border:0;outline:0;background:transparent;width:100%;font-size:10px;color:var(--ink)"/>
            <button class="icon-btn small" data-field="email" data-last="<?= htmlspecialchars($profil['email']) ?>">✎</button>
          </div>
        </div>
      </div>
    </section>
  </main>
</div>

<script>
// Modifier bio
document.getElementById('editBioBtn').addEventListener('click', ()=>{
  const bio = document.getElementById('bioText');
  bio.disabled = !bio.disabled;
  if(!bio.disabled){
    bio.focus();
  } else {
    // Envoyer via fetch/AJAX à save_bio.php
    fetch('save_profile.php', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify({field:'biographie', value: bio.value})
    }).then(r=>r.json()).then(d=>{ if(d.success) alert("✅ Biographie mise à jour"); });
  }
});

// Modifier champs un par un
document.querySelectorAll('button.icon-btn.small').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    const field = btn.dataset.field;
    const last = btn.dataset.last;
    let newVal = prompt("Modifier "+field, last);
    if(newVal !== null){
      btn.dataset.last = newVal;
      // Mettre à jour l'affichage
      if(field==='prenom' || field==='nom'){
        const prenom = field==='prenom'?newVal:document.querySelector('[data-field="prenom"]').dataset.last;
        const nom = field==='nom'?newVal:document.querySelector('[data-field="nom"]').dataset.last;
        document.getElementById('fullName').textContent = prenom + ' ' + nom;
      } else {
        document.getElementById(field).textContent = newVal;
      }
      // Envoyer à PHP
      fetch('save_profile.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({field, value:newVal})
      }).then(r=>r.json()).then(d=>{ if(d.success) console.log(field+" sauvegardé") });
    }
  });
});

// Modifier photo
document.getElementById('editPhotoBtn').addEventListener('click', ()=>{
  const url = prompt("Nouvelle URL de la photo");
  if(url){
    document.getElementById('avatarImg').src = url;
    fetch('save_profile.php',{
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify({field:'photo', value:url})
    }).then(r=>r.json()).then(d=>{ if(d.success) alert("✅ Photo mise à jour"); });
  }
});
</script>
</body>
</html>
