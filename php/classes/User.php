<?php

abstract class User
{
    private const SALT = 'tgbhu';

    /**
     * @var string
     */
    protected string $login;

    /**
     * @var string
     */
    protected string $password;

    /**
     * @var string
     */
    protected string $email;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var array
     */
    protected array $validation;

    /**
     * @param string $login
     * @param string $password
     * @param string $email
     * @param string $name
     */
    public function __construct(string $login, string $password, string $email, string $name)
    {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
        $this->validation = [];
    }

    /**
     * @return string
     */
    protected function hashPassword(): string
    {
        return md5(md5(md5($this->password) . md5(self::SALT)));
    }
}