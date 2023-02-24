<?php

function roundToNearestHalfInteger($number)
{
    $precision = 1 / 0.5;
    return round($number * $precision) / $precision;
}

function fetch_all(string $sql, PDO $bdd)
{
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $result;
}

function fetch_id(PDO $bdd, string $sql, int $id)
{
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $result;
}


function lastInsertArticle(PDO $bdd): array
{
    $sql = 'SELECT a.id,a.timestamp, u.nom, u.prenom, a.image, a.title, c.name, COUNT(co.id) AS nbr_avis, AVG(co.rating) AS rating
    FROM article AS a
    INNER JOIN categorie AS c
    ON a.categorie_id = c.id
    INNER JOIN users AS u
    ON a.user_id = u.id
    LEFT JOIN comment as co
    ON a.id = co.article_id
    GROUP BY a.id
    ORDER BY a.timestamp DESC
    LIMIT 3';
    return fetch_all($sql, $bdd);
}

function login(PDO $bdd, $mail): array
{
    $query = "SELECT * FROM users WHERE mail='$mail'";
    return fetch_all($query, $bdd);
}

function utilisateur_insert(PDO $bdd, array $utilisateur): int
{
    $sql = 'INSERT INTO users (
      nom,
      prenom,
      mail,
      password,
      niveau
      ) VALUES (
        :nom,
        :prenom,
        :mail,
        :password,
        :niveau)';
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':nom', $utilisateur['nom'], PDO::PARAM_STR);
    $stmt->bindParam(':prenom', $utilisateur['prenom'], PDO::PARAM_STR);
    $stmt->bindParam(':mail', $utilisateur['mail'], PDO::PARAM_STR);
    $stmt->bindParam(':password', $utilisateur['password'], PDO::PARAM_STR);
    $stmt->bindValue(':niveau', 2, PDO::PARAM_INT);
    $stmt->execute();
    $id = (int) $bdd->lastInsertId();
    $stmt->closeCursor();
    return $id;
}

function articleByCategorie(PDO $bdd, $categorie): array
{
    $cond = $categorie === 'all' ? '' : "WHERE LOWER(c.name) = '$categorie'";
    $sql = "SELECT a.id, a.timestamp, u.nom, u.prenom, a.image, a.title, COUNT(co.id) AS nbr_avis, AVG(co.rating) AS rating
    FROM article AS a
    INNER JOIN categorie AS c
    ON a.categorie_id = c.id
    INNER JOIN users AS u
    ON a.user_id = u.id
    LEFT JOIN comment as co
    ON a.id = co.article_id
    $cond
    GROUP BY a.id
    ORDER BY a.timestamp DESC";
    return fetch_all($sql, $bdd);
}

function categorieDescription(PDO $bdd, $categorie): array
{
    if ($categorie === "all") {
        return ['description' => 'Vous trouverez ici tous types de rubik\'s cube'];
    }
    $sql = "SELECT description
    FROM categorie
    WHERE LOWER(name) = :categorie";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':categorie', $categorie, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $result;
}

function allCategorie(PDO $bdd): array
{
    $sql = "SELECT *
    FROM categorie";
    return fetch_all($sql, $bdd);
}

function article_insert(PDO $bdd, array $article): int
{
    $sql = 'INSERT INTO article (
      user_id,
      categorie_id,
      title,
      image,
      description
      ) VALUES (
        :user_id,
        :categorie_id,
        :title,
        :image,
        :description)';
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':user_id', $article['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':categorie_id', $article['categorie_id'], PDO::PARAM_INT);
    $stmt->bindParam(':title', $article['titre'], PDO::PARAM_STR);
    $stmt->bindParam(':image', $article['image'], PDO::PARAM_STR);
    $stmt->bindParam(':description', $article['description'], PDO::PARAM_STR);
    $stmt->execute();
    $id = (int) $bdd->lastInsertId();
    $stmt->closeCursor();
    return $id;
}

function articleById(PDO $bdd, int $id)
{
    $sql = "SELECT a.timestamp, u.nom, u.prenom, a.image, a.title, a.description, a.user_id, c.name
    FROM article AS a
    INNER JOIN categorie AS c
    ON a.categorie_id = c.id
    INNER JOIN users AS u
    ON a.user_id = u.id
    WHERE a.id = :id";
    return fetch_id($bdd, $sql, $id);
}
function commentairesById(PDO $bdd, int $id)
{
    $cond =  "WHERE c.article_id = $id";
    $sql = "SELECT u.nom, u.prenom, c.comment_text, c.rating, c.timestamp
    FROM comment AS c
    INNER JOIN users AS u
    ON u.id = c.user_id
    $cond";
    return fetch_all($sql, $bdd);
}

function commentaireInsert(PDO $bdd, array $commentaire): int
{
    $sql = 'INSERT INTO comment (
      article_id,
      comment_text,
      rating,
      user_id
      ) VALUES (
        :article_id,
        :comment_text,
        :rating,
        :user_id)';
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':article_id', $commentaire['article_id'], PDO::PARAM_INT);
    $stmt->bindParam(':comment_text', $commentaire['commentaire'], PDO::PARAM_STR);
    $stmt->bindParam(':rating', $commentaire['rating'], PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $commentaire['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $id = (int) $bdd->lastInsertId();
    $stmt->closeCursor();
    return $id;
}
function deleteArticleById(PDO $bdd, int $id)
{
    deleteCommentsById($bdd, $id);
    $sql = 'DELETE FROM article
    WHERE id = :id';
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
}
function deleteCommentsById(PDO $bdd, int $id)
{
    $sql = 'DELETE FROM comment
    WHERE article_id = :id';
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
}
function articleUpdate(PDO $bdd, int $id, array $article): int
{
    $sql = 'UPDATE article SET 
      categorie_id = :categorie_id,
      title = :title,
      image = :image,
      description = :description
      WHERE id = :id';
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':categorie_id', $article['categorie_id'], PDO::PARAM_INT);
    $stmt->bindParam(':title', $article['titre'], PDO::PARAM_STR);
    $stmt->bindParam(':image', $article['image'], PDO::PARAM_STR);
    $stmt->bindParam(':description', $article['description'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $id = (int) $bdd->lastInsertId();
    $stmt->closeCursor();
    return $id;
}
