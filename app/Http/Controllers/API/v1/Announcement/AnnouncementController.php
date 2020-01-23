<?php

namespace App\Http\Controllers\API\v1\Announcement;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Announcement;
use App\Http\Requests\Announcement\CreateRequest;
use App\Http\Requests\Announcement\UpdateRequest;
use App\Repositories\Announcement\AnnouncementRepositoryInterface;

class AnnouncementController extends ApiController {

    private $announcementRepository;

    public function __construct(AnnouncementRepositoryInterface $announcementRepositoryInterface) {
        $this->middleware('auth:api');
        $this->announcementRepository = $announcementRepositoryInterface;
    }

    public function list(Request $request) {
        $this->authorize('viewAny', Announcement::class);
        $announcements = $this->announcementRepository->datatableList($request->all(), true);
        return $this->responseWithData(200, $announcements);
    }

    public function details(Announcement $announcement) {
        $this->authorize('view', $announcement);
        return $this->responseWithData(200, $announcement);
    }

    public function create(CreateRequest $request) {
        $this->authorize('create', Announcement::class);
        $announcement = $this->announcementRepository->create($request->all());

        if ($announcement->status == Announcement::STATUS_ACTIVE) {
            $now = Carbon::now();
            $schedule_datetime = Carbon::parse($announcement->schedule_at);
            if ($schedule_datetime->lessThanOrEqualTo($now)) {
                // send notification event
            }
        }

        return $this->responseWithMessageAndData(201, $announcement, 'Announcement created.');
    }

    public function update(UpdateRequest $request, Announcement $announcement) {
        $this->authorize('update', $announcement);
        $announcement = $this->announcementRepository->update($announcement, $request->all());

        // send notification event
        return $this->responseWithMessage(200, 'Announcement updated.');
    }

    public function delete(Request $request, Announcement $announcement) {
        $this->authorize('delete', $announcement);
        $this->announcementRepository->delete($announcement);
        return $this->responseWithMessage(200, 'Announcement deleted.');
    }
}
