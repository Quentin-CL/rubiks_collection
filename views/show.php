<?php

session_start();

require_once 'nav.php';


$id = $_GET['id'];
$articleById = [];
if (preg_match('#^([0-9]+)$#', $id, $matches)) {
    $id = intval($matches[1]);
    $articleById = articleById($bdd, $id);
}

if (!empty($articleById)) {
    $commentaires = commentairesById($bdd, $id);
?>
    <header id="header-collection">
    </header>
    <main>
        <div class="rubiks-container">
            <section id="rubiks">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $articleById["user_id"]) { ?>
                    <div class="link-group">
                        <a href="./update_post.php?id=<?= $id ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="../moteur/destroy_post.php?id=<?= $id ?>"><i class="fa-regular fa-circle-xmark"></i></a>
                    </div>
                <?php } ?>
                <div class="card-image"><img src="../public/img/article/<?= $articleById['image'] ?>" alt="Une image de Rubik's cube"></div>
                <p class="title"><strong><?= $articleById['title'] ?></strong><br><?= $articleById['description'] ?></p>
                <p class="card-user">Proposé par <?= $articleById['nom'] . ' ' . $articleById['prenom'] ?></p>
                <p class="date"><?= date("d/m/Y", strtotime($articleById["timestamp"])) ?></p>
            </section>
            <section id="commentaires-container">
                <div class="new-commentaire">
                    <p>
                        <i class="fa-regular fa-comment"></i> Laisser un avis :
                    </p>
                    <form action="../moteur/comment_post.php" method="post">
                        <fieldset class="starability-checkmark">
                            <input type="radio" id="no-rate" class="input-no-rate" name="rating" value="0" checked aria-label="No rating." />
                            <input type="radio" id="first-rate1" name="rating" value="1" />
                            <label for="first-rate1" title="Terrible">1 star</label>
                            <input type="radio" id="first-rate2" name="rating" value="2" />
                            <label for="first-rate2" title="Not good">2 stars</label>
                            <input type="radio" id="first-rate3" name="rating" value="3" />
                            <label for="first-rate3" title="Average">3 stars</label>
                            <input type="radio" id="first-rate4" name="rating" value="4" />
                            <label for="first-rate4" title="Very good">4 stars</label>
                            <input type="radio" id="first-rate5" name="rating" value="5" />
                            <label for="first-rate5" title="Amazing">5 stars</label>
                        </fieldset>
                        <div class="form-control">
                            <textarea id="commentaire" name="commentaire"></textarea>
                        </div>
                        <input type="hidden" value="<?= $id ?>" name="article_id">
                        <button class="btn">Soumettre</button>
                    </form>

                </div>
                <?php foreach ($commentaires as $commentaire) { ?>
                    <div class="commentaire">
                        <p><?= $commentaire['nom'] . ' ' . $commentaire['prenom'] ?><span> le <?= date("d/m/Y", strtotime($commentaire["timestamp"])) ?> à <?= date("H:m", strtotime($commentaire["timestamp"])) ?></span></p>
                        <p class="starability-result" data-rating="<?= $commentaire['rating'] ?>"></p>
                        <p><?= $commentaire['comment_text'] ?></p>
                    </div>
                <?php } ?>
            </section>
        </div>
    </main>
<?php
} else {
    echo "<h3 style = 'margin-top: 5rem; text-align:center;'>[Erreur 404] Page Not Found</h3>";
}


require_once 'footer.php';

?>