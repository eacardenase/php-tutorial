<?php

namespace Core;

class Authenticator
{
    public function attempt(string $email, string $password): bool
    {
        $user = App::resolve(Database::class)->query('SELECT * FROM users WHERE email = :email', [
            'email' => $email
        ])->findOne();

        if (!$user || !password_verify($password, $user["password"])) {
            return false;
        }

        $this->login([
            'email' => $email,
            'id' => $user['id']
        ]);

        return true;
    }

    public function login(array $user): void
    {
        $_SESSION['user'] = [
            "email" => $user["email"],
            "id" => $user["id"]
        ];

        session_regenerate_id(true);
    }

    public function logout(): void
    {
        Session::destroy();
    }
}