use Illuminate\Database\Seeder;
use App\Models\User; // もし User モデルを使用している場合

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // 共通の管理者アカウントを作成
        User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);
    }
}
