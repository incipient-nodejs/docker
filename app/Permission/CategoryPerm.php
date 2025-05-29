<?php

namespace App\Permission;

class CategoryPerm
{
    public const CATEGORY_CREATE = [
        'code' => 'CATEGORY_CREATE',
        'name' => 'Criar categoria',
        'type' => 'PROTECTED',
        'description' => 'Permissão para criar categorias.',
    ];

    public const CATEGORY_VIEW = [
        'code' => 'CATEGORY_VIEW',
        'name' => 'Visualizar categoria',
        'type' => 'PROTECTED',
        'description' => 'Permissão para visualizar categorias.',
    ];

    public const CATEGORY_UPDATE = [
        'code' => 'CATEGORY_UPDATE',
        'name' => 'Atualizar categoria',
        'type' => 'PROTECTED',
        'description' => 'Permissão para atualizar categorias.',
    ];

    public const CATEGORY_DELETE = [
        'code' => 'CATEGORY_DELETE',
        'name' => 'Excluir categoria',
        'type' => 'PROTECTED',
        'description' => 'Permissão para excluir categorias.',
    ];

    public const CATEGORY_DESTROY = [
        'code' => 'CATEGORY_DESTROY',
        'name' => 'Destruir categoria',
        'type' => 'PROTECTED',
        'description' => 'Permissão para destruir categorias.',
    ];

    public const CATEGORY_RECICLE_VIEW = [
        'code' => 'CATEGORY_RECICLE_VIEW',
        'name' => 'Visualizar categorias recicladas',
        'type' => 'PROTECTED',
        'description' => 'Permissão para visualizar categorias recicladas.',
    ];

    public const CATEGORY_RECOVER_ITEM = [
        'code' => 'CATEGORY_RECOVER_ITEM',
        'name' => 'Recuperar categoria reciclada',
        'type' => 'PROTECTED',
        'description' => 'Permissão para recuperar categoria.',
    ];

    public static function all(): array
    {
        return [
            self::CATEGORY_CREATE,
            self::CATEGORY_VIEW,
            self::CATEGORY_UPDATE,
            self::CATEGORY_DELETE,
            self::CATEGORY_DESTROY,
            self::CATEGORY_RECICLE_VIEW,
            self::CATEGORY_RECOVER_ITEM,
        ];
    }
}
