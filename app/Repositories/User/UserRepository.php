<?php
namespace App\Repositories\User;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;

use App\Helpers\ImageProcessor;
// use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Facades\Image;
// use Illuminate\Http\File;

class UserRepository implements UserRepositoryInterface {
    
    /**
     * {@inheritdoc}
     */
    public function datatableList($data, $paginate = false) {
        $query = User::query();
        $this->buildQuery($query, $data);

        if ($paginate)
            return $query->paginate(10);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return User::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function searchForOne($params) {
        return User::where($params)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create($data) {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(User $user, $data) {
        if (!empty($data['password']))
            $data['password'] = Hash::make($data['password']);

        $user->fill($data);
        $user->save();
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function resetPassword(User $user, $password) {
        $user->password = $password;
        $user->setRememberToken(Str::random(60));
        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function saveAvatar(User $user, UploadedFile $file) {
        $imagePaths = [];

        $image = new ImageProcessor($file, 'users/avatar', $user->id);
        $imagePaths['normal'] = $image->fit(400, 400)->save();

        $image = new ImageProcessor($file, 'users/avatar', $user->id);
        $imagePaths['placeholder'] = $image->placeholder(400, 400)->save();

        $image = new ImageProcessor($file, 'users/avatar', $user->id);
        $imagePaths['thumbnail'] = $image->thumbnail()->save();

        $user->avatar = json_encode($imagePaths);
        $user->save();

        return $user->avatar;
    }

    /**
     * Build query based on allowed keys
     * 
     * @param Builder &$query
     * @param array $data
     */
    private function buildQuery(&$query, array $data) {
        $allowed = ['name', 'email', 'status'];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowed)) {
                $query->where($key, 'LIKE', '%'.$value.'%');
            }
        }
    }
}