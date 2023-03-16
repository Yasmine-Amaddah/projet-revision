<?php
session_start();

class User
{
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;

    function getLogin()
    {
        return $this->login;
    }

    function getPassword()
    {
        return $this->password;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getFirstname()
    {
        return $this->firstname;
    }

    function getLastname()
    {
        return $this->lastname;
    }

    function setLogin($login)
    {
        $this->login = $login;
    }

    function setPassword($password)
    {
        $this->password = $password;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    function __construct($login, $password, $email, $firstname, $lastname)
    {
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    function register($bdd)
    {
        if ($this->verifierSiVide()) {
            if ($this->loginUnique($bdd)) {
                $request = $bdd->prepare('INSERT INTO `utilisateurs`(`login`, `password`, `email`, `first name`, `last name`) VALUES (?,?,?,?,?)');
                $request->execute([$this->login, $this->password, $this->email, $this->firstname, $this->lastname]);
            }
        }
    }

    function loginUnique($bdd)
    {
        $request = $bdd->prepare('SELECT login FROM utilisateurs WHERE login = ?');
        $request->execute([$_POST['login']]);
        if ($request->rowCount() < 1) {
            return true;
        } else {
            return false;
        }
    }

    function verifierSiVide()
    {
        if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['firstname']) && !empty($_POST['lastname'])) {
            return true;
        } else {
            echo "il faut remplir tout les champs";
            return false;
        }
    }

    function connect($bdd)
    {
        $request = $bdd->prepare('SELECT * FROM utilisateurs WHERE login = ? AND password = ?');
        $request->execute([$this->login, $this->password]);
        $result = $request->fetch();
        $_SESSION["user"] = $this;
    }

    function disconnect()
    {
        unset($_SESSION["user"]);
        //session_destroy();
    }

    function isConnected()
    {
        if (isset($_SESSION["user"]->login)) {
            echo "Connected";
        } else {
            echo "Not connected";
        }
    }

    function update($bdd)
    {
        $request = $bdd->prepare("UPDATE `utilisateurs` SET `login`= ?,`password`= ?,`email`= ?,`first name`= ?,`last name`= ? WHERE id = ?");
        $request->execute([$this->login, $this->password, $this->email, $this->firstname, $this->lastname, $this->get_id($bdd)]);
        
    }
    function get_id($bdd){
        $request = $bdd->prepare('SELECT `id` FROM utilisateurs WHERE login = ? ');
        $request->execute([$this->login]);
        $result = $request->fetch(); 
        return $result['id'];
    }

}

//$user = new User('toto','toto', 'toto@gmail.com', 'toto', 'toto');
// $user->register();
//$user->connect('toto','toto');
//$user->disconnect();
//$user->isConnected();
//$user->update('teste','teste', 'teste@gmail.com', 'teste', 'teste');
//var_dump($user);
//$bdd = new PDO("mysql:host=localhost;dbname=revisions", 'root', '');
//$user->get_id($bdd);
