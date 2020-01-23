<?php

namespace App\Http\Controllers\API\v1\SystemSetting;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\SystemSetting\SystemSettingRepositoryInterface;

class SystemSettingController extends ApiController {

    private $systemSettingRepository;

    public function __construct(SystemSettingRepositoryInterface $systemSettingRepositoryInterface) {
        $this->middleware('auth:api');
        $this->systemSettingRepository = $systemSettingRepositoryInterface;
    }

    public function list(Request $request) {
        $systemSettings = $this->systemSettingRepository->list();
        return $this->responseWithData(200, $systemSettings);
    }

    public function update(Request $request) {
        $this->systemSettingRepository->update($request->all());
        return $this->responseWithMessage(200, 'System settings updated.');
    }
}
