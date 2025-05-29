<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\InformalType;
use App\Models\User;

class InformalTypeSeeder extends Seeder
{
    public const EMPRESA_CONSULTORIA = [
        'name' => 'Consultoria Empresarial XYZ',
        'nif' => '12345678901',
        'docs' => 'contrato_consultoria.pdf',
        'website' => 'www.consultoriaxyz.com.br',
        'whatsapp' => '+55 11 99999-8888',
        'phone' => '+55 11 3333-4444',
        'offers' => 'Consultoria empresarial, planejamento estratégico, gestão de projetos',
    ];

    public const EMPRESA_TECNOLOGIA = [
        'name' => 'TechSolutions Brasil',
        'nif' => '98765432101',
        'docs' => 'documentacao_tech.pdf',
        'website' => 'www.techsolutions.com.br',
        'whatsapp' => '+55 11 97777-6666',
        'phone' => '+55 11 2222-3333',
        'offers' => 'Desenvolvimento de software, suporte técnico, infraestrutura em nuvem',
    ];

    public const EMPRESA_MARKETING = [
        'name' => 'Marketing Digital Pro',
        'nif' => '45678912301',
        'docs' => 'termos_servico.pdf',
        'website' => 'www.marketingpro.com.br',
        'whatsapp' => '+55 11 96666-5555',
        'phone' => '+55 11 4444-5555',
        'offers' => 'Marketing digital, gestão de redes sociais, campanhas publicitárias',
    ];

    public const ITEMS = [
        self::EMPRESA_CONSULTORIA,
        self::EMPRESA_TECNOLOGIA,
        self::EMPRESA_MARKETING,
    ];

    public function run()
    {
        $numbers = collect(UserSeeder::ITEM_INFORMAL_TYPE)->map(function($it){return $it['phone'];})->all();
        $userInformals = User::whereIn('phone', $numbers)->get();
        $tam = count($userInformals);

        if($tam == 0) return;
        $items = self::ITEMS;

        if($tam < count($items)) $items = array_slice($items, 0, $tam);

        foreach ($items as $index => $item) {
            $item['user_id'] = $userInformals[$index]->id;
            $data = array_merge($item, ['uuid' => Str::uuid()->toString()]);
            InformalType::updateOrCreate(['nif' => $item['nif']], $data);
        }
    }
}
