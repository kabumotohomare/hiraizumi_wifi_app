<?php

namespace App\Admin\Controllers;

use App\Models\Store;
use App\Models\ConfirmedPublicFacilityReservation;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    private function getCoordinatesFromAddress($address)
    {
        // Google Maps APIキー
        $apiKey = 'AIzaSyDEfwfDr0RT5xanUbNo-KY4m8QV_Zl4y6U';

        // Google Geocoding APIエンドポイント
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';

        // GuzzleHTTPクライアントを使用
        $client = new Client();

        // リクエスト送信
        $response = $client->get($url, [
            'query' => [
                'address' => $address,
                'key' => $apiKey
            ]
        ]);

        // JSONレスポンスを取得してデコード
        $data = json_decode($response->getBody(), true);

        // ステータスがOKなら緯度と経度を取得
        if ($data['status'] == 'OK') {
            $location = $data['results'][0]['geometry']['location'];
            return [
                'lat' => $location['lat'],
                'lng' => $location['lng']
            ];
        } else {
            // エラー処理
            return null;
        }
    }

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

        // 公共施設の予約確定情報
        $facilityReservations = ConfirmedPublicFacilityReservation::with('publicFacility')->get();

        return $content
            ->title('ダッシュボード')
            ->row(new Box('申請中の店舗一覧', view('admin.pending_stores', ['stores' => $pendingStores])))
            ->row(new Box('表示中の店舗数', $visibleStoreCount > 0 ? $visibleStoreCount : "まだ掲載店舗はありません"))
            ->row(new Box('予約可能な店舗数', $reservableStoreCount > 0 ? $reservableStoreCount : "まだ予約施設はありません"))
            ->row(new Box('公共施設予約確定情報', view('admin.facility_reservations', ['reservations' => $facilityReservations])));
    }
}
