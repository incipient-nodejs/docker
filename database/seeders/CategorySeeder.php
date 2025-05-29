<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public const CATEGORIES = [
        // Produtos
        ['name' => 'Alimentos', 'code' => 'ALIMENTOS', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740744523_CategoriasAliementos.png', 'type' => 'product'],
        ['name' => 'Bebidas', 'code' => 'BEBIDAS', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740652464_CategoriasBebida.png', 'type' => 'product'],
        ['name' => 'Moda', 'code' => 'MODA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741622138_WhatsApp Image 2025-03-10 at 13.11.26 (4).jpeg', 'type' => 'product'],
        ['name' => 'Calçados', 'code' => 'CALCADOS', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741613135_WhatsApp Image 2025-03-10 at 13.11.25 (1).jpeg', 'type' => 'product'],
        ['name' => 'Beleza', 'code' => 'BELEZA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740655481_LOGO-BOOSTERProdutos-de-beleza.png', 'type' => 'product'],
        ['name' => 'Saúde', 'code' => 'SAUDE', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740655371_LOGO-BOOSTERSaude.png', 'type' => 'product'],
        ['name' => 'Casa', 'code' => 'CASA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741621835_WhatsApp Image 2025-03-10 at 13.11.26.jpeg', 'type' => 'product'],
        ['name' => 'Bebês', 'code' => 'BEBES', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740652801_Categoriasbebs.png', 'type' => 'product'],
        ['name' => 'Esporte', 'code' => 'ESPORTE', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740652810_CategoriasDesporto.png', 'type' => 'product'],
        ['name' => 'Livros', 'code' => 'LIVROS', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741621765_WhatsApp Image 2025-03-10 at 13.11.26 (3).jpeg', 'type' => 'product'],
        ['name' => 'Tecnologia', 'code' => 'TECNOLOGIA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740654009_CategoriasTecnologia.png', 'type' => 'product'],
        ['name' => 'Automóveis', 'code' => 'AUTOMOVEIS', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741621634_ActualizadasAutomovéis.png', 'type' => 'product'],
        ['name' => 'Ferramentas', 'code' => 'FERRAMENTAS', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741621939_CategoriasFerramentas.png', 'type' => 'product'],

        // Serviços
        ['name' => 'Reparos', 'code' => 'REPAROS', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741621911_CategoriasReparos.png', 'type' => 'service'],
        ['name' => 'Limpeza', 'code' => 'LIMPEZA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741621723_WhatsApp Image 2025-03-10 at 13.11.26 (2).jpeg', 'type' => 'service'],
        ['name' => 'Beleza', 'code' => 'SERVICO_BELEZA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740655481_LOGO-BOOSTERProdutos-de-beleza.png', 'type' => 'service'],
        ['name' => 'Cursos', 'code' => 'CURSOS', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740654033_CategoriasCursos.png', 'type' => 'service'],
        ['name' => 'Saúde', 'code' => 'SERVICO_SAUDE', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741621789_WhatsApp Image 2025-03-10 at 13.11.26 (5).jpeg', 'type' => 'service'],
        ['name' => 'Eventos', 'code' => 'EVENTOS', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740654056_CategoriasEventos.png', 'type' => 'service'],
        ['name' => 'Consultas', 'code' => 'CONSULTAS', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740744702_CategoriasCONSULTAS.png', 'type' => 'service'],
        ['name' => 'Transportes', 'code' => 'TRANSPORTES', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740744724_CategoriasTRANSPORTE.png', 'type' => 'service'],
        ['name' => 'Design', 'code' => 'DESIGN', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740654095_CategoriasDesign.png', 'type' => 'service'],
        ['name' => 'Tecnologia', 'code' => 'SERVICO_TECNOLOGIA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741621814_WhatsApp Image 2025-03-10 at 13.11.26 (7).jpeg', 'type' => 'service'],
        ['name' => 'Direito', 'code' => 'DIREITO', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740654116_CategoriasDireito.png', 'type' => 'service'],
        ['name' => 'Contabilidade', 'code' => 'CONTABILIDADE', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740654132_CategoriasContabilidade.png', 'type' => 'service'],
        ['name' => 'Consultoria', 'code' => 'CONSULTORIA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740744766_CategoriasCONSULTORIA.png', 'type' => 'service'],
        ['name' => 'Arquitetura', 'code' => 'ARQUITETURA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1741622064_CategoriasArquitetura.png', 'type' => 'service'],
        ['name' => 'Tradução', 'code' => 'TRADUCAO', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740654166_CategoriasTradução.png', 'type' => 'service'],
        ['name' => 'Psicologia', 'code' => 'PSICOLOGIA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740654181_CategoriasPsycology.png', 'type' => 'service'],
        ['name' => 'Educação', 'code' => 'EDUCACAO', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740654198_CategoriasEducação.png', 'type' => 'service'],


        // Fornecedores
        ['name' => 'Materias de construção', 'code' => 'MATERIAL_CONSTRUCAO', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740655464_LOGO-BOOSTERReparos.png', 'type' => 'supplier'],
        ['name' => 'Produtos alimentares', 'code' => 'PRODUTO_ALIMENTAR', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740655823_CategoriasLimpeza.png', 'type' => 'supplier'],
        ['name' => 'Produtos de beleza e cosmeticos', 'code' => 'PRODUTO_BELEZA', 'icon' => 'https://tudokabir.bitkabir.com/categories/1740655481_LOGO-BOOSTERProdutos-de-beleza.png', 'type' => 'supplier'],

    ];

    public function run()
    {
        foreach (self::CATEGORIES as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],  array_merge($category, ['uuid' => Str::uuid()->toString()])
            );
        }
    }
}
