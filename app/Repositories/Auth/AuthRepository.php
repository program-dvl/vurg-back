<?php

namespace App\Repositories\Auth;

use App\Models\User;

class AuthRepository
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
     * Store user details.
     *
     * @param array $request
     * @return App\Models\User
     */
    public function store(array $request): User
    {
        return $this->user->create($request);
    }

}
