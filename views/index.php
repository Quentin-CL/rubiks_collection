<?php

session_start();
require_once 'nav.php';
$lastInsertArticle = lastInsertArticle($bdd);
?>


<header id="header-acceuil">
    <h1>La plus grande collection de Rubik's cube en ligne</h1>
    <h2>Partagez, echangez et vendez vos plus belles trouvailles</h2>
</header>
<main>
    <section id="last-posts">
        <h3>Les derniers Rubik's Cube ajoutés</h3>
        <div class="last-post-container">
            <?php foreach ($lastInsertArticle as $article) { ?>
                <a href="./show.php?id=<?= $article['id'] ?>">
                    <article>
                        <div class="card-image"><img src="../public/img/article/<?= $article['image'] ?>" alt="Une image de Rubik's cube"></div>
                        <p class="title"><?= $article['title'] ?></p>
                        <div class="card-categorie">
                            <img src="../public/img/logo_categorie/<?= $article['name'] ?>.png" alt="Logo des catégories de Rubik's cube">
                            <p><?= $article['name'] ?></p>
                        </div>
                        <p class="card-user">Proposé par <?= $article['nom'] . ' ' . $article['prenom'] ?></p>
                        <p class="starability-result" data-rating="<?= is_null($article['rating']) ? 0 : roundToNearestHalfInteger($article['rating']) ?>"></p>
                        <p><?= $article['nbr_avis'] ?> avis</p>
                    </article>
                </a>
            <?php } ?>
        </div>
    </section>

</main>
<?php



require_once 'footer.php';

?>