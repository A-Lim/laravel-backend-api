<?php
namespace App\Repositories\UserGroup;

use App\UserGroup;

interface UserGroupRepositoryInterface
{
     /**
     * List usergroup
     * 
     * @param array $query
     * @param boolean $paginate = false
     * @return [UserGroup]
     */
    public function list($query);

    /**
     * Find usergroup from id
     * 
     * @param integer $id
     * @return UserGroup
     */
    public function find($id);

    
    /**
     * Creates a usergroup
     * 
     * @param array $data
     * @return UserGroup
     */
    public function create($data);

    /**
     * Updates a usergroup
     * 
     * @param UserGroup $userGroup
     * @param array $data
     * @return UserGroup
     */
    public function update(UserGroup $userGroup, $data);

    /**
     * Deletes a usergroup
     * 
     * @param UserGroup $userGroup
     * @param bool $forceDelete
     * @return void
     */
    public function delete(UserGroup $userGroup, $forceDelete = false);

}