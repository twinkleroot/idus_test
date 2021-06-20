<?php

namespace App\Services;

use App\Interfaces\Services\CRUDService;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;

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
    public function getList(array $searchCondition) : Collection
    {
        return $this->userRepository->getUsers([
            'name' => $searchCondition['name'] ?? '',
            'email' => $searchCondition['email'] ?? ''
        ]);
    }


    /**
     * 회원 상세
     *
     * @param integer $id
     * @return User
     */
    public function getById(int $id) : User
    {
        return $this->userRepository->getUserById($id);
    }

    /**
     * 회원 가입
     *
     * @param User $user
     * @return int
     */
    public function add(Collection $collection) : bool
    {
        return $this->userRepository->addUser($collection);
    }
}