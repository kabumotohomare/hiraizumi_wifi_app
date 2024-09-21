<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Category;

class ShopSeeder extends Seeder
{
	private function getAddressFromCoordinates($lat, $lng)
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
				'latlng' => $lat . ',' . $lng,
				'key'    => $apiKey,
                'language' => 'ja'
			]
		]);
	
		// JSONレスポンスを取得してデコード
		$data = json_decode($response->getBody(), true);
	
		// ステータスがOKなら住所を取得
		if ($data['status'] == 'OK') {
            $fullAddress = $data['results'][0]['formatted_address'];
            // 「日本」を削除
            $addressWithoutJapan = str_replace('日本、〒', '', $fullAddress);

            // 正規表現を使用して郵便番号と住所を分ける
            if (preg_match('/(\d{3}-\d{4})(.*)/', $addressWithoutJapan, $matches)) {
                $postalCode = $matches[1];     // 郵便番号部分
                $address = trim($matches[2]);  // 住所部分

                return [
                    'address'    => $address,
                    'postalCode' => $postalCode
                ];
            }
		}
	
		return null; // 住所が取得できない場合
	}
	
    public function run()
    {

		Store::truncate();

		$shops = [
			[
				'name' => '中尊寺',
				'lat' => 39.3994,
				'lng' => 141.1039,
				'email' => 'info@chusonji.or.jp',
				'link' => 'https://www.chusonji.or.jp/',
				'category' => '寺院・世界遺産',
				'phone' => '0191-46-2211',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉衣関２０２',
			],
			[
				'name' => '毛越寺',
				'lat' => 39.3903,
				'lng' => 141.1161,
				'email' => 'info@motsuji.or.jp',
				'link' => 'http://www.motsuji.or.jp/',
				'category' => '寺院・世界遺産',
				'phone' => '0191-46-2331',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉大沢５８',
			],
			[
				'name' => '平泉文化遺産センター',
				'lat' => 39.3900,
				'lng' => 141.1130,
				'email' => 'info@hiraizumi-cultural-heritage-center.jp',
				'link' => 'https://www.hiraizumi-cultural-heritage-center.jp/',
				'category' => '博物館',
				'phone' => '0191-46-4012',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉花立４４',
			],
			[
				'name' => '岩手県立平泉世界遺産ガイダンスセンター',
				'lat' => 39.3880,
				'lng' => 141.1130,
				'email' => 'info@hiraizumi-guidance.jp',
				'link' => '',
				'category' => '観光案内所',
				'phone' => '0191-34-4711',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉伽羅楽１０８−１',
			],
			[
				'name' => '無量光院跡',
				'lat' => 39.3930,
				'lng' => 141.1140,
				'email' => '',
				'link' => 'https://hiraizumi.or.jp/spot/muryoko-in/',
				'category' => '史跡',
				'phone' => '0191-46-2111',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉花立',
			],
			[
				'name' => '観自在王院跡',
				'lat' => 39.3920,
				'lng' => 141.1150,
				'email' => '',
				'link' => 'https://hiraizumi.or.jp/spot/kanjizaio-in/',
				'category' => '史跡',
				'phone' => '0191-46-2111',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉志羅山',
			],
			[
				'name' => '衣関屋',
				'lat' => 39.3840,
				'lng' => 141.1151,
				'email' => '',
				'link' => 'https://hiraizu-meets.com/gourmet/isekiya/',
				'category' => '和食',
				'phone' => '0191-46-2733',
				'postal_code' => '029-4102',
				'address' => '岩手県 西磐井郡平泉町 平泉衣関34-2',
			],
			[
				'name' => 'レストラン源',
				'lat' => 39.3832,
				'lng' => 141.1176,
				'email' => '',
				'link' => 'http://www.hiraizumi2011.jp/',
				'category' => '和食',
				'phone' => '0191-46-2011',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉坂下１０−７',
			],
			[
				'name' => 'お食事処さくら',
				'lat' => 39.3889,
				'lng' => 141.1153,
				'email' => '',
				'link' => 'http://www.sakura-hiraizumi.jp/',
				'category' => '和食',
				'phone' => '0191-46-5651',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉字日照田９０−３',
			],
			[
				'name' => '夢乃風',
				'lat' => 39.3867,
				'lng' => 141.1152,
				'email' => '',
				'link' => '',
				'category' => 'カフェ・軽食',
				'phone' => '0191-46-2641',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉花立１１−２',
			],
			[
				'name' => '泉橋庵 総本店',
				'lat' => 39.3908,
				'lng' => 141.1139,
				'email' => '',
				'link' => '',
				'category' => '和食',
				'phone' => '0191-46-5068',
				'postal_code' => '029-4102',
				'address' => '岩手県西大井郡平泉町鈴沢平泉67-1',
			],
			[
				'name' => '談笑',
				'lat' => 39.3852,
				'lng' => 141.1175,
				'email' => '',
				'link' => '',
				'category' => '居酒屋',
				'phone' => '0191-46-4393',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉志羅山１５３−２',
			],
			[
				'name' => '道の駅 平泉 レストラン',
				'lat' => 39.3877,
				'lng' => 141.1137,
				'email' => '',
				'link' => 'http://www.thr.mlit.go.jp/iwate/yakudati/michinoeki/32_hiraizumi.html',
				'category' => 'レストラン',
				'phone' => '0191-48-4795',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉伽羅楽１１２−２',
			],
			[
				'name' => '平泉ホテル武蔵坊',
				'lat' => 39.3955,
				'lng' => 141.1044,
				'email' => '',
				'link' => 'http://www.musasibou.co.jp',
				'category' => 'ホテル',
				'phone' => '0191-46-2241',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉大沢15',
			],
			[
				'name' => '世界遺産の隠れ宿 果実の森',
				'lat' => 39.3947,
				'lng' => 141.1066,
				'email' => '',
				'link' => 'https://www.kajitsunomori-iwate.jp',
				'category' => '温泉宿',
				'phone' => '0191-34-6600',
				'postal_code' => '021-0041',
				'address' => '岩手県一関市赤荻笹谷３９３−６',
			],
			[
				'name' => '平泉温泉旅館 蕎麦庵 静華亭',
				'lat' => 39.3840,
				'lng' => 141.1151,
				'email' => '',
				'link' => 'https://shizukatei.com',
				'category' => '旅館・温泉',
				'phone' => '0191-34-2211',
				'postal_code' => '029-4102',
				'address' => '岩手県西磐井郡平泉町平泉長倉１０−５',
			] 
		];

        foreach ($shops as $shop) {
            $category = Category::where('category_name', $shop['category'])->first();
            if ($category) {
                Store::create([
                    'name' => $shop['name'],
                    'lat' => $shop['lat'],
                    'lng' => $shop['lng'],
                    'email' => $shop['email'],
                    'link' => $shop['link'],
                    'category_id' => $category->id,
                    'phone' => $shop['phone'],
                    'postal_code' => $shop['postal_code'],
                    'address' => $shop['address'],
                    'display_flag' => true,  // Assuming all entries should be visible by default
                ]);
            }
        }
    }
}
