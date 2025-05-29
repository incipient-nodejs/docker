<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{
    UserType,
    User
};

class UserSeeder extends Seeder
{
    const TRISTIAN_HEATHCOTE = [
        'name' => 'Tristian Heathcote',
        'phone' => '910000000',
        'email' => 'tristian.heathcote@hotmail.com',
        'password' => '000000',
        'address' => 'Camama',
        'concat' => 'Tristian Heathcote#tristian.heathcote@hotmail.com#910000000'
    ];

    const ADELINE_GRIMES = [
        'name' => 'Adeline Grimes',
        'phone' => '920000000',
        'email' => 'adeline.grimes@hotmail.com',
        'password' => '000000',
        'address' => 'Calemba 2',
        'concat' => 'Adeline Grimes#adeline.grimes@hotmail.com#920000000'
    ];

    const BELA_MORRIS = [
        'name' => 'Bela Morris',
        'phone' => '930000000',
        'email' => 'bela.morris@hotmail.com',
        'password' => '000000',
        'address' => 'Benfica',
        'concat' => 'Bela Morris#bela.morris@hotmail.com#930000000'
    ];

    const TELMO_MORRIS = [
        'name' => 'Telmo Morris',
        'phone' => '940000000',
        'email' => 'telmo.morris@hotmail.com',
        'password' => '000000',
        'address' => 'Futungo',
        'concat' => 'Telmo Morris#telmo.morris@hotmail.com#950000000',
        'role' => 'admin',
    ];

    const MARIA_LOPEZ = [
        'name' => 'Maria Lopez',
        'phone' => '950000000',
        'email' => 'maria.lopez@hotmail.com',
        'password' => '000000',
        'address' => 'Futungo',
        'concat' => 'Maria Lopez#maria.lopez@hotmail.com#950000000'
    ];

    const JOHN_DAO = [
        'name' => 'Jhon Dao',
        'phone' => '960000000',
        'email' => 'john.dao@hotmail.com',
        'password' => '000000',
        'address' => 'Morro Bento',
        'concat' => 'Jhon Dao#john.dao@hotmail.com#960000000'
    ];

    const SUPPLIER_CIN = [
        'name' => 'Cin',
        'phone' => '911000000',
        'email' => 'cin.dao@hotmail.com',
        'password' => '000000',
        'address' => 'Benfica',
        'concat' => 'Cin#cin.dao@hotmail.com#911000000'
    ];

    const SUPPLIER_CIMANGOLA = [
        'name' => 'Cimangola',
        'phone' => '922000000',
        'email' => 'cimangola.dao@hotmail.com',
        'password' => '000000',
        'address' => 'Morro Bento',
        'concat' => 'Cimangolao#jcimangola.dao@hotmail.com#922000000'
    ];

    const SUPPLIER_KERO = [
        'name' => 'Kero',
        'phone' => '933000000',
        'email' => 'kero.dao@hotmail.com',
        'password' => '000000',
        'address' => 'Projecto Nova vida',
        'concat' => 'Kero#jkero.dao@hotmail.com#933000000'
    ];

    const SUPPLIER_CANDANDO = [
        'name' => 'Candando',
        'phone' => '944000000',
        'email' => 'candando.dao@hotmail.com',
        'password' => '000000',
        'address' => 'Projecto Nova vida',
        'concat' => 'Candando#candando.dao@hotmail.com#944000000'
    ];

    const SUPPLIER_DIOR = [
        'name' => 'Dior',
        'phone' => '955000000',
        'email' => 'kero.dao@hotmail.com',
        'password' => '000000',
        'address' => 'Projecto Nova vida',
        'concat' => 'Kero#jkero.dao@hotmail.com#955000000'
    ];

    const SUPPLIER_PRETTY = [
        'name' => 'Pretty',
        'phone' => '966000000',
        'email' => 'pretty.dao@hotmail.com',
        'password' => '000000',
        'address' => 'Projecto Nova vida',
        'concat' => 'pretty#pretty.dao@hotmail.com#966000000'
    ];

    const ITEM = [self::TRISTIAN_HEATHCOTE, self::ADELINE_GRIMES];
    const ITEM_FORMAL_TYPE = [self::BELA_MORRIS, self::TELMO_MORRIS];
    const ITEM_INFORMAL_TYPE = [self::MARIA_LOPEZ, self::JOHN_DAO];



    const SUPPLIER_MATERIAL = [
        self::SUPPLIER_CIN, self::SUPPLIER_CIMANGOLA
    ];

    const SUPPLIER_ALIMENTO = [
        self::SUPPLIER_KERO, self::SUPPLIER_CANDANDO
    ];

    const SUPPLIER_BELEZA = [
        self::SUPPLIER_DIOR, self::SUPPLIER_PRETTY
    ];



    const ITEM_SUPPLIERS = [
        ...self::SUPPLIER_MATERIAL, ...self::SUPPLIER_ALIMENTO, ...self::SUPPLIER_BELEZA
    ];

    private function createUsers($items, $userType){
        if(!isset($userType->id)) return;
        foreach ($items as $item) {
            $fields = ['uuid' => Str::uuid()->toString(), 'password' => bcrypt($item['password']), 'user_type_id' => $userType->id];
            $data = array_merge($item, $fields);
            User::updateOrCreate(['phone' => $item['phone']], $data);
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminType = UserType::where('code', 'ADMIN')->first();
        $formalType = UserType::where('code', 'FORMAL_TYPE')->first();
        $informalType = UserType::where('code', 'INFORMAL_TYPE')->first();
        $supplierType = UserType::where('code', 'SUPPLIER')->first();

        $this->createUsers(self::ITEM, $adminType);
        $this->createUsers(self::ITEM_FORMAL_TYPE, $formalType);
        $this->createUsers(self::ITEM_INFORMAL_TYPE, $informalType);
        $this->createUsers(self::ITEM_SUPPLIERS, $supplierType);
    }
}
