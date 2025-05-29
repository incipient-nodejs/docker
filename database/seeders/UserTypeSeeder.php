<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\UserType;
use Carbon\Carbon;

class UserTypeSeeder extends Seeder
{

    const ADMIN =  [
        'name' => 'Admin',
        'code' => 'ADMIN',
        'description' => 'Permissão total',
    ];

    const FORMAL_TYPE =  [
        'name' => 'Formal',
        'code' => 'FORMAL_TYPE',
        'description' => 'Permissões parciais',
    ];

    const INFORMAL_TYPE = [
        'name' => 'Informal',
        'code' => 'INFORMAL_TYPE',
        'description' => 'Permissões parciais',
    ];

    const SUPPLIER = [
        'name' => 'Fornecedor',
        'code' => 'SUPPLIER',
        'description' => 'Permissões parciais',
    ];

    const NORMAL = [
        'name' => 'Normal',
        'code' => 'NORMAL',
        'description' => 'Permissões parciais',
    ];

    const ITEM = [self::ADMIN, self::FORMAL_TYPE, self::INFORMAL_TYPE, self::NORMAL, self::SUPPLIER];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::ITEM as $item) {
            $data = array_merge($item, ['uuid' => Str::uuid()->toString()]);
            UserType::updateOrCreate(['code' => $item['code'], 'name' => $item['name']], $data);
        }
    }
}
