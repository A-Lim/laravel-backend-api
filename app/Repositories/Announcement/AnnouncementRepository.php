<?php
namespace App\Repositories\Announcement;

use App\Announcement;
use Carbon\Carbon;

class AnnouncementRepository implements AnnouncementRepositoryInterface {

     /**
     * {@inheritdoc}
     */
    public function datatableList($data, $paginate = false) {
        $query = Announcement::query();
        $this->buildQuery($query, $data);

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

    /**
     * Build query based on allowed keys
     * 
     * @param Builder &$query
     * @param array $data
     */
    private function buildQuery(&$query, array $data) {
        $allowed = ['title', 'content', 'status', 'send_notification', 'schedule_at'];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowed)) {
                $query->where($key, 'LIKE', '%'.$value.'%');
            }
        }
    }
}