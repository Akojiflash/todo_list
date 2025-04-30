<?php



class JwtHandler
{

    private $secretkey = "fff6dc88eb25842f6eac0b4099b0935e748abcb4d7210477ca0cd1217c0ff057b55d97b957228e474ec80903b9de2e44a1da1881efa00c05914e19f5ac1d185cfe42bdd606138723f2903b5479d40b95815e7ee6d92fccafe4d5fcf7f5e2c322b4c6815402806d127d4188ccefe01d16f214884a13f60f876fa16cce491dfd34adf1b28eaebe750a9bb5084d1274b363a952c721039499ea8d33b449bdbf5b8b0fb623a4c6c0decf6e68a8d873bf74f1411134e966226b60c9cf3906543b6bbc1bedf18a588e543fc788fdf65ab21e2dde5fe4f2ce688e71aead4e99d2ac15eecc3fa12abc9f1d2d282cc03547de4670d1bbf3f8bb30bf6026d02e21e5f7aee5";

    private $alg = "HS256";

    private $issuer = "http://localhost/todo_list/public/api/index.php";
    private $accessTokenExpiration = 3600; // 1 hour

    function __construct(private Firebase\JWT\JWT $jwt,) {}






    public function generateAccessToken($userId): string
    {

        $issuedAt = time();
        $payload = [
            'iss' => $this->issuer,
            'iat' => $issuedAt,
            'exp' => $issuedAt + $this->accessTokenExpiration,
            'sub' => $userId,
        ];

        return $this->jwt::encode($payload, $this->secretkey, $this->alg);
    }


    public function verifyJWT($token): bool| array
    {

        try {
            $decode = $this->jwt::decode($token, new Firebase\JWT\Key($this->secretkey, $this->alg));
            return (array) $decode;
        } catch (Exception $e) {
            return false;
        }
    }

    public function extractTokenFromHeader($header): null |string
    {
        $authHeader = $headers['Authorization'] ?? "";

        $matches = [];

        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
