<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BannedTerms;

class BannedTermSeeder extends Seeder
{

    const ALL = [
        // Armas
        // ["text_en" => "Arm", "text_pt" => "Arma"],
        // ["text_en" => "Ammunition", "text_pt" => "Munição"],
        // ["text_en" => "Bomb", "text_pt" => "Bomba"],
        // ["text_en" => "Bullet", "text_pt" => "Bala"],
        // ["text_en" => "Explosive", "text_pt" => "Explosivo"],
        // ["text_en" => "Explosion", "text_pt" => "Explosão"],
        // ["text_en" => "Gun", "text_pt" => "Pistola"],
        // ["text_en" => "Knife", "text_pt" => "Faca"],
        // ["text_en" => "Rifle", "text_pt" => "Rifle"],
        // ["text_en" => "Sword", "text_pt" => "Espada"],
        // ["text_en" => "Weapon", "text_pt" => "Arma de fogo"],

        // // Nudez e Conteúdo Adulto
        // ["text_en" => "Adult content", "text_pt" => "Conteúdo adulto"],
        // ["text_en" => "Breast", "text_pt" => "Seio"],
        // ["text_en" => "Explicit", "text_pt" => "Explícito"],
        // ["text_en" => "Genitalia", "text_pt" => "Genitália"],
        // ["text_en" => "Naked", "text_pt" => "Pelado"],
        // ["text_en" => "Nude", "text_pt" => "Nu"],
        // ["text_en" => "Porn", "text_pt" => "Pornô"],
        // ["text_en" => "Pornography", "text_pt" => "Pornografia"],
        // ["text_en" => "Sex", "text_pt" => "Sexo"],
        // ["text_en" => "Topless", "text_pt" => "Sem parte de cima"],

        // // Violência
        // ["text_en" => "Blood", "text_pt" => "Sangue"],
        // ["text_en" => "Gore", "text_pt" => "Sangue extremo"],
        // ["text_en" => "Kill", "text_pt" => "Matar"],
        // ["text_en" => "Murder", "text_pt" => "Assassinato"],
        // ["text_en" => "Torture", "text_pt" => "Tortura"],
        // ["text_en" => "Violence", "text_pt" => "Violência"],

        // // Drogas
        // ["text_en" => "Cocaine", "text_pt" => "Cocaína"],
        // ["text_en" => "Drug", "text_pt" => "Droga"],
        // ["text_en" => "Drugs", "text_pt" => "Drogas"],
        // ["text_en" => "Heroin", "text_pt" => "Heroína"],
        // ["text_en" => "Marijuana", "text_pt" => "Maconha"],
        // ["text_en" => "Narcotics", "text_pt" => "Narcóticos"],

        // // Discurso de Ódio
        // ["text_en" => "Discrimination", "text_pt" => "Discriminação"],
        // ["text_en" => "Hate", "text_pt" => "Ódio"],
        // ["text_en" => "Hate speech", "text_pt" => "Discurso de ódio"],
        // ["text_en" => "Homophobia", "text_pt" => "Homofobia"],
        // ["text_en" => "Nazi", "text_pt" => "Nazista"],
        // ["text_en" => "Racism", "text_pt" => "Racismo"],
        // ["text_en" => "Racist", "text_pt" => "Racista"],
        // ["text_en" => "Sexism", "text_pt" => "Sexismo"],

        // // Abuso e Problemas de Saúde Mental
        // ["text_en" => "Child abuse", "text_pt" => "Abuso infantil"],
        // ["text_en" => "Molestation", "text_pt" => "Moléstia"],
        // ["text_en" => "Self-harm", "text_pt" => "Autolesão"],
        // ["text_en" => "Suicide", "text_pt" => "Suicídio"],

        // // Outros Conteúdos Sensíveis
        // ["text_en" => "Animal cruelty", "text_pt" => "Crueldade animal"],
        // ["text_en" => "Terrorism", "text_pt" => "Terrorismo"],

        // Drogas e Substâncias Controladas
            ["text_en" => "Marijuana", "text_pt" => "maconha"],
            ["text_en" => "Cannabis", "text_pt" => "cannabis"],
            ["text_en" => "Hashish", "text_pt" => "haxixe"],
            ["text_en" => "LSD", "text_pt" => "LSD"],
            ["text_en" => "MDMA", "text_pt" => "MDMA"],
            ["text_en" => "Ecstasy", "text_pt" => "ecstasy"],
            ["text_en" => "Ayahuasca", "text_pt" => "ayahuasca"],
            ["text_en" => "Heroin", "text_pt" => "heroína"],
            ["text_en" => "Methamphetamine", "text_pt" => "metanfetamina"],
            ["text_en" => "Ketamine", "text_pt" => "ketamina"],
            ["text_en" => "Acid", "text_pt" => "ácido"],
            ["text_en" => "DMT", "text_pt" => "dmt"],
            ["text_en" => "Drug", "text_pt" => "droga"],
            ["text_en" => "Narcotic", "text_pt" => "entorpecente"],
            ["text_en" => "Narcotic", "text_pt" => "narcótico"],

            // Álcool e Bebidas Proibidas
            ["text_en" => "Beer", "text_pt" => "cerveja"],
            ["text_en" => "Wine", "text_pt" => "vinho"],
            ["text_en" => "Whiskey", "text_pt" => "whisky"],
            ["text_en" => "Vodka", "text_pt" => "vodka"],
            ["text_en" => "Gin", "text_pt" => "gin"],
            ["text_en" => "Tequila", "text_pt" => "tequila"],
            ["text_en" => "Cachaça", "text_pt" => "cachaça"],
            ["text_en" => "Absinthe", "text_pt" => "absinto"],
            ["text_en" => "Rum", "text_pt" => "rum"],
            ["text_en" => "Brandy", "text_pt" => "aguardente"],
            ["text_en" => "Ethyl Alcohol", "text_pt" => "álcool etílico"],

        // Armas e Munições

            ["text_en" => "Pistol", "text_pt" => "pistola"],
            ["text_en" => "Revolver", "text_pt" => "revólver"],
            ["text_en" => "Shotgun", "text_pt" => "espingarda"],
            ["text_en" => "Rifle", "text_pt" => "rifle"],
            ["text_en" => "Assault Rifle", "text_pt" => "fuzil"],
            ["text_en" => "Ammunition", "text_pt" => "munição"],
            ["text_en" => "Bullet", "text_pt" => "bala"],
            ["text_en" => "Cartridge", "text_pt" => "cartucho"],
            ["text_en" => "Melee Weapon", "text_pt" => "arma branca"],
            ["text_en" => "Firearm", "text_pt" => "arma de fogo"],
            ["text_en" => "Explosive", "text_pt" => "explosivo"],
            ["text_en" => "Grenade", "text_pt" => "granada"],
            ["text_en" => "Silencer", "text_pt" => "silenciador"],

        // Objectos Perigosos ou Cortantes
            ["text_en" => "Knife", "text_pt" => "faca"],
            ["text_en" => "Pocket Knife", "text_pt" => "canivete"],
            ["text_en" => "Dagger", "text_pt" => "punhal"],
            ["text_en" => "Sword", "text_pt" => "espada"],
            ["text_en" => "Box Cutter", "text_pt" => "estilete"],
            ["text_en" => "Razor", "text_pt" => "navalha"],
            ["text_en" => "Adaga", "text_pt" => "adaga"],  // "Adaga" = "Dagger" (already translated; optionally repeat or reword)
            ["text_en" => "Retractable Baton", "text_pt" => "bastão retrátil"],

        // Conteúdo Ilegal, Imitativo ou Antiético
            ["text_en" => "Pornography", "text_pt" => "pornografia"],
            ["text_en" => "Porn", "text_pt" => "pornô"],
            ["text_en" => "Pedophilia", "text_pt" => "pedofilia"],
            ["text_en" => "Zoophilia", "text_pt" => "zoofilia"],
            ["text_en" => "Sex Shop", "text_pt" => "sex shop"],
            ["text_en" => "Nudity", "text_pt" => "nudez"],
            ["text_en" => "Escort", "text_pt" => "escort"],
            ["text_en" => "Companion", "text_pt" => "acompanhante"],
            ["text_en" => "Counterfeit", "text_pt" => "falsificado"],
            ["text_en" => "Replica", "text_pt" => "réplica"],
            ["text_en" => "Pirated", "text_pt" => "pirata"],
            ["text_en" => "Hack", "text_pt" => "hack"],
            ["text_en" => "Cheat", "text_pt" => "cheat"],

        // Produtos Roubados ou de Procedência Duvidosa
            ["text_en" => "Smuggling", "text_pt" => "contrabando"],
            ["text_en" => "Customs Evasion", "text_pt" => "descaminho"],
            ["text_en" => "Stolen Product", "text_pt" => "produto roubado"],
            ["text_en" => "Stolen Item", "text_pt" => "produto furtado"],
            ["text_en" => "Receiving Stolen Goods", "text_pt" => "receptação"],
            ["text_en" => "No Invoice", "text_pt" => "sem nota"],
            ["text_en" => "Factory Sealed", "text_pt" => "original lacrado"],

        // Substâncias Tóxicas ou Restritas
            ["text_en" => "Poison", "text_pt" => "veneno"],
            ["text_en" => "Cyanide", "text_pt" => "cianeto"],
            ["text_en" => "Arsenic", "text_pt" => "arsênico"],
            ["text_en" => "Mercury", "text_pt" => "mercúrio"],
            ["text_en" => "Lead", "text_pt" => "chumbo"],
            ["text_en" => "Muriatic Acid", "text_pt" => "ácido muriático"],
            ["text_en" => "Caustic Soda", "text_pt" => "soda cáustica"],
            ["text_en" => "Pesticide", "text_pt" => "pesticida"],
            ["text_en" => "Agrotoxic", "text_pt" => "agrotóxico"],
        // Produtos Médicos Restritos
            ["text_en" => "Anabolic", "text_pt" => "anabolizante"],
            ["text_en" => "Steroid", "text_pt" => "esteroide"],
            ["text_en" => "Hormone", "text_pt" => "hormônio"],
            ["text_en" => "Controlled Injection", "text_pt" => "injeção controlada"],
            ["text_en" => "Black Label Medication", "text_pt" => "medicamento tarja preta"],
            ["text_en" => "Ritalin", "text_pt" => "ritalina"],
            ["text_en" => "Sibutramine", "text_pt" => "sibutramina"],
            ["text_en" => "Clonazepam", "text_pt" => "clonazepam"],
            ["text_en" => "Diazepam", "text_pt" => "diazepam"],
        // Explosivos e Fogos
            ["text_en" => "Bomb", "text_pt" => "bomba"],
            ["text_en" => "Firecracker", "text_pt" => "rojão"],
            ["text_en" => "Dynamite", "text_pt" => "dinamite"],
            ["text_en" => "Gunpowder", "text_pt" => "pólvora"],
            ["text_en" => "Fireworks", "text_pt" => "fogos de artifício"],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::ALL as $item) {
            BannedTerms::updateOrCreate(['text_en' => $item['text_en'],],
                array_merge($item, ['concat' => $item['text_en'] .','. ($item['text_pt'] ?? '') ])
            );
        }
    }
}
