<?php
session_start(); // Démarrez la session

if (isset($_SESSION['user_id'])) {
    // Si un utilisateur est déjà connecté, redirigez-le vers la page d'accueil ou une autre page protégée
    header('Location: profil.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lorsque le formulaire est soumis

    // Récupérez les informations de connexion du formulaire
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Connectez-vous à la base de données (utilisez PDO pour des raisons de sécurité)
    $bdd = new PDO('mysql:host=localhost;dbname=moduleconnexionb2;charset=utf8', 'root', 'azerty');

    // Vérifiez la connexion
    if (!$bdd) {
        die("Erreur de connexion à la base de données");
    }

    // Requête SQL pour vérifier les informations de connexion
    $stmt = $bdd->prepare("SELECT id, login, password FROM user WHERE login = :login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();

    // Récupérez l'utilisateur correspondant (s'il existe)
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Si les informations de connexion sont correctes

        // Créez des variables de session pour l'utilisateur
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_login'] = $user['login'];

        // Redirigez l'utilisateur vers la page d'accueil ou une autre page protégée
        header('Location: profil.php');
        exit();
    } else {
        // Si les informations de connexion sont incorrectes, affichez un message d'erreur
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<?php 

$var = 'Connexion';

require_once('index.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="border p-4 bg-light-gray">
                <br><h1><?php echo $var; ?></h1>

                <form action="inscription.php" method="post">
                    <div class="mb-4">
                        <input type="text" class="form-control" name="login" placeholder="Login">
                    </div>                
                    <div class="mb-4">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="col-auto">
                    <div class="form-btn">
                        <input type="submit" class="btn btn-primary" value="S'inscrire" name="submit">
                    </div>
                </form>
             
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
</body>
</html>