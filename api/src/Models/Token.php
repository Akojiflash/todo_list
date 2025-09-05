<?php

namespace Models;

class Token{
    private $conn;
    function __construct(private \Database $database) {
        $this->conn = $this->database->getConnection();
    }


    function updateToken(string $user_id,string $accessToken, string $refreshToken ): array{

        $query = "UPDATE user_token SET refresh_token = :refreshToken, access_token = :accessToken WHERE user_id = :user_id ";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":refreshToken", $refreshToken, \PDO::PARAM_STR);
        $stmt->bindValue(":accessToken", $accessToken, \PDO::PARAM_STR);
        $stmt->bindValue(":user_id", $user_id, \PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->rowCount() > 0){
            return ["message"=> "success"];
        }

        return ['error'=> "An unkown error occured in the database"];

    }

    function storeToken(string $user_id,string $accessToken, string $refreshToken ): array{
          $query = "INSERT INTO user_token (refresh_token , access_token, user_id) VALUES (:refreshToken, :accessToken, :user_id )";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":refreshToken", $refreshToken, \PDO::PARAM_STR);
        $stmt->bindValue(":accessToken", $accessToken, \PDO::PARAM_STR);
        $stmt->bindValue(":user_id", $user_id, \PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->rowCount() > 0){
            return ["message"=> "success"];
        }

        return ['error'=> "An unkown error occured in the database"];


    }

    function getToken(string $user_id,string $accessToken, string $refreshToken ):string{


        return "";

    }
   
}