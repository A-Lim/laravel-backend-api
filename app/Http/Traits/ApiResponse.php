<?php
namespace App\Http\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponse {
    protected $headers = ['Content-Type', 'application/json'];

    public function responseWithData($statusCode, $data) {
        return response()
            ->json(['data' => $data], $statusCode, $this->headers);
    }

    public function responseWithDataAndRedirect($statusCode, $data, $redirect) {
        return response()
            ->json(['data' => $data, 'redirect' => $redirect], $statusCode, $this->headers);
    }

    public function responseWithMessage($statusCode, $message) {
        return response()
            ->json(['message' => $message], $statusCode, $this->headers);
    }

    public function responseWithMessageAndData($statusCode, $data, $message) {
        return response()
            ->json(['data' => $data, 'message' => $message], $statusCode, $this->headers);
    }

    public function responseWithError($statusCode, $error_code, $message) {
        return response()
            ->json(['error_code' => $error_code, 'message' => $message], $statusCode, $this->headers);
    }

    public function responseWithToken($statusCode, $token) {
        return response()
            ->json($token, $statusCode, $this->headers);
    }

    public function responseWithTokenAndUser($statusCode, $token, $user) {
        $data = [
            'token_type' => $token->token_type,
            'expiresIn' => $token->expires_in,
            'access_token' => $token->access_token,
            'refresh_token' => $token->refresh_token,
            'user' => $user
        ];
        return response()
            ->json(['data' => $data], $statusCode, $this->headers);
    }
}
