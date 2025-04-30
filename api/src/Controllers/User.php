<?php

namespace Controllers;

class User
{

    public function __construct(private \Services\User $userService) {}


    public function processRequest(string $method, string $request): void
    {

        switch ($request) {

            case "login":
                $this->signin($method);
                break;

            case "register":
                $this->signup($method);
                break;
            default:
                http_response_code(403);
                echo json_encode(['error' => "unknown request"], true);
        }
    }


    public function signin(string $method): void
    {
        echo "Hello our new todo app!";
    }

    public function signup(string $method): void
    {

        switch ($method) {
            case "POST":

                $payload = (array) json_decode(file_get_contents('php://input'));
                $filter = $this->signup_filter($payload);

                if (count($filter) > 0) {
                    http_response_code(406);
                    echo json_encode($filter, JSON_PRETTY_PRINT);
                    break;
                }

                $reponse = $this->userService->createAccount($payload['name'], $payload['email'], $payload['password']);

                if (!empty($reponse['error'])) {
                    http_response_code(422);
                    echo json_encode($reponse, JSON_PRETTY_PRINT);
                    break;
                }

                echo json_encode($reponse, JSON_PRETTY_PRINT);
                break;
            default:
                http_response_code(405);
                header("Allow: POST");
        }
    }

    function signup_filter(array $userData): array
    {
        $error = [];

        if (empty($userData['email'])) {
            $error[] = 'email is required';
        }

        if (array_key_exists('email', $userData) && filter_var($userData['email'], FILTER_VALIDATE_EMAIL) === false) {
            $error[] = 'not a valid email';
        }

        if (empty($userData['name'])) {

            $error[] = "name is required";
        }

        if (empty($userData["password"])) {
            $error[] = "password is required";
        }

        if(!empty($userData["password"]) && strlen($userData["password"]) < 8){
            $error[] = "password must be at least 8 characters long";
        }

        if(!empty($userData['password']) && !preg_match('/[A-Z]/', $userData['password'] )){
            $error[] = "Password must contain at least one uppercase  letter";
        }
        if(!empty($userData['password']) && !preg_match('/[a-z]/', $userData['password'] )){
            $error[] = "Password must contain at least one lowercase letter";
        }

        
        if(!empty($userData['password']) && !preg_match('/[0-9]/', $userData['password'] )){
            $error[] = "Password must contain at least one number";
        }

        if(!empty($userData['password']) && !preg_match('/[\W]/', $userData['password'] )){
            $error[] = "Password must contain at least one special character";
        }
       
        return $error;
    }
}
