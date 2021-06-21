<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Pagination\Paginator;

class UserRepository
{
    public static function getUsers($searchCondition) : Collection
    {
        // 조회할 페이지 세팅
        $currentPage = $searchCondition['page'] ?? 2;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        // 검색 조건 연결
        $usersQuery = User::select('id', 'name', 'nickname', 'email', 'gender');
        if(! empty($searchCondition['name'])) {
            $usersQuery->where('name', $searchCondition['name']);
        }
        if(! empty($searchCondition['email'])) {
            $usersQuery->where('email', $searchCondition['email']);
        }

        // 쿼리
        $users = $usersQuery
            ->orderBy('id', 'desc')
            ->simplePaginate(config('search.contentsPerPage'))
            ->items();

        // 회원의 마지막 주문 포함    
        $addLastOrderOfUsers = [];
        foreach($users as $user) {
            $orders = $user->orders->toArray();
            $lastOrder = count($orders) > 0 ? $orders[count($orders) - 1] : [];
            $addLastOrderOfUsers = Arr::add($addLastOrderOfUsers, sprintf('%s|%s', $user->name, $user->nickname), [
                'id' => $user->id,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'email' => $user->email,
                'gender' => $user->gender,
                'lastOrder' => $lastOrder,
            ]);
        }

        return collect($addLastOrderOfUsers);    
    }
    
    public static function getUserById(int $id) : User
    {
        return User::find($id);
    }

    public static function getLastUser() : User
    {
        return User::last();
    }

    public static function addUser(Collection $joinUser) : bool
    {
        $newUser = new User();
        $newUser->name = $joinUser->get('name');
        $newUser->nickname = $joinUser->get('nickname');
        $newUser->password = $joinUser->get('password');
        $newUser->email = $joinUser->get('email');
        $newUser->phone_num = $joinUser->get('phone_num');
        $newUser->gender = $joinUser->get('gender') ?? '';
        $result = $newUser->save();

        return $result;
    }
}