<?php

include_once 'DataBase.php';
include_once 'User.php';
include_once 'HttpResponseInterface.php';

class AuthorizeUser extends User implements HttpResponseInterface
{
    /**
     * @param string $login
     * @param string $password
     */
    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
        $this->validation = ['login' => '', 'password' => ''];
        $this->checkUser();
    }

    private function checkUser(): void
    {
        $db = new DataBase();
        $registeredUser = $db->getByLogin($this->login);

        if ($registeredUser) {
            $this->name = $registeredUser->name;

            if ($this->hashPassword() !== $registeredUser->password) {
                $this->validation['password'] = 'Invalid password!';
            }
        } else {
            $this->validation['login'] = 'The user with this login doesn\'t exist!';
        }
    }

    public function sendResponse(): void
    {
        foreach ($this->validation as $mess) {
            if ($mess !== '') {
                http_response_code(400);
                echo json_encode($this->validation);

                return;
            }
        }

        session_start();
        $_SESSION['login'] = $this->login;
        setcookie('name', $this->name, ['path' => '/']);

        echo json_encode(['redirect' => 'home.html']);
    }
}