<?php

session_start();
require_once 'nav.php';
$id = $_GET['id'];
$articleById = [];
if (preg_match('#^([0-9]+)$#', $id, $matches)) {
    $id = intval($matches[1]);
    $articleById = articleById($bdd, $id);
}

if (isset($_SESSION['user_id']) && !empty($articleById) && $_SESSION['user_id'] === $articleById['user_id']) {
    $allCat = allCategorie($bdd);
?>
    <main>
        <section id="update-post">
            <h1>Modifier votre post</h1>
            <form action="../moteur/update_post.php" method="POST" id='form-post' enctype="multipart/form-data">
                <div class="form-control">
                    <label for="titre">Titre</label>
                    <input type="text" name="titre" id="titre" value="<?= $articleById['title'] ?>">
                    <!-- <small>Username must be at least 3 characters</small> -->
                </div>
                <div class="form-control">
                    <label for="categorie">Categorie</label>
                    <select name="categorie" id="categorie">
                        <?php foreach ($allCat as $cat) { ?>
                            <option value="<?= $cat['id'] ?>" <?= $cat['name'] === $articleById['name'] ? 'selected' : '' ?>><?= $cat['name'] ?></option>
                        <?php } ?>
                    </select>
                    <!-- <small>Username must be at least 3 characters</small> -->
                </div>
                <img src="../public/img/article/<?= $articleById['image'] ?>" alt="Une image de Rubik's cube">
                <div class="form-control">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image">
                </div>
                <div class=" form-control">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" cols="30" rows="10"><?= $articleById['description'] ?></textarea>
                </div>
                <input type="hidden" name="oldImage" value="<?= $articleById['image'] ?>">
                <input type="hidden" name="articleId" value="<?= $id ?>">
                <button type="submit" class="btn">Modifier</button>
            </form>
        </section>
    </main>
<?php



    require_once 'footer.php';
} else {
    header('Location:../moteur/destroy.php');
}
?>