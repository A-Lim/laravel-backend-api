<?php
namespace App\Repositories\Announcement;

use App\Announcement;

interface AnnouncementRepositoryInterface {
     /**
     * List announcements for datatable
     * 
     * @param array $query
     * @param boolean $paginate = false
     * @return array [Announcements] / LengthAwarePaginator
     */
    public function list($data, $paginate = false);

    /**
     * Create announcement
     * 
     * @param array $data
     * @return Announcement
     */
    public function create($data);

     /**
     * Update announcement
     * 
     * @param Announcement $announcement
     * @param array $data
     * @return void
     */
    public function update(Announcement $announcement, $data);
}