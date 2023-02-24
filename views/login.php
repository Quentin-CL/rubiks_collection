<?php

session_start();

require_once 'nav.php';
?>


<main>
    <section id="login">
        <h1>Connectez-vous à votre compte</h1>
        <form action="../moteur/login_post.php" onsubmit="return validateLogingForm();" method="POST" name="loginForm">
            <div>
                <label for="email">E-mail</label>
                <input type="mail" name="email" id="email">
            </div>
            <div>
                <label for="pass">Mot de passe</label>
                <input type="password" name="pass" id="pass">
            </div>
            <input type="submit" class="btn" value="Connexion">
            <span id="errorMessages"></span>
        </form>
        <a href="create_account.php">Créer un compte</a>
    </section>
</main>
<?php



require_once 'footer.php';

?>