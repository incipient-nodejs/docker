<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public const COMMENT_1 = [
        'name' => 'João Silva',
        'phone' => '912345678',
        'feedback' => 'Ótimo serviço! Recomendo.',
        'send_data' => '2024-02-21 10:30:00',
    ];

    public const COMMENT_2 = [
        'name' => 'Maria Santos',
        'phone' => '923456789',
        'feedback' => 'Atendimento rápido e eficiente.',
        'send_data' => '2024-02-20 15:45:00',
    ];

    public const COMMENT_3 = [
        'name' => 'Carlos Oliveira',
        'phone' => '934567890',
        'feedback' => 'Muito satisfeito com o suporte.',
        'send_data' => '2024-02-19 12:20:00',
    ];

    public const COMMENT_4 = [
        'name' => 'Ana Costa',
        'phone' => '945678901',
        'feedback' => 'Poderia melhorar o tempo de resposta.',
        'send_data' => '2024-02-18 09:10:00',
    ];

    public const COMMENT_5 = [
        'name' => 'Ricardo Lima',
        'phone' => '956789012',
        'feedback' => 'Serviço excelente, voltarei a usar!',
        'send_data' => '2024-02-17 14:05:00',
    ];

    public const ITEMS = [
        self::COMMENT_1,
        self::COMMENT_2,
        self::COMMENT_3,
        self::COMMENT_4,
        self::COMMENT_5,
    ];

    public function run()
    {
        foreach (self::ITEMS as $item) {
            Comment::updateOrCreate(['phone' => $item['phone']], $item);
        }
    }
}
