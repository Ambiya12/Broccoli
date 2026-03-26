<?php

namespace App\Controller;

use App\core\Database;
use App\Model\Session;
use App\Model\User;

class AuthController
{
    private $userModel;
    private $sessionModel;

    public function __construct()
    {
        $db = Database::getConnection();
        $this->userModel = new User($db);
        $this->sessionModel = new Session($db);
    }

    public function showRegister(): void
    {
        $error = null;
        require_once __DIR__ . "/../views/Signup.php";
    }

    public function register(): void
    {
        if (!isset($_POST["email"], $_POST["password"], $_POST["username"])) {
            http_response_code(400);
            echo "Champs manquants.";
            return;
        }

        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $username = trim($_POST["username"]);
        $error = null;

        $confirmPassword = $_POST["confirm_password"] ?? "";

        if ($email === "" || $password === "" || $username === "") {
            $error = "Tous les champs sont requis.";
        } elseif (strlen($password) < 12) {
            $error = "Le mot de passe doit contenir au moins 12 caractères.";
        } elseif ($password !== $confirmPassword) {
            $error = "Les mots de passe ne correspondent pas.";
        } elseif ($this->userModel->emailExists($email)) {
            $error = "Cet email est déjà utilisé.";
        } else {
            $this->userModel->create($email, $password, $username);
            header("Location: /login");
            exit();
        }

        require_once __DIR__ . "/../views/Signup.php";
    }

    public function showLogin(): void
    {
        $error = null;
        require_once __DIR__ . "/../views/LoginPage.php";
    }

    public function login(): void
    {
        if (!isset($_POST["email"], $_POST["password"])) {
            http_response_code(400);
            echo "Champs manquants.";
            return;
        }

        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $error = null;

        $user = $this->userModel->findByEmail($email);

        // La vérification est entièrement encapsulée dans le modèle.
        // Le controller ne voit jamais le hash ni le plain text comparé.
        if (!$user || !$user->verifyPassword($password)) {
            $error = "Email ou mot de passe incorrect.";
        } else {
            $token = $this->sessionModel->create($user->getId());
            setcookie("session_token", $token, [
                "expires" => time() + 86400,
                "path" => "/",
                "httponly" => true,
            ]);
            header("Location: /dashboard");
            exit();
        }

        require_once __DIR__ . "/../views/LoginPage.php";
    }

    public function dashboard(): void
    {
        $token = $_COOKIE["session_token"] ?? null;

        if (!$token) {
            header("Location: /login");
            exit();
        }

        $session = $this->sessionModel->findByToken($token);

        if (!$session) {
            header("Location: /login");
            exit();
        }

        $user = $this->userModel->findById($session->getUserId());
        $isLoggedIn = true;
        require_once __DIR__ . "/../views/home.php";
    }

    public function logout(): void
    {
        $token = $_COOKIE["session_token"] ?? null;

        if ($token) {
            $this->sessionModel->delete($token);
            setcookie("session_token", "", [
                "expires" => time() - 3600,
                "path" => "/",
                "httponly" => true,
            ]);
        }

        header("Location: /");
        exit();
    }
}
