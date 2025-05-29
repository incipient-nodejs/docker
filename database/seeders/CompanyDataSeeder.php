<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\CompanyData;
use App\Models\User;

class CompanyDataSeeder extends Seeder
{
    public const COMPANY_1 = [
        'name' => 'Empresa Alpha',
        'nif' => '123456789',
        'location' => 'Lisboa',
        'certification' => 'ISO 9001',
    ];

    public const COMPANY_2 = [
        'name' => 'Empresa Beta',
        'nif' => '987654321',
        'location' => 'Porto',
        'certification' => 'ISO 14001',
    ];

    public const COMPANY_3 = [
        'name' => 'Empresa Gamma',
        'nif' => '456123789',
        'location' => 'Coimbra',
        'certification' => 'ISO 27001',
    ];

    public const COMPANY_4 = [
        'name' => 'Empresa Delta',
        'nif' => '321654987',
        'location' => 'Faro',
        'certification' => 'ISO 22000',
    ];

    public const COMPANY_5 = [
        'name' => 'Empresa Epsilon',
        'nif' => '789321456',
        'location' => 'Braga',
        'certification' => 'ISO 50001',
    ];

    public const ITEMS = [
        self::COMPANY_1,
        self::COMPANY_2,
        self::COMPANY_3,
        self::COMPANY_4,
        self::COMPANY_5,
    ];

    public function run()
    {
        $phones = collect(UserSeeder::ITEM_FORMAL_TYPE, UserSeeder::ITEM_INFORMAL_TYPE)
            ->map(function($it) { return $it['phone']; })
            ->all();

        $users = User::whereIn('phone', $phones)->get();

        $usedUserIds = [];
        $counter = 0;

        while ($counter < count(self::ITEMS)) {
            $remainingUsers = $users->whereNotIn('id', $usedUserIds);
            if ($remainingUsers->isEmpty()) break;

            $item = self::ITEMS[$counter];
            $randomIndex = rand(0, $remainingUsers->count() - 1);
            $user = $remainingUsers->values()->get($randomIndex);
            $usedUserIds[] = $user->id;
            $data = array_merge($item, ['uuid' => Str::uuid()->toString(), 'user_id' => $user->id,]);
            CompanyData::updateOrCreate(['user_id' => $data['user_id']], $data);
            $counter++;
        }
    }
}
