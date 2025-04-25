<?php

class ErrorHandler
{
    public static function handleException(Throwable $exception): void
    {
        http_response_code(500);


        echo json_encode([
            "code" => $exception->getCode(),
            "file" => $exception->getfile(),
            "line" => $exception->getline()
        ], true);
    }


    public static function handleError(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline
    ): bool{

        throw new ErrorException($errstr, $errno, 0, $errfile, $errline);

    }
}


