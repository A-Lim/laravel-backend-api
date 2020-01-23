<?php
namespace App\Repositories\UserGroup;

use App\UserGroup;

class UserGroupRepository implements UserGroupRepositoryInterface {

     /**
     * {@inheritdoc}
     */
    public function datatableList($data, $paginate = false) {
        $query = UserGroup::query();
        $this->buildQuery($query, $data);

        if ($paginate)
            return $query->paginate(10);

        return $query->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return UserGroup::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create($data) {
        $data['deleted_at'] = null;
        $data['created_by'] = auth()->id();
        $userGroup = UserGroup::withTrashed()->updateOrCreate(
            ['code' => $data['code']],
            $data
        );

        // if isAdmin, dont save permissions, cause it's gonna be full access
        // save permissions if not admin
        if ($data['isAdmin'] == false && !empty($data['permissions'])) 
            $userGroup->givePermissions($data['permissions']);
        
        
        return UserGroup::with('permissions')->where('id', $userGroup->id)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function update(UserGroup $userGroup, $data) {
        $data['updated_by'] = auth()->id();

        if (!empty($data['code']))
            unset($data['code']);

        $userGroup->fill($data);
        $userGroup->save();
        return $userGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Usergroup $userGroup, $forceDelete = false) {
        if ($forceDelete) {
            $userGroup->forceDelete();
        } else {
            $data['updated_by'] = auth()->id();
            $data['deleted_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $userGroup->fill($data);
            $userGroup->save();
        }
    }

    /**
     * Build query based on allowed keys
     * 
     * @param Builder &$query
     * @param array $data
     */
    private function buildQuery(&$query, array $data) {
        $allowed = ['name', 'code', 'status', 'isAdmin'];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowed)) {
                $query->where($key, 'LIKE', '%'.$value.'%');
            }
        }
    }
}