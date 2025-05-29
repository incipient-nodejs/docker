<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\PersonalData;
use App\Models\User;

class PersonalDataSeeder extends Seeder
{
    public const JOAO_SILVA = [
        'name' => 'João',
        'full_name' => 'João Silva Oliveira',
        'nif_bi' => '12345678',
        'phone' => '912345678',
    ];

    public const MARIA_SANTOS = [
        'name' => 'Maria',
        'full_name' => 'Maria Santos Costa',
        'nif_bi' => '87654321',
        'phone' => '923456789',
    ];

    public const ANTONIO_FERREIRA = [
        'name' => 'António',
        'full_name' => 'António Ferreira Martins',
        'nif_bi' => '45678912',
        'phone' => '934567890',
    ];

    public const CARLA_RODRIGUES = [
        'name' => 'Carla',
        'full_name' => 'Carla Rodrigues Sousa',
        'nif_bi' => '56781234',
        'phone' => '945678901',
    ];

    public const PEDRO_COSTA = [
        'name' => 'Pedro',
        'full_name' => 'Pedro Costa Almeida',
        'nif_bi' => '67891234',
        'phone' => '956789012',
    ];

    public const ITEMS = [
        self::JOAO_SILVA,
        self::MARIA_SANTOS,
        self::ANTONIO_FERREIRA,
        self::CARLA_RODRIGUES,
        self::PEDRO_COSTA,
    ];

    public function run()
    {
        $phones = collect(UserSeeder::ITEM_FORMAL_TYPE, UserSeeder::ITEM_INFORMAL_TYPE)
        ->map(function($it){return $it['phone'];})
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
            if(!in_array($user->id, $usedUserIds)){
                $usedUserIds[] = $user->id;
                $data = array_merge($item, ['uuid' => Str::uuid()->toString(),'user_id' => $user->id, ]);
                PersonalData::updateOrCreate(['user_id' => $data['user_id']], $data);
                $counter++;
            }else{

            }
        }
    }
}
