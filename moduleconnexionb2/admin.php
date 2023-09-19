<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'administrateur, sinon rediriger vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

// Vérifier si l'utilisateur est un administrateur (vous pouvez stocker cette information dans la base de données)
$is_admin = true; // Exemple : vous devrez déterminer cela en fonction de votre structure de données

if (!$is_admin) {
    // Si l'utilisateur n'est pas un administrateur, rediriger vers une autre page ou afficher un message d'erreur
    header('Location: index.php'); // Ou une autre page
    exit();
}

$var = "Page d'Administration";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $var; ?></title>

</head>
<body>
    <?php include_once('index.php'); ?>

    <div class="container">
        <h1><?php echo $var; ?></h1>
        <!-- Contenu de la page d'administration ici -->
        <p>Bienvenue sur la page d'administration. Vous pouvez gérer les utilisateurs et les données ici.</p>
        <!-- Vous pouvez ajouter des fonctionnalités d'administration, comme la liste des utilisateurs, la modification des données, etc. -->
    </div>

    <!-- Inclure les scripts JavaScript nécessaires ici -->
</body>
</html>
