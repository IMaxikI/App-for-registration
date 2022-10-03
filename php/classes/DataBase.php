<?php

declare(strict_types=1);

class DataBase
{
    public const JSON_FILE_NAME = 'users.json';

    public function read(): array
    {
        $json = file_get_contents(self::JSON_FILE_NAME);
        return json_decode($json);
    }

    public function create(string $login, string $password, string $email, string $name): void
    {
        $user = new stdClass();
        $user->login = $login;
        $user->password = $password;
        $user->email = $email;
        $user->name = $name;

        $users = $this->read();
        array_push($users, $user);
        $json = json_encode($users);
        file_put_contents(self::JSON_FILE_NAME, $json);
    }

    public function getByLogin(string $login)
    {
        $users = $this->read();

        foreach ($users as $user) {
            if ($user->login === $login) {
                return $user;
            }
        }

        return null;
    }

    public function checkUnique(string $login, string $email): array
    {
        $users = $this->read();

        $result = ['login' => true, 'email' => true];

        foreach ($users as $user) {
            if ($user->login == $login) {
                $result['login'] = false;
            }
            if ($user->email == $email) {
                $result['email'] = false;
            }
        }

        return $result;
    }
}