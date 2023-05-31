<?php

namespace App\Controllers;

require_once __DIR__ . '/../Domain/Services/UserService.php';
require_once __DIR__ . '/../Domain/Services/RoleService.php';
require_once __DIR__ . '/../Domain/ValueObjects/Email.php';

use App\Domain\Services\UserService;
use App\Domain\Services\RoleService;
use App\Domain\ValueObjects\Email;

class AuthController
{

    protected $userService;
    protected $roleService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->roleService = new RoleService();
    }

    public function showRegisterForm()
    {
        session_start();
        require_once __DIR__ . '/../Views/register.php';
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

    public function showLoginForm()
    {
        session_start();
        if ($_SESSION['user']) {
            header('Location: /');
        } else {
            require_once __DIR__ . '/../Views/login.php';
        }
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user']);
        header('Location: /connexion');
    }

    public function register()
    {
        try {
            session_start();
            $name = trim($_POST['name']);
            $email = new Email(trim($_POST['email']));
            $password = trim($_POST['password']);
            $password_confirmation = trim($_POST['confirm_password']);
            $role = trim($_POST['account_type']) == 'fournisseur' ? 'supplier' : 'client';

            // Vérification que les champs sont remplis
            if (empty($name) || empty($password) || empty($password_confirmation)) {
                $error_message = "Veuillez remplir tous les champs.";
            } else {
                // Vérification de l'adresse email
                if (!$email->validate()) {
                    $error_message = "L'adresse email n'est pas valide.";
                } else {
                    // Vérification de la confirmation du mot de passe
                    if ($password !== $password_confirmation) {
                        $error_message = "Les mots de passe ne correspondent pas.";
                    } else {
                        // Vérification que l'adresse email n'est pas déjà utilisée
                        $user = $this->userService->getUserByEmail($email);
                        if ($user != null) {
                            $error_message = "Cette adresse email est déjà utilisée.";
                        } else {
                            // Enregistrement de l'utilisateur dans la base de données
                            $result = $this->userService->createUser($name, $email, $password, $role);
                            if ($result) {
                                $success_message = "Votre compte a été créé avec succès !";
                            } else {
                                $error_message = "Une erreur est survenue lors de la création de votre compte.";
                            }
                        }
                    }
                }
            }
            if (isset($error_message)) {
                $_SESSION['error_message'] = $error_message;
                header('Location: /inscription');
                exit();
            } elseif (isset($success_message)) {
                $_SESSION['success_message'] = $success_message;
                header('Location: /connexion');
                exit();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function login()
    {
        try {
            session_start();
            $email = new Email(trim($_POST['email']));
            $password = trim($_POST['password']);

            // Vérification que les champs sont remplis
            if (empty($email) || empty($password)) {
                $error_message = "Veuillez remplir tous les champs.";
            } else {
                // Vérification de l'adresse email
                if (!$email->validate()) {
                    $error_message = "L'adresse email n'est pas valide.";
                } else {
                    // Récupération de l'utilisateur correspondant à l'adresse email
                    $user = $this->userService->getUserByEmail($email);
                    if (!$user) {
                        $error_message = "Aucun utilisateur n'est enregistré avec cette adresse email.";
                    } else {
                        // Vérification du mot de passe
                        if (!password_verify($password, $user->getPassword())) {
                            $error_message = "Le mot de passe est incorrect.";
                        } else {
                            // Enregistrement de l'utilisateur dans la session
                            $_SESSION['user'] = $user;
                            /* $_SESSION['user'] = [
                                'id' => $user->getId(),
                                'name' => $user->getName(),
                                'email' => $user->getEmail(),
                                'role' =>  $user->getRole(),
                            ]; */
                            header('Location: /');
                            exit();
                        }
                    }
                }
            }

            if (isset($error_message)) {
                $_SESSION['error_message'] = $error_message;
                header('Location: /connexion');
                exit();
            }
        } catch (\Throwable $th) {
            throw new \Exception($th);
            //die("Erreur " . $th->getMessage());
        }
    }
}
