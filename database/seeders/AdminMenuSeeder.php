<?php

namespace Database\Seeders;

use Encore\Admin\Auth\Database\Menu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    public function run()
    {
        // メニューのリセット
        Menu::truncate();

        // ダッシュボード
        Menu::create([
            'title' => 'Dashboard',
            'icon'  => 'fa-bar-chart',
            'uri'   => '/',
        ]);

        // 親メニュー「管理」作成
        $adminParent = Menu::create([
            'title' => '管理',
            'icon'  => 'fa-cog',
            'uri'   => '',
        ]);

        // 管理配下のメニュー
        Menu::create([
            'title' => 'Admin Users',
            'icon'  => 'fa-users',
            'uri'   => 'auth/users',
            'parent_id' => $adminParent->id,  // 親メニューのIDを設定
        ]);

        Menu::create([
            'title' => 'Roles',
            'icon'  => 'fa-user-circle',
            'uri'   => 'auth/roles',
            'parent_id' => $adminParent->id,  // 親メニューのIDを設定
        ]);

        Menu::create([
            'title' => 'Permission',
            'icon'  => 'fa-ban',
            'uri'   => 'auth/permissions',
            'parent_id' => $adminParent->id,  // 親メニューのIDを設定
        ]);

        Menu::create([
            'title' => 'Menu',
            'icon'  => 'fa-bars',
            'uri'   => 'auth/menu',
            'parent_id' => $adminParent->id,  // 親メニューのIDを設定
        ]);

        Menu::create([
            'title' => 'Operation Log',
            'icon'  => 'fa-history',
            'uri'   => 'auth/logs',
            'parent_id' => $adminParent->id,  // 親メニューのIDを設定
        ]);

        // 親メニュー「店舗管理」作成
        $storeParent = Menu::create([
            'title' => '店舗管理',
            'icon'  => 'fa-building',
            'uri'   => '',
        ]);

        // 店舗管理配下のメニュー
        Menu::create([
            'title' => '店舗情報',
            'icon'  => 'fa-building-o',
            'uri'   => 'stores',
            'parent_id' => $storeParent->id,  // 親メニューのIDを設定
        ]);

        Menu::create([
            'title' => 'カテゴリ',
            'icon'  => 'fa-list',
            'uri'   => 'categories',
            'parent_id' => $storeParent->id,  // 親メニューのIDを設定
        ]);

        // 親メニュー「公共施設管理」作成
        $facilityParent = Menu::create([
            'title' => '公共施設管理',
            'icon'  => 'fa-support',
            'uri'   => '',
        ]);

        // 公共施設管理配下のメニュー
        Menu::create([
            'title' => '公共施設',
            'icon'  => 'fa-support',
            'uri'   => 'public-facilities',
            'parent_id' => $facilityParent->id,  // 親メニューのIDを設定
        ]);

        Menu::create([
            'title' => '仮予約',
            'icon'  => 'fa-calendar-check-o',
            'uri'   => 'temporary-publicfacility',
            'parent_id' => $facilityParent->id,  // 親メニューのIDを設定
        ]);

        Menu::create([
            'title' => '予約確定',
            'icon'  => 'fa-check',
            'uri'   => 'confirmed-publicfacility',
            'parent_id' => $facilityParent->id,  // 親メニューのIDを設定
        ]);
    }
}
