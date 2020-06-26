<?php

namespace App\Http\Controllers\API\v1\UserGroup;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\UserGroup;
use App\Repositories\UserGroup\UserGroupRepositoryInterface;

use App\Http\Requests\UserGroup\CreateRequest;
use App\Http\Requests\UserGroup\UpdateRequest;

class UserGroupController extends ApiController {

    private $userGroupRepository;

    public function __construct(UserGroupRepositoryInterface $userGroupRepositoryInterface) {
        $this->middleware('auth:api');
        $this->userGroupRepository = $userGroupRepositoryInterface;
    }
    
    public function list(Request $request) {
        $this->authorize('viewAny', UserGroup::class);
        $userGroups = $this->userGroupRepository->list($request->all(), true);
        return $this->responseWithData(200, $userGroups);
    }

    public function create(CreateRequest $request) {
        $this->authorize('create', UserGroup::class);
        $userGroup = $this->userGroupRepository->create($request->all());
        return $this->responseWithMessageAndData(201, $userGroup, 'User group created.');
    }

    public function details(UserGroup $userGroup) {
        $this->authorize('view', $userGroup);
        return $this->responseWithData(200, $userGroup); 
    }

    public function update(UpdateRequest $request, UserGroup $userGroup) {
        $this->authorize('update', $userGroup);
        $userGroup = $this->userGroupRepository->update($userGroup, $request->all());
        return $this->responseWithMessageAndData(200, $userGroup, 'User group updated.'); 
    }

    public function delete(UserGroup $userGroup) {
        $this->authorize('delete', $userGroup);
        $this->userGroupRepository->delete($userGroup);
        return $this->responseWithMessage(200, 'User group deleted.');
    }
}
