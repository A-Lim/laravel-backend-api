<?php
namespace App\Http\Traits;

use Zend\Diactoros\ServerRequestFactory;

trait GeneratesToken {
    
    public function generateToken($data) {
        // create a server request object
        $serverRequest = ServerRequestFactory::fromGlobals(null, null, $data);

        // utilize laravel passport controller to generate token
        // instead of creating to internal request call to AccessTokenController
        // directly use the controller to generate a response
        $accessTokenController = app('Laravel\Passport\Http\Controllers\AccessTokenController');
        // returns a Illuminate\Http\Response
        $response = $accessTokenController->issueToken($serverRequest);
        return json_decode($response->getContent());
    }
}
