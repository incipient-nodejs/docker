<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\FormalType;
use App\Models\User;

class FormalTypeSeeder extends Seeder
{
    public const FORMAL_TYPE_TECH = [
        'name' => 'Tech Solutions',
        'nif' => '123456789',
        'docs' => 'document.pdf',
        'website' => 'https://techsolutions.com',
        'whatsapp' => '+123456789',
        'phone' => '+987654321',
        'offers' => 'Consultoria em TI, desenvolvimento de software',
    ];

    public const FORMAL_TYPE_SERVICE = [
        'name' => 'Global Services',
        'nif' => '987654321',
        'docs' => 'info.pdf',
        'website' => 'https://globalservices.com',
        'whatsapp' => '+111222333',
        'phone' => '+444555666',
        'offers' => 'Consultoria empresarial, soluções de marketing',
    ];

    public const ITEMS = [
        self::FORMAL_TYPE_TECH,
        self::FORMAL_TYPE_SERVICE,
    ];

    public function run()
    {
        $numbers = collect(UserSeeder::ITEM_FORMAL_TYPE)->map(function($it){return $it['phone'];})->all();
        $userFormls = User::whereIn('phone', $numbers)->get();
        $tam = count($userFormls);

        if($tam == 0) return;
        $items = self::ITEMS;

        if($tam < count($items)) $items = array_slice($items, 0, $tam);

        foreach ($items as $index => $item) {
            $item['user_id'] = $userFormls[$index]->id;
            $data = array_merge($item, ['uuid' => Str::uuid()->toString()]);
            FormalType::updateOrCreate(['nif' => $item['nif']], $data);
        }
    }
}
