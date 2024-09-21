<?php

namespace Database\Seeders;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Auth\Database\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        Administrator::truncate();
        Role::truncate();

        // 管理者ユーザーを直接作成
        $admin = Administrator::firstOrCreate([
            'username' => 'admin'
        ], [
            'password' => '$2y$12$I1VYBKpt/rYGG7nfW49P5egiUuEAmjNRX/leQL7mqTzC0yPdIZN16',  // Hashed password
            'name' => 'Administrator',
            'avatar' => null,
            'remember_token' => 'IOATvchSSoLBpbRHF6yB39R6idaF4YWA7hC8L2VNlR7dAEHCSRCB5ZmvlfqI',
            'created_at' => '2024-09-17 23:16:24',
            'updated_at' => '2024-09-17 23:16:24',
        ]);

        // リーダーユーザー作成
        $leader = Administrator::firstOrCreate([
            'username' => 'leader'
        ], [
            'password' => Hash::make('password123'),
            'name'     => 'Leader User',
        ]);

        // スタッフユーザー作成
        $staff = Administrator::firstOrCreate([
            'username' => 'staff'
        ], [
            'password' => Hash::make('password123'),
            'name'     => 'Staff User',
        ]);

        // 管理者役割作成 (重複チェック)
        $adminRole = Role::firstOrCreate([
            'slug' => 'administrator'
        ], [
            'name' => 'Administrator'
        ]);

        // リーダー役割作成 (重複チェック)
        $leaderRole = Role::firstOrCreate([
            'slug' => 'leader'
        ], [
            'name' => 'Leader'
        ]);

        // スタッフ役割作成 (重複チェック)
        $staffRole = Role::firstOrCreate([
            'slug' => 'staff'
        ], [
            'name' => 'Staff'
        ]);

        /*
        Permission::create(['name' => 'dashboard', 'slug' => 'dashboard']);
        Permission::create(['name' => 'store.show', 'slug' => 'store.show']);
        Permission::create(['name' => 'category.show', 'slug' => 'category.show']);
        Permission::create(['name' => 'gym.show', 'slug' => 'gym.show']);
        */

        // 管理者の権限（全ての操作を許可）
        $adminPermissions = Permission::pluck('id')->all();
        $adminRole->permissions()->sync($adminPermissions);

        // リーダーの権限（全ての操作を許可）
        $leaderRole->permissions()->sync($adminPermissions);

        // スタッフの権限（検索と参照のみ）
        $staffPermissions = Permission::whereIn('name', ['dashboard', 'store.show', 'category.show', 'gym.show'])->pluck('id')->all();
        $staffRole->permissions()->sync($staffPermissions);

        // ユーザーに役割を割り当て
        $admin->roles()->sync($adminRole);
        $leader->roles()->sync($leaderRole);
        $staff->roles()->sync($staffRole);
    }
}
