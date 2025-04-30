<?php

namespace Services;

class User
{



    function __construct(private \Models\User $userModel, private \JwtHandler $jwtHandler) {}
    public function login(string $method,  array $payload): array
    {
        return ['error ' => 'Failed to login'];
    }

    public function createAccount(string $name, string $email, string $password): array
    {



        $password = password_hash($password, PASSWORD_DEFAULT);

        if ($this->userModel->getUserEmail($email) === true) {
            return ['error' => 'Email already exists'];
        }

        $createAccount = $this->userModel->createAccount($name, $email, $password);

        if (!empty($createAccount['error'])) {

            return $createAccount;
        }



        $tokenization = $this->jwtAuthCreate($createAccount["user_id"]);
        return ["access_token" => $tokenization, 'name' => $createAccount['name'], 'email' => $createAccount['email']];
    }
    public function jwtAuthCreate(string $userId): string | array
    {
        $token = $this->jwtHandler->generateAccessToken($userId);

        if ($token) {

            return $token;
        }

        return ['error' => "An error occured generating the authorization token"];
    }
}
