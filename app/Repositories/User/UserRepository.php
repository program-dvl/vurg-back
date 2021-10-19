<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    /**
     * @var App\Models\User
     */
    private $user;

    /**
     * Create a new user repository instance.
     *
     * @param  App\Models\User $state
     * @return void
     */
    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    /**
     * get user details.
     *
     * @param int $userId
     * @return App\Models\User
     */
    public function userDetails(int $userId): User
    {
        return $this->user->find($userId);
    }

    /**
     * get user details.
     *
     * @param string $userId
     * @return App\Models\User
     */
    public function userDetailsByEmail(string $emailId): User
    {
        return $this->user->where('email', $emailId)->firstOrFail();
    }

    /**
     * get user details for profile.
     *
     * @param int $userId
     * @return App\Models\User
     */
    public function userDetailsForProfile(int $userId): User
    {
        return User::with(['settings' , 'preferredCurrency', 'timezone', 'phonecode'])->find($userId);
    }

    /**
     * Update user details.
     *
     * @param int $userId
     * @param array $dataUpdate
     * @return boolean
     */
    public function updateUserDetails(int $userId, $dataUpdate)
    {
        User::where("id", $userId)->update($dataUpdate);
        return true;
    }
}
