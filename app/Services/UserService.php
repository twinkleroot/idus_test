<?php

namespace App\Services;

use App\Interfaces\Services\CRUDService;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

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
     * @param array $parameters
     * @return array
     */
    public function getUserListAddLastOrder(array $parameters) : array
    {
        // 회원 목록
        $users = $this->getList($parameters);
        // 회원의 마지막 주문까지 포함해서 리턴
        return $this->userRepository->setLastOrderOfUsers($users);
    }

    /**
     * 회원 목록
     *
     * @param array $parameters
     * @return array
     */
    public function getList(array $parameters) : array
    {
        // 페이지네이션 + 검색으로 회원 검색
        $page = $this->getPageFromParameters($parameters);
        $searchCondition = $this->getSearchConditionFromParameters($parameters);
        
        return $this->userRepository->getUsers($page, $searchCondition);
    }

    

    /**
     * 조회할 페이지 세팅
     *
     * @param array $parameters
     * @return string
     */
    private function getPageFromParameters(array &$parameters) : string
    {
        return  Arr::pull($parameters, 'page') ?? 1;
    }

    /**
     * 검색 조건 세팅
     *
     * @param array $parameters
     * @return array
     */
    private function getSearchConditionFromParameters(array $parameters) : array
    {
        $searchCondition = [];
        // name과 email만 검색조건에 해당함.
        if(isset($parameters['name'])) {
            $searchCondition = Arr::add($searchCondition, 'name', $parameters['name']);
        }
        if(isset($parameters['email'])) {
            $searchCondition = Arr::add($searchCondition, 'email', $parameters['email']);
        }

        return $searchCondition;
    }


    /**
     * 회원 상세
     *
     * @param integer $id
     * @return array
     */
    public function getById(int $id) : array
    {
        return $this->userRepository->getUserById($id)->toArray();
    }

    /**
     * 회원 가입
     *
     * @param array $userDatas
     * @return int
     */
    public function add(array $userDatas) : int
    {
        return $this->userRepository->addUser($userDatas);
    }

    /**
     * 회원 상세
     *
     * @param integer $id
     * @return array
     */
    public function getOrdersOfUser(int $id) : array
    {
        return $this->userRepository->getUserById($id)->orders->toArray();
    }
}