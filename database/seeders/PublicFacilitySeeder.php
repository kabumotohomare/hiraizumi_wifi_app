<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicFacility;
use GuzzleHttp\Client;

class PublicFacilitySeeder extends Seeder
{
    private function getCoordinatesFromAddress($address)
    {
        // Google Maps Geocoding API endpoint
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';

        // Your Google Maps API key
        $apiKey = 'AIzaSyDEfwfDr0RT5xanUbNo-KY4m8QV_Zl4y6U';

        // GuzzleHTTPクライアントを使用
        $client = new Client();

        // リクエスト送信
        $response = $client->get($url, [
            'query' => [
                'address' => $address,
                'key'    => $apiKey,
                'language' => 'ja',  // Japanese for Japanese addresses
            ]
        ]);

        // JSONレスポンスを取得してデコード
        $data = json_decode($response->getBody(), true);

        // ステータスがOKなら緯度と経度を取得
        if ($data['status'] == 'OK') {
            return [
                'lat' => $data['results'][0]['geometry']['location']['lat'],
                'lng' => $data['results'][0]['geometry']['location']['lng']
            ];
        }

        return null;
    }

    public function run()
    {
        $facilities = [
            [
                'name' => '平泉町立平泉小学校長島小学校体育館',
                'address' => '岩手県西磐井郡平泉町',
                'phone' => '教育委員会の連絡先に確認が必要',
                'reservation_flag' => false,
            ],
            [
                'name' => '平泉町立平泉中学校体育館',
                'address' => '岩手県西磐井郡平泉町',
                'phone' => '教育委員会の連絡先に確認が必要',
                'reservation_flag' => false,
            ],
            [
                'name' => '平泉町立長島体育館',
                'address' => '岩手県西磐井郡平泉町長島字砂子沢167-2',
                'phone' => '0191-46-5576',
                'reservation_flag' => true,
            ],
            [
                'name' => '平泉町営テニスコート',
                'address' => '岩手県西磐井郡平泉町平泉字倉町',
                'phone' => '0191-46-5576',
                'reservation_flag' => true,
            ],
            [
                'name' => '平泉町営長島球場',
                'address' => '岩手県西磐井郡平泉町長島字砂子沢',
                'phone' => '0191-46-3003',
                'reservation_flag' => true,
            ],
        ];

        foreach ($facilities as $facility) {
            // Google Maps APIで緯度経度を取得
            $coordinates = $this->getCoordinatesFromAddress($facility['address']);
            
            PublicFacility::create([
                'name' => $facility['name'],
                'address' => $facility['address'],
                'phone' => $facility['phone'],
                'reservation_flag' => $facility['reservation_flag'],
                'lat' => $coordinates['lat'] ?? null,  // 緯度
                'lng' => $coordinates['lng'] ?? null,  // 経度
                'postal_code' => null,  // Google APIから郵便番号を取得したい場合は別途追加
            ]);
        }
    }
}
