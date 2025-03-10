<?php
session_start();
require_once("../../../vendor/autoload.php");
use App\Controllers\Auth\AuthController;

if(isset($_SESSION["role"]) && $_SESSION["role"] == "Administrateur"){
    header("Location: ../../Views/Admin/index.php");
    exit();
}
if(isset($_SESSION["role"]) && $_SESSION["role"] == "enseignant"){
    header("Location: ../../Views/Enseignant/index.php");
    exit();
}
if(isset($_SESSION["role"]) && $_SESSION["role"] == "etudiant"){
    header("Location: ../../Views/Etudiant/index.php");
    exit();
}



if(isset($_POST["submit"]))
{

    if(empty($_POST["email"]) && empty($_POST["password"]))
    {
        echo "email or password is empty";
    }
    else{
        $email = $_POST["email"];
        $password = $_POST["password"];

        $authController = new AuthController();
        $authController->login($email, $password);

    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assests/Css/Auth/Login.css">
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="logo">
                <i class="fas fa-briefcase me-2"></i>Youdemy
            </div>
            <h4 class="text-center mb-4">Connexion</h4>
            <?php
                // Afficher les messages d'erreur
                if (isset($_SESSION['error'])) {
                    echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']); // Supprimer le message après l'affichage
                }

                // Afficher les messages de succès
                if (isset($_SESSION['success'])) {
                    echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']); // Supprimer le message après l'affichage
                }
            ?>

            <form id="loginForm" action="" method="POST">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>

                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
                    </div>
                    <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                </div>

                <input hidden type="password" class="form-control" name="submit" value="submit" placeholder="Mot de passe">

                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>

            <div class="text-center mt-4">
                <p>Pas encore de compte ? <a href="registre.php">Inscrivez-vous</a></p>
            </div>
        </div>
    </div>

    <!-- js -->
    <!-- <script src="../assests/js/login.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
