<?php

session_start();

require_once 'nav.php';

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : 'all';
$articleByCategorie = articleByCategorie($bdd, $categorie);
$description = categorieDescription($bdd, $categorie);




?>



<header id="header-collection">
</header>
<main>
    <div class="tabs">
        <a class="tabs__button" href='./collections.php' aria-selected=<?= $categorie === 'all' ? "true" : "false" ?>>
            Tous
        </a>
        <a href='./collections.php?categorie=cubique' class="tabs__button" aria-selected=<?= $categorie === 'cubique' ? "true" : "false" ?>>
            Cubique
        </a>
        <a class="tabs__button" href='./collections.php?categorie=cuboïde' aria-selected=<?= $categorie === 'cuboïde' ? "true" : "false" ?>>
            Cuboïde
        </a>
        <a class="tabs__button" href='./collections.php?categorie=minx' aria-selected=<?= $categorie === 'minx' ? "true" : "false" ?>>
            Minx
        </a>
        <a class="tabs__button" href='./collections.php?categorie=autre' aria-selected=<?= $categorie === 'autre' ? "true" : "false" ?>>
            Autre
        </a>

    </div>
    <section id="collections">
        <h3><?= $description['description'] ?></h3>
        <?php if (isset($_SESSION['user_id'])) { ?>
            <a href="./new_post.php" class="btn new-post">
                <i class="fa-solid fa-square-plus"></i> Nouveau post
            </a>
        <?php } ?>
        <div class="post-container">
            <?php foreach ($articleByCategorie as $article) { ?>
                <a href="./show.php?id=<?= $article['id'] ?>">
                    <article>
                        <div class="card-image"><img src="../public/img/article/<?= $article['image'] ?>" alt="Une image de Rubik's cube"></div>
                        <p class="title"><?= $article['title'] ?></p>
                        <p class="card-user">Proposé par <?= $article['nom'] . ' ' . $article['prenom'] ?></p>
                        <p class="starability-result" data-rating="<?= is_null($article['rating']) ? 0 : roundToNearestHalfInteger($article['rating']) ?>"></p>
                        <p><?= $article['nbr_avis'] ?> avis</p>
                        <p class="date"><?= date("d/m/Y", strtotime($article["timestamp"])) ?></p>
                    </article>
                </a>
            <?php } ?>
        </div>
    </section>

</main>
<script src="../public/js/tabs.js"></script>
<?php



require_once 'footer.php';

?>