<?php

include_once 'DataBase.php';
include_once 'User.php';
include_once 'HttpResponseInterface.php';

class RegisterUser extends User implements HttpResponseInterface
{
    /**
     * @var string
     */
    private string $confirm_password;

    /**
     * @param string $login
     * @param string $password
     * @param string $confirm_password
     * @param string $email
     * @param string $name
     */
    public function __construct(string $login, string $password, string $confirm_password, string $email, string $name)
    {
        parent::__construct($login, $password, $email, $name);
        $this->confirm_password = $confirm_password;
        $this->checkValidation();
    }

    private function checkValidation(): void
    {
        $this->validation = [
            'login' => $this->checkLogin(),
            'password' => $this->checkPassword(),
            'confirm_password' => $this->checkConfirmPassword(),
            'email' => $this->checkEmail(),
            'name' => $this->checkName()
        ];

        $this->checkUnique();
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

        $this->registerUser();

        http_response_code(200);
        echo json_encode(['redirect' => 'authorization.html']);
    }

    private function registerUser(): void
    {
        $db = new DataBase();
        $db->create($this->login, $this->hashPassword(), $this->email, $this->name);
    }

    private function checkUnique(): void
    {
        $db = new DataBase();
        $uniqueFields = $db->checkUnique($this->login, $this->email);

        foreach ($uniqueFields as $key => $val) {
            if (!$val) {
                $this->validation[$key] .= ' User with this ' . $key . ' already exists.';
            }
        }
    }

    /**
     * @return string
     */
    private function checkLogin(): string
    {
        $message = '';

        $this->checkLen($this->login, 6, $message);

        if (!(ctype_alnum($this->login))) {
            $message .= ' The login can only consist of a number and a letter.';
        }

        return $message;
    }

    /**
     * @return string
     */
    private function checkPassword(): string
    {
        $message = '';

        $this->checkLen($this->password, 6, $message);

        if (!(ctype_alnum($this->password) && !ctype_digit($this->password) && !ctype_alpha($this->password))) {
            $message .= ' The password must consist of numbers and letters.';
        }

        return $message;
    }

    /**
     * @return string
     */
    private function checkConfirmPassword(): string
    {
        $message = '';

        if ($this->password !== $this->confirm_password) {
            $message = 'The password doesn\'t match!';
        }

        return $message;
    }

    /**
     * @return string
     */
    private function checkEmail(): string
    {
        $message = '';

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Incorrect email.';
        }

        return $message;
    }

    /**
     * @return string
     */
    private function checkName(): string
    {
        $message = '';

        $this->checkLen($this->name, 2, $message);

        if (!ctype_alpha($this->name)) {
            $message .= ' The name must consist only of letters.';
        }

        return $message;
    }

    /**
     * @param string $field
     * @param int $minLen
     * @param string $message
     */
    private function checkLen(string $field, int $minLen, string &$message): void
    {
        if (strlen($field) < $minLen) {
            $message .= 'Minimum of ' . $minLen . ' characters.';
        }
    }
}