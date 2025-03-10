<?php
    session_start();
    require_once("../../../../vendor/autoload.php");
    use App\Controllers\admin\TagController;
    use App\Controllers\admin\CategorieController;
    use App\Controllers\Enseignant\CourseController;

    $courseController = new CourseController();
    $tagController = new TagController();
    $categorieController = new CategorieController();

    $tags = $tagController->getTags();
    $categories = $categorieController->getCategories();

    if (isset($_GET['update_id'])) {
        $course_id = $_GET['update_id'];
        $course = $courseController->trouvercourse($course_id);

        if (!$course) {
            die("Le cours n'a pas été trouvé.");
        }
    }
    if (isset($_POST["submit"])) {

        $title = $_POST["title"];
        $description = $_POST["description"];
        $contentType = $_POST["content_type"];
        $contentUrl = $_POST["content_url"];
        $categorieId = $_POST["category_id"];
        $tags = $_POST["tags"] ?? [];
    
        $utilisateurId = $_SESSION["id"];
    
        $courseController->updateCourse( $course_id, $title, $description, $contentType, $contentUrl, $utilisateurId, $categorieId, $tags);
    
        header("Location: ../index.php");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Cours - Youdemy</title>
    <link rel="stylesheet" href="../../assests/css/Enseignant/menuens.css">
    <link rel="stylesheet" href="../../assests/css/Enseignant/gererens.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="dashboard-header text-center">
        <div class="container">
            <h1>Gestion des Cours</h1>
            <p>Créez et gérez vos cours en ligne</p>
        </div>
    </div>

    <div class="container">
        <div class="menu-buttons">
            <div class="row g-3">
            <div class="col-12 col-md-4">
                <a href="../index.php" class="menu-btn active">
                    <i class="bi bi-collection"></i>
                    Mes Cours
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a href="ajoutercours.php" class="menu-btn">
                    <i class="bi bi-plus-circle"></i>
                    Ajouter un Cours
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a href="statistiques.php" class="menu-btn">
                    <i class="bi bi-graph-up"></i>
                    Statistiques
                </a>
            </div>
        </div>

        <div class="form-section">
            <h2 class="mb-4">modifier le Cours</h2>
            <form action="" method="POST">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Titre du cours*</label>
                        <input type="text" name="title" class="form-control" value="<?= $course->getTitle() ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description*</label>
                        <textarea name="description" class="form-control" rows="4" required><?= $course->getDescription() ?></textarea>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Type de contenu*</label>
                        <select name="content_type" class="form-select" required>
                            <option value="video" <?= $course->getContentType() === 'video' ? 'selected' : '' ?>>Vidéo</option>
                            <option value="document" <?= $course->getContentType() === 'document' ? 'selected' : '' ?>>Document</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">URL du contenu*</label>
                        <input type="text" name="content_url" class="form-control" value="<?= $course->getContentUrl() ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Catégorie*</label>
                        <select name="category_id" class="form-select" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->getId() ?>" <?= $category->getId() === $course->getCategorie()->getId() ? 'selected' : '' ?>>
                                    <?= $category->getNom() ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Tags</label>
                        <div class="tag-group">
                            <?php foreach ($tags as $tag): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="<?= $tag->getId() ?>" 
                                        <?= in_array($tag->getId(), array_map(function($t) { return $t->getId(); }, $course->getTags())) ? 'checked' : '' ?>>
                                    <label class="form-check-label"><?= $tag->getNom() ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <input hidden type="password" class="form-control" name="submit" value="submit" value="<?= $course->getId() ?>">
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Mettre à jour le cours
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>