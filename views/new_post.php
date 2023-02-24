<?php

session_start();

if (isset($_SESSION['user_id'])) {
    require_once 'nav.php';
    $allCat = allCategorie($bdd);
?>


    <main>
        <section id="create-post">
            <h1>Créer un nouveau post</h1>
            <form action="../moteur/new_post.php" method="POST" id='form-post' enctype="multipart/form-data">
                <div class="form-control">
                    <label for="titre">Titre</label>
                    <input type="text" name="titre" id="titre">
                    <!-- <small>Username must be at least 3 characters</small> -->
                </div>
                <div class="form-control">
                    <label for="prenom">Categorie</label>
                    <select name="categorie" id="categorie">
                        <?php foreach ($allCat as $cat) { ?>
                            <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                        <?php } ?>
                    </select>
                    <!-- <small>Username must be at least 3 characters</small> -->
                </div>
                <div class="form-control">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image">
                </div>
                <div class="form-control">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" cols="30" rows="10"></textarea>
                </div>
                <button type="submit" class="btn">Enregistrer</button>
            </form>
        </section>
    </main>
<?php



    require_once 'footer.php';
} else {
    header('Location:../moteur/destroy.php');
}
?>