<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;

class ServiceSeeder extends Seeder
{
    public const CONSULTORIA_FINANCEIRA = [
        'name' => 'Consultoria Financeira Empresarial',
        'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/1f/9f/92/40/c7/v1_E10/E105KKV2.JPG?w=1600&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=f6fc6eba32f6f2d547aa536ecb1e8464a47d3e76c32b66274e6182f95f55a1ef',
        'video' => 'https://video-previews.elements.envatousercontent.com/fd5daff2-ec63-40e3-881b-df096e2a485f/watermarked_preview/watermarked_preview.mp4',
        'description' => 'Serviço especializado em consultoria financeira para empresas, incluindo análise de investimentos, planejamento tributário e gestão de custos.',
    ];

    public const DESENVOLVIMENTO_SOFTWARE = [
        'name' => 'Desenvolvimento de Software sob Demanda',
        'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/7a/e1/e1/dc/0a/v1_E10/E109OWH0.jpg?w=1600&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=dc022ff4c2ab889d3d91b149f613885b1bb3562977ca97fe79a2d8182f6f9278',
        'video' => 'https://video-previews.elements.envatousercontent.com/5b47032d-256f-43d4-a108-bd64d1d3955e/watermarked_preview/watermarked_preview.mp4',
        'description' => 'Desenvolvimento de sistemas e aplicativos personalizados, seguindo as melhores práticas de mercado e utilizando tecnologias modernas.',
    ];

    public const MARKETING_DIGITAL = [
        'name' => 'Marketing Digital Completo',
        'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/11/d8/40/0c/24/v1_E10/E109QVCB.jpg?w=1600&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=f0fa15634921e8394caf02c06154db8261238cc83f2e1f69a9a3fd88725344ad',
        'video' => 'https://video-previews.elements.envatousercontent.com/3d0b12f5-7de0-4259-a7d7-2a4b4d9b07e0/watermarked_preview/watermarked_preview.mp4',
        'description' => 'Serviços completos de marketing digital, incluindo gestão de redes sociais, SEO, campanhas pagas e produção de conteúdo.',
    ];

    public const SUPORTE_TI = [
        'name' => 'Suporte em TI 24/7',
        'image' => 'https://plus.unsplash.com/premium_photo-1661510222198-2c15ce11a644?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'video' => 'https://video-previews.elements.envatousercontent.com/files/23237a26-f65b-4c6a-ab91-aa3ccdd607bc/video_preview_h264.mp4',
        'description' => 'Suporte técnico em TI disponível 24 horas por dia, 7 dias por semana, com atendimento remoto e presencial para empresas.',
    ];

    public const TREINAMENTO_CORPORATIVO = [
        'name' => 'Treinamento Corporativo',
        'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/4b/92/23/1b/f4/v1_E10/E109283F.jpg?w=1600&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=40f2fb4ef535cc1304c6f4e338ae49d80a896c3140a46347dc2eab66a2529e42',
        'video' => 'https://video-previews.elements.envatousercontent.com/files/59d8338e-dd6f-489a-b281-b93e9565a149/video_preview_h264.mp4',
        'description' => 'Programas de treinamento personalizados para equipes corporativas, focando em desenvolvimento de habilidades técnicas e comportamentais.',
    ];

    public const ITEMS = [
        self::CONSULTORIA_FINANCEIRA,
        self::DESENVOLVIMENTO_SOFTWARE,
        self::MARKETING_DIGITAL,
        self::SUPORTE_TI,
        self::TREINAMENTO_CORPORATIVO,
    ];

    public function run()
    {
        $numbers = collect(UserSeeder::ITEM_FORMAL_TYPE, UserSeeder::ITEM_INFORMAL_TYPE)
                ->map(function($it){return $it['phone'];})
                ->all();

        $users = User::whereIn('phone', $numbers)->get();
        $categories = Category::where('type', 'service')->get();

        $tam = count($users);
        $tamCategory = count($categories);
        if($tam == 0 || $tamCategory == 0) return;

        foreach (self::ITEMS as $item) {
            $item['user_id'] = $users[rand(0, $tam - 1)]->id;
            $item['category_id'] = $categories[rand(0, $tamCategory - 1)]->id;

            $data = array_merge($item, ['uuid' => Str::uuid()->toString()]);
            $data['concat'] = $data['name'].$data['description'];
            Service::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
