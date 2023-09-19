<?php

class User
{
    private $id;
    private $login;
    private $firstname;
    private $lastname;
    private $password;

    // Constructeur pour initialiser un objet User
    public function __construct($login, $firstname, $lastname, $password, $id = null)
    {
        $this->login = $login;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->id = $id;
    }

    // Méthode pour insérer un utilisateur dans la base de données
    public function save(PDO $pdo)
    {
        $sql = "INSERT INTO user (login, firstname, lastname, password) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->login, $this->firstname, $this->lastname, $this->password]);
    }

    // Méthode pour rechercher un utilisateur par ID dans la base de données
    public static function findById(PDO $pdo, $id)
    {
        $sql = "SELECT * FROM user WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            return new User(
                $userData['login'],
                $userData['firstname'],
                $userData['lastname'],
                $userData['password'],
                $userData['id']
            );
        } else {
            return null;
        }
    }

    // Méthode pour mettre à jour les informations d'un utilisateur dans la base de données
    public function update(PDO $pdo)
    {
        $sql = "UPDATE user SET login = ?, firstname = ?, lastname = ?, password = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->login, $this->firstname, $this->lastname, $this->password, $this->id]);
    }

    // Méthode pour supprimer un utilisateur de la base de données
    public function delete(PDO $pdo)
    {
        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->id]);
    }

    // Getters et setters pour les propriétés
    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
?>
