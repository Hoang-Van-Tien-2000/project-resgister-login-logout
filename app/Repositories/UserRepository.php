<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }
}    