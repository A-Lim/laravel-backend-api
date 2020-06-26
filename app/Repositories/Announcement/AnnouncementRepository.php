<?php
namespace App\Repositories\Announcement;

use App\Announcement;
use Carbon\Carbon;

class AnnouncementRepository implements AnnouncementRepositoryInterface {

     /**
     * {@inheritdoc}
     */
    public function list($data, $paginate = false) {
        $query = Announcement::buildQuery($data);

        if ($paginate)
            return $query->paginate(10);

        return $query->get();
    }

     /**
     * {@inheritdoc}
     */
    public function create($data) {
        $data['status'] = $this->getStatus($data['action']);
        $data['created_by'] = auth()->id();
        return Announcement::create($data);
    }

     /**
     * {@inheritdoc}
     */
    public function update(Announcement $announcement, $data) {
        $data['status'] = $this->getStatus($data['action']);
        $data['updated_by'] = auth()->id();
        $announcement->update($data);
    }

     /**
     * {@inheritdoc}
     */
    public function delete(Announcement $announcement, $forceDelete = false) {
        if ($forceDelete) {
            $announcement->forceDelete();
        } else {
            $data['updated_by'] = auth()->id();
            $data['deleted_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $announcement->fill($data);
            $announcement->save();
        }
    }
    
     /**
     * Get status based on action
     * 
     * @param string $action
     * @return string 
     */
    private function getStatus($action) {
        $status = '';
        switch ($action) {
            case Announcement::ACTION_SAVE:
                $status = Announcement::STATUS_DRAFT;
                break;
            
            case Announcement::ACTION_PUBLISH:
                $status = Announcement::STATUS_ACTIVE;
                break;
        }

        return $status;
    }
}