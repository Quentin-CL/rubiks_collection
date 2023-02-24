<?php

session_start();

require_once 'nav.php';
?>


<main>
    <section id="create-account">
        <h1>Créer votre compte</h1>
        <form action="../moteur/create_account_post.php" method="POST" id='form-account' onsubmit="return validateForm()">
            <div class="form-control">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom">
                <small>Username must be at least 3 characters</small>
            </div>
            <div class="form-control">
                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" id="prenom">
                <small>Username must be at least 3 characters</small>
            </div>
            <div class="form-control">
                <label for="email">E-mail</label>
                <input type="mail" name="email" id="email">
                <small>Username must be at least 3 characters</small>
            </div>
            <div class="form-control">
                <label for="pass">Mot de passe</label>
                <input type="password" name="pass" id="pass">
                <small>Username must be at least 3 characters</small>
            </div>
            <div class="form-control">
                <label for="pass-confirmation">Confirmer votre mot de passe</label>
                <input type="password" name="pass-confirmation" id="pass-confirmation">
                <small>Username must be at least 3 characters</small>
            </div>
            <button type="submit" class="btn">Enregistrer</button>
        </form>
        <a href="login.php">Vous avez déja un compte ? Connectez-vous !</a>
    </section>
</main>
<?php



require_once 'footer.php';

?>