<?php

namespace App\Services;

use App\Interfaces\Services\CRUDService;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService implements CRUDService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 회원 목록
     *
     * @return Collection
     */
    public function getList() : Collection
    {
        return $this->userRepository->getUsers();
    }


    /**
     * 회원 상세
     *
     * @param integer $id
     * @return User
     */
    public function getById(int $id) : Collection
    {
        return $this->userRepository->getUserById($id);
    }

    /**
     * 회원 가입
     *
     * @param User $user
     * @return User
     */
    public function add(User $user) : User
    {
        return User::getLastUser();
    }
}