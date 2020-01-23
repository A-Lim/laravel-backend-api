<?php

namespace App\Policies;

use App\User;
use App\Announcement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy {
    use HandlesAuthorization;

    /**
     * Bypass any policy
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function before(User $user, $ability) {
        if ($user->isAdmin())
            return true;
    }

    /**
     * Determine whether the user can view any announcements.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user) {
        return $user->can('announcements.viewAny');
    }

    /**
     * Determine whether the user can view the announcement.
     *
     * @param  \App\User  $user
     * @param  \App\Announcement  $announcement
     * @return mixed
     */
    public function view(User $user, Announcement $announcement) {
        return $user->can('announcements.view');
    }

    /**
     * Determine whether the user can create announcement.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user) {
        return $user->can('announcements.create');
    }

    /**
     * Determine whether the user can update the announcement.
     *
     * @param  \App\User  $user
     * @param  \App\Announcement  $announcement
     * @return mixed
     */
    public function update(User $user, Announcement $announcement) {
        return $user->can('announcements.update');
    }

    /**
     * Determine whether the user can delete the announcement.
     *
     * @param  \App\User  $user
     * @param  \App\Announcement  $announcement
     * @return mixed
     */
    public function delete(User $user, Announcement $announcement) {
        return $user->can('announcements.delete');
    }

    /**
     * Determine whether the user can restore the announcement.
     *
     * @param  \App\User  $user
     * @param  \App\Announcement  $announcement
     * @return mixed
     */
    public function restore(User $user, Announcement $announcement) {
        //
    }

    /**
     * Determine whether the user can permanently delete the announcement.
     *
     * @param  \App\User  $user
     * @param  \App\Announcement  $announcement
     * @return mixed
     */
    public function forceDelete(User $user, Announcement $announcement) {
        //
    }
}
