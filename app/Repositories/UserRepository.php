<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Pagination\Paginator;

class UserRepository
{
    public static function getUsers(int $page, array $searchCondition) : array
    {
        // 조회할 페이지 세팅
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        
        return User::select('id', 'name', 'nickname', 'email', 'gender')
            ->where($searchCondition)
            ->orderBy('id', 'desc')
            ->simplePaginate(config('search.contentsPerPage'))
            ->items();
    }

    /**
     * 회원 목록에서 회원의 마지막 주문까지 포함
     *
     * @param array $users
     * @return array
     */
    public static function setLastOrderOfUsers(array $users) : array
    {
        $addLastOrderOfUsers = [];

        foreach($users as $user) {
            $orders = $user->orders->toArray();
            $lastOrder = count($orders) > 0 ? $orders[count($orders) - 1] : [];
            $addLastOrderOfUsers = Arr::add($addLastOrderOfUsers, sprintf('%s_%s', $user->id, $user->name), [
                'id' => $user->id,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'email' => $user->email,
                'gender' => $user->gender,
                'lastOrder' => $lastOrder,
            ]);
        }

        return $addLastOrderOfUsers;
    }

    public static function getUserById(int $id) : User
    {
        return User::select('id', 'name', 'nickname', 'email', 'gender')->find($id);
    }

    public static function addUser(array $joinUserDatas) : int
    {
        $joinUser = collect($joinUserDatas);

        $newUser = new User();
        $newUser->name = $joinUser->get('name');
        $newUser->nickname = $joinUser->get('nickname');
        $newUser->password = $joinUser->get('password');
        $newUser->email = $joinUser->get('email');
        $newUser->phone_num = $joinUser->get('phone_num');
        $newUser->gender = $joinUser->get('gender') ?? '';
        $newUser->save();
        
        return $newUser->id;
    }
}