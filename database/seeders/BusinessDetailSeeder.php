<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\BusinessDetail;
use App\Models\User;

class BusinessDetailSeeder extends Seeder
{
    public const BUSINESS_1 = [
        'category' => 'General',
        'phone_preference' => 'mobile',
        'phone' => '912345678',
        'whatsapp' => '912345678',
        'email' => 'contact@techsolutions.com',
        'website_url' => 'https://techsolutions.com',
        'is_sell_product' => true,
    ];

    public const BUSINESS_2 = [
        'category' => 'General',
        'phone_preference' => 'mobile',
        'phone' => '923456789',
        'whatsapp' => '923456789',
        'email' => 'info@creativedesigns.com',
        'website_url' => 'https://creativedesigns.com',
        'is_sell_product' => false,
    ];

    public const BUSINESS_3 = [
        'category' => 'General',
        'phone_preference' => 'landline',
        'phone' => '934567890',
        'whatsapp' => '934567890',
        'email' => 'support@smartdevices.com',
        'website_url' => 'https://smartdevices.com',
        'is_sell_product' => true,
    ];

    public const BUSINESS_4 = [
        'category' => 'General',
        'phone_preference' => 'mobile',
        'phone' => '945678901',
        'whatsapp' => '945678901',
        'email' => 'info@healthcare.com',
        'website_url' => 'https://healthcare.com',
        'is_sell_product' => false,
    ];

    public const BUSINESS_5 = [
        'category' => 'General',
        'phone_preference' => 'mobile',
        'phone' => '956789012',
        'whatsapp' => '956789012',
        'email' => 'sales@ecofriendly.com',
        'website_url' => 'https://ecofriendly.com',
        'is_sell_product' => true,
    ];

    public const ITEMS = [
        self::BUSINESS_1,
        self::BUSINESS_2,
        self::BUSINESS_3,
        self::BUSINESS_4,
        self::BUSINESS_5,
    ];

    public function run()
    {
        $phones = collect(UserSeeder::ITEM_FORMAL_TYPE, UserSeeder::ITEM_INFORMAL_TYPE)
            ->map(function ($it) {
                return $it['phone'];
            })
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
            $data = array_merge($item, [
                'uuid' => Str::uuid()->toString(),
                'user_id' => $user->id,
            ]);

            BusinessDetail::updateOrCreate(['user_id' => $data['user_id']], $data);
            $counter++;
        }
    }
}
