<?php
require_once('user.php');

$var = "Formulaire d'inscription";

if (isset($_POST['submit'])) {
    // Récupérer les valeurs du formulaire
    $login = $_POST['login'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    // Vérifier si les mots de passe correspondent
    if ($password === $repeat_password) {
        // Valider le mot de passe (au moins huit caractères, une majuscule, un chiffre et un caractère spécial)
        if (preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!])[\w@#$%^&+=!]{8,}$/', $password)) {
            // Crypter le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Connexion à la base de données (utilisez PDO au lieu de mysqli pour des raisons de sécurité)
            try {
                $bdd = new PDO('mysql:host=localhost;dbname=moduleconnexionb2;charset=utf8', 'root', 'azerty');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Utilisez une requête préparée pour insérer l'utilisateur dans la base de données
                $stmt = $bdd->prepare("INSERT INTO user (login, firstname, lastname, password) VALUES (:login, :firstname, :lastname, :password)");
                $stmt->bindParam(':login', $login);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':password', $hashedPassword);

                if ($stmt->execute()) {
                    echo "Inscription réussie.";
                    // Rediriger vers la page de connexion
                    header('Location: connexion.php');
                    exit();
                } else {
                    $var = "Une erreur est survenue lors de l'inscription de l'utilisateur.";
                }
            } catch (PDOException $e) {
                echo "Erreur de base de données : " . $e->getMessage();
            }
        } else {
            $var = "Le mot de passe doit contenir au moins huit caractères, une majuscule, un chiffre et un caractère spécial.";
        }
    } else {
        $var = "Les mots de passe ne correspondent pas.";
    }
}
?>

<?php 

$var = 'Inscription';

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
                        <input type="text" class="form-control" name="firstname" placeholder="Firstname">
                    </div>
                    <div class="mb-4">
                        <input type="text" class="form-control" name="lastname" placeholder="Lastname">
                    </div>
                    <div class="mb-4">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="mb-4">
                        <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
                    </div>
                    <div class="col-auto">
                        <span id="passwordHelpInline" class="form-text">
                            Le mot de passe doit contenir au moins huit caractères, une majuscule, un chiffre et un caractère spécial.
                        </span>
                    </div>
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