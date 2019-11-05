<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    /**
     * laravel 中用授权策略类（Policy）来对用户的操作权限进行验证，
     * 在用户未经授权进行操作时将返回403禁止访问的异常
     */
    use HandlesAuthorization;

    /**
     * 用于用户更新时的权限验证
     *
     * @param User $currentUser 默认为当前登陆用户实例
     * @param User $user 要进行授权的用户实例
     * @return void  当两个用户 id 相同时， 则代表两个用户时相同用户，用户通过授权
     * 如果 id 不相同的话， 将抛出 403 异常信息来拒绝访问
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }


    /**
     * 用于删除用户的权限验证
     *
     * @param User $currentUser 默认为当前登陆用户实例
     * @param User $user 要进行授权的用户实例
     * @return void 只有当前用户拥有管理员权限且删除的用户不是自己时才显示链接
     */
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

    /**
     * 用户不能自己关注自己
     *
     * @param User $currentUser
     * @param User $user
     * @return void
     */
    public function follow(User $currentUser, User $user)
    {
        return $currentUser->id !== $user->id;
    }
}
