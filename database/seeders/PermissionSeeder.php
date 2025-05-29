<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Permission;
use App\Permission\{
    CategoryPerm,
    PermissionPerm,
    UserPerm,
    UserTypePerm
};

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = array_merge(
            CategoryPerm::all(),  PermissionPerm::all(),
            UserPerm::all(),
            UserTypePerm::all()
        );

        foreach ($items as $item) {
            $data = array_merge($item, ['uuid' => Str::uuid()->toString()]);
            Permission::updateOrCreate(['code' => $item['code'], 'name' => $item['name']], $data);
        }
    }
}
