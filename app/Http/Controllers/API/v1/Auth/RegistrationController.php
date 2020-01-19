<?php
namespace App\Http\Controllers\API\v1\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

use App\Http\Controllers\ApiController;
use App\Http\Traits\GeneratesToken;
use App\Http\Requests\Auth\RegistrationRequest;


use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Auth\OAuthRepositoryInterface;

use Illuminate\Http\Request;
class RegistrationController extends ApiController {

    use GeneratesToken;

    private $userRepository;
    private $oAuthRepository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface,
        OAuthRepositoryInterface $oAuthRepositoryInterface) {
        $this->middleware('guest');

        $this->userRepository = $userRepositoryInterface;
        $this->oAuthRepository = $oAuthRepositoryInterface;
    }

    public function register(RegistrationRequest $request) {
        $client = $this->getPGCClient();

        $user = $this->userRepository->create($request->all());
        event(new Registered($user));

        // $data = [
        //     'grant_type' => config('constants.oAuth.grant_type_password'),
        //     'client_id' => $client->id,
        //     'client_secret' => $client->secret,
        //     'username' => $request->email,
        //     'password' => $request->password,
        //     'scope' => ''
        // ];
        
        // // generate token from using email and password
        // $token = $this->generateToken($data);

        // // TODO:: add redirect if wants to frontend to login into app
        // // TODO:: add login 
        $user->sendEmailVerificationNotification();

        // return $this->responseWithTokenAndUser(200, $token, $user);
        return $this->responseWithMessage(200, 'Successfully registered. An email will be sent to verify your account.');
    }

    // get PGC - Password Grant Client from DB
    protected function getPGCClient() {
        $client = $this->oAuthRepository->findClient(2);
        if ($client == null) 
            throw new \Exception('PGC not found.');

        return $client;
    }
}
