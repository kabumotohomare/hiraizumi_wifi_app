<?php

namespace App\Admin\Controllers;

use App\Models\Store;
use App\Models\Gym;
use App\Models\ConfirmedPublicFacilityReservation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;

class DashboardController extends AdminController
{
    public function index(Content $content)
    {
        // 申請中の店舗一覧
        $pendingStores = Store::where('approval_flag', false)->get();

        // 表示中の店舗数
        $visibleStoreCount = Store::where('approval_flag', true)->where('display_flag', true)->count();

        // 予約可能な店舗数
        $reservableStoreCount = Store::whereHas('category', function($query) {
            $query->where('reservation_flag', true);
        })->count();

        // 体育館の予約確定情報
        $gymReservations = ConfirmedPublicFacilityReservation::with('gym')->get();

        return $content
            ->title('ダッシュボード')
            ->row(new Box('申請中の店舗一覧', view('admin.pending_stores', ['stores' => $pendingStores])))
            ->row(new Box('表示中の店舗数', $visibleStoreCount))
            ->row(new Box('予約可能な店舗数', $reservableStoreCount))
            ->row(new Box('体育館予約確定情報', view('admin.gym_reservations', ['reservations' => $gymReservations])));
    }
}
