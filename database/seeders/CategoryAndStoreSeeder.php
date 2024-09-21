<?php
namespace Database\Seeders; 

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;

class CategoryAndStoreSeeder extends Seeder
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
        // Storeテーブルのリセット（外部キー制約があるためdeleteを使用）
        Store::query()->delete();

        // Categoryテーブルのリセット（外部キー制約があるためdeleteを使用）
        Category::query()->delete();


        // カテゴリー作成
        $categories = [
            '寺院', '山', '道の駅', 'その他飲食店', '甘味処', 
            '歴史的建造物', '庭園', '資料/郷土/展示/文学館', 'そば/うどん', 
            'その他の史跡/建造物', 'お土産', '美術館', '温泉/温泉浴場', '雑貨','和菓子',
            '工房', '遺跡/墓/古墳', '博物館/科学館', '観光案内所'
        ];

        foreach ($categories as $categoryName) {
            Category::create(['category_name' => $categoryName, 'reservation_flag' => false, 'display_flag' => true]);
        }

        // 店舗作成
        $spots = [
            ['name' => '中尊寺', 'lat' => 39.3994, 'lng' => 141.1039, 'email' => 'info@chusonji.or.jp', 'link' => 'https://www.chusonji.or.jp/', 'category' => '寺院', 'phone' => '0191462211'],
            ['name' => '毛越寺', 'lat' => 39.3903, 'lng' => 141.1161, 'email' => 'info@motsuji.or.jp', 'link' => 'http://www.motsuji.or.jp/', 'category' => '寺院', 'phone' => '0191462331'],
            ['name' => '達谷窟毘沙門堂 別當 達谷西光寺', 'lat' => 39.3950, 'lng' => 141.1100, 'email' => 'info@takkoku.jp', 'link' => 'http://www.takkoku.jp/', 'category' => '寺院', 'phone' => '0191464931'],
            ['name' => '金鶏山', 'lat' => 39.3922, 'lng' => 141.1100, 'email' => 'info@hiraizumi.com', 'link' => 'https://hiraizumi.or.jp/spot/konjikidou/', 'category' => '山', 'phone' => '0191462110'],
            ['name' => '道の駅 平泉', 'lat' => 39.3886, 'lng' => 141.1136, 'email' => 'info@hiraizumi-michinoeki.jp', 'link' => 'https://www.hiraizumi-michinoeki.jp/', 'category' => '道の駅', 'phone' => '0191484795'],
            ['name' => '平泉レストハウス', 'lat' => 39.3980, 'lng' => 141.1070, 'email' => 'info@hiraizumi-resthouse.jp', 'link' => 'https://www.hiraizumi-resthouse.jp/', 'category' => 'その他飲食店', 'phone' => '0191462011'],
            ['name' => '松寿庵', 'lat' => 39.3994, 'lng' => 141.1039, 'email' => 'info@chusonji.or.jp', 'link' => 'https://www.chusonji.or.jp/', 'category' => '甘味処', 'phone' => '0191462211'],
            ['name' => '高館義経堂', 'lat' => 39.4000, 'lng' => 141.1150, 'email' => 'info@hiraizumi.com', 'link' => 'https://hiraizumi.or.jp/spot/takadachi/', 'category' => '歴史的建造物', 'phone' => '0191463300'],
            ['name' => '毛越寺庭園', 'lat' => 39.3903, 'lng' => 141.1161, 'email' => 'info@motsuji.or.jp', 'link' => 'http://www.motsuji.or.jp/', 'category' => '庭園', 'phone' => '0191462331'],
            ['name' => '平泉文化遺産センター', 'lat' => 39.3900, 'lng' => 141.1130, 'email' => 'info@hiraizumi-cultural-heritage-center.jp', 'link' => 'https://hiraizumi-cultural-heritage-center.jp/', 'category' => '資料/郷土/展示/文学館', 'phone' => '0191464012'],
            ['name' => '芭蕉館', 'lat' => 39.3883, 'lng' => 141.1139, 'email' => 'info@bashokan.jp', 'link' => 'https://www.bashokan.jp/', 'category' => 'そば/うどん', 'phone' => '0191465155'],
            ['name' => '観自在王院跡', 'lat' => 39.3920, 'lng' => 141.1150, 'email' => 'info@hiraizumi.com', 'link' => 'https://hiraizumi.or.jp/spot/kanjizaio-in/', 'category' => 'その他の史跡/建造物', 'phone' => '0191464012'],
            ['name' => '駅前芭蕉館', 'lat' => 39.3883, 'lng' => 141.1139, 'email' => 'info@ekimae-bashokan.jp', 'link' => 'https://www.ekimae-bashokan.jp/', 'category' => 'そば/うどん', 'phone' => '0191465555'],
            ['name' => '翁知屋', 'lat' => 39.3990, 'lng' => 141.1060, 'email' => 'info@ouclya.com', 'link' => 'https://www.ouclya.com/', 'category' => 'お土産', 'phone' => '0191462306'],
            ['name' => '中尊寺 讃衡蔵', 'lat' => 39.3994, 'lng' => 141.1039, 'email' => 'info@chusonji.or.jp', 'link' => 'https://www.chusonji.or.jp/', 'category' => '美術館', 'phone' => '0191462211'],
            ['name' => '無量光院跡', 'lat' => 39.3930, 'lng' => 141.1140, 'email' => 'info@hiraizumi.com', 'link' => 'https://hiraizumi.or.jp/spot/muryoko-in/', 'category' => 'その他の史跡/建造物', 'phone' => '0191462218'],
            ['name' => '悠久の湯平泉温泉', 'lat' => 39.3870, 'lng' => 141.1120, 'email' => 'info@yukyunoyu.jp', 'link' => 'https://www.yukyunoyu.jp/', 'category' => '温泉/温泉浴場', 'phone' => '0191341300'],
            ['name' => 'うるし塗体験工房Kuras(クラス)', 'lat' => 39.3990, 'lng' => 141.1060, 'email' => 'info@urushi-kuras.com', 'link' => 'https://www.urushi-kuras.com/', 'category' => '工房', 'phone' => '0191462306'],
            ['name' => '平泉世界遺産ガイダンスセンター', 'lat' => 39.3880, 'lng' => 141.1130, 'email' => 'info@hiraizumi-guidance.jp', 'link' => 'https://hiraizumi-guidance.jp/', 'category' => '資料/郷土/展示/文学館', 'phone' => '0191347377'],
            ['name' => '金色堂', 'lat' => 39.3994, 'lng' => 141.1039, 'email' => 'info@chusonji.or.jp', 'link' => 'https://www.chusonji.or.jp/', 'category' => 'その他の史跡/建造物', 'phone' => '0191462211'],
            ['name' => 'せき宮', 'lat' => 39.3885, 'lng' => 141.1140, 'email' => 'info@sekimiya.jp', 'link' => 'https://www.sekimiya.jp/', 'category' => '雑貨', 'phone' => '0191462070'],
            ['name' => '菓子工房 吉野屋', 'lat' => 39.3883, 'lng' => 141.1139, 'email' => 'info@yoshinoya-sweets.jp', 'link' => 'https://www.yoshinoya-sweets.jp/', 'category' => '和菓子', 'phone' => '0191462410'],
            ['name' => '柳之御所史跡公園', 'lat' => 39.3930, 'lng' => 141.1180, 'email' => 'info@yanaginogosho.jp', 'link' => 'https://www.yanaginogosho.jp/', 'category' => '遺跡/墓/古墳', 'phone' => '0196296488'],
            ['name' => '毛越寺宝物館', 'lat' => 39.3903, 'lng' => 141.1161, 'email' => 'info@motsuji.or.jp', 'link' => 'http://www.motsuji.or.jp/', 'category' => '博物館/科学館', 'phone' => '0191462331'],
            ['name' => '平泉観光案内所', 'lat' => 39.3883, 'lng' => 141.1139, 'email' => 'info@hiraizumi-kanko.jp', 'link' => 'https://www.hiraizumi-kanko.jp/', 'category' => '観光案内所', 'phone' => '0191462110'],
            ['name' => 'きになるお休み処 夢乃風', 'lat' => 39.3890, 'lng' => 141.1150, 'email' => 'info@yumenokaze.jp', 'link' => 'https://www.yumenokaze.jp/', 'category' => 'その他飲食店', 'phone' => '0191462000']
        ];

        foreach ($spots as $spot) {
            $category = Category::where('category_name', $spot['category'])->first();
			$address = $this->getAddressFromCoordinates($spot['lat'], $spot['lng']);

            Store::create([
                'name' => $spot['name'],
                'lat' => $spot['lat'],
                'lng' => $spot['lng'],
                'email' => $spot['email'],
                'link' => $spot['link'],
                'postal_code' => $address['postalCode'],
				'address' => $address['address'],
                'category_id' => $category->id,
                'phone' => $spot['phone'],
                'approval_flag' => true,
                'display_flag' => true
            ]);
        }
    }
}
