<?php

namespace Services;

class User
{



    function __construct(private \Models\User $userModel, private \JwtHandler $jwtHandler) {}
 

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


        // CREATE NEW TOKEN IN DATABASE
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

    public function loginAuth(string $email, string $password): array
    {


        $user = $this->userModel->login($email, $password);


        if (!empty($user['error'])) {
            return $user;
        }

        if ($this->passwordVerify(password: $password, hash:$user['password'] ) === false) {
            return ['error' => 'Invalid password'];
        }

        //UPDATE TOKEN IN DATABASE

        return ["access_token" => $this->jwtAuthCreate($user['user_id']), 'name' => $user['name'], 'email' => $user['email']];

        return ['error' => 'Failed to login'];
    }

    public function passwordVerify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
