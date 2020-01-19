<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Repositories\User\UserRepositoryInterface;

use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UploadAvatarRequest;
use App\Http\Requests\User\UpdateProfileRequest;

class UserController extends ApiController {

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface) {
        $this->middleware('auth:api');
        $this->userRepository = $userRepositoryInterface;
    }
    
    public function list(Request $request) {
        $this->authorize('viewAny', User::class);
        $users = $this->userRepository->datatableList($request->all(), true);
        return $this->responseWithData(200, $users);
    }

    public function profile() {
        return $this->responseWithData(200, auth()->user()); 
    }

    public function updateProfile(UpdateProfileRequest $request) {
        $authUser = auth()->user();
        $this->authorize('updateProfile', $authUser);

        // prevent user from updating anything else like status, verified_at etc
        $data = $request->only(['name']);

        // if user has oldPassword filled,
        // user attempting to change password
        if ($request->has('oldPassword')) {
            $credentials = ['email' => $authUser->email, 'password' => $request->oldPassword];
            if (!Auth::check($credentials)) {
                return $this->responseWithMessage(401, 'Invalid old password.');
            }
            $data['password'] = $request->newPassword;
        }

        $user = $this->userRepository->update(auth()->user(), $data);
        return $this->responseWithMessageAndData(200, $user, 'Profile updated.');  
    }

    public function uploadProfileAvatar(UploadAvatarRequest $request) {
        $imagePaths = $this->userRepository->saveAvatar(auth()->user(), $request->file('avatar'));
        return $this->responseWithData(200, $imagePaths);
    }

    public function uploadUserAvatar(UploadAvatarRequest $request, User $user) {
        $imagePaths = $this->userRepository->saveAvatar($user, $request->file('avatar'));
        return $this->responseWithData(200, $imagePaths);
    }
 
    public function details(User $user) {
        $this->authorize('view', $user);
        return $this->responseWithData(200, $user); 
    }

    public function update(UpdateRequest $request, User $user) {
        $this->authorize('update', $user);
        $data = $request->only(['name']);
        $userGroup = $this->userRepository->update($user, $data);
        return $this->responseWithMessageAndData(200, $user, 'Updated'); 
    }

}
