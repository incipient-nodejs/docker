<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public const BANNERS = [
        ['posicao_tela' => 'tudo', 'posicao_grupo' => 1, 'posicao_interna' => 1, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1741615015_tudo_1_1'],
        ['posicao_tela' => 'tudo', 'posicao_grupo' => 1, 'posicao_interna' => 2, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1740657905_22741443_570_back_to_school_social_media_post.jpg'],

        ['posicao_tela' => 'produtos', 'posicao_grupo' => 2, 'posicao_interna' => 1, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1741615290_produtos_1_1'],
        ['posicao_tela' => 'produtos', 'posicao_grupo' => 2, 'posicao_interna' => 2, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1741356523_produtos_2_1'],
        ['posicao_tela' => 'produtos', 'posicao_grupo' => 2, 'posicao_interna' => 3, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1741615069_produtos_2_2'],
        ['posicao_tela' => 'produtos', 'posicao_grupo' => 2, 'posicao_interna' => 4, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1741615122_produtos_2_3'],

        ['posicao_tela' => 'servicos', 'posicao_grupo' => 3, 'posicao_interna' => 1, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1740657905_22741443_570_back_to_school_social_media_post.jpg'],
        ['posicao_tela' => 'servicos', 'posicao_grupo' => 3, 'posicao_interna' => 2, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1740659517_9083602_67.jpg'],
        ['posicao_tela' => 'servicos', 'posicao_grupo' => 3, 'posicao_interna' => 3, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1740658263_22741443_570_back_to_school_social_media_post.jpg'],

        ['posicao_tela' => 'fabricantes', 'posicao_grupo' => 4, 'posicao_interna' => 1, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1740657905_22741443_570_back_to_school_social_media_post.jpg'],
        ['posicao_tela' => 'fabricantes', 'posicao_grupo' => 4, 'posicao_interna' => 2, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1740658263_22741443_570_back_to_school_social_media_post.jpg'],
        ['posicao_tela' => 'fabricantes', 'posicao_grupo' => 4, 'posicao_interna' => 3, 'imagem' => 'https://tudokabir.bitkabir.com/banners/1740634435_WhatsApp Image 2025-02-22 at 12.22.29.jpeg'],
      ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::BANNERS as $banner) {
            Banner::updateOrCreate(
                ['imagem' => $banner['imagem'], 'posicao_grupo'  => $banner['posicao_grupo']],
                array_merge($banner, ['uuid' => Str::uuid()->toString()])
            );
        }
    }
}
