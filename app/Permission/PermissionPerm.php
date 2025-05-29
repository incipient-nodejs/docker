<?php

namespace App\Permission;

class PermissionPerm
{
    public const PERMISSION_CREATE = [
        'code' => 'PERMISSION_CREATE',
        'name' => 'Criar Permissão',
        'type' => 'PROTECTED',
        'description' => 'Permissão para criar permissões.',
    ];

    public const PERMISSION_VIEW = [
        'code' => 'PERMISSION_VIEW',
        'name' => 'Visualizar Permissão',
        'type' => 'PROTECTED',
        'description' => 'Permissão para visualizar permissões.',
    ];

    public const PERMISSION_UPDATE = [
        'code' => 'PERMISSION_UPDATE',
        'name' => 'Atualizar Permissão',
        'type' => 'PROTECTED',
        'description' => 'Permissão para atualizar permissões.',
    ];

    public const PERMISSION_DELETE = [
        'code' => 'PERMISSION_DELETE',
        'name' => 'Excluir Permissão',
        'type' => 'PROTECTED',
        'description' => 'Permissão para excluir permissões.',
    ];

    public const PERMISSION_DESTROY = [
        'code' => 'PERMISSION_DESTROY',
        'name' => 'Destruir Permissão',
        'type' => 'PROTECTED',
        'description' => 'Permissão para destruir permissões.',
    ];

    public const PERMISSION_RECICLE_VIEW = [
        'code' => 'PERMISSION_RECICLE_VIEW',
        'name' => 'Visualizar permissões reciclados',
        'type' => 'PROTECTED',
        'description' => 'Permissão para visualizar permissões reciclados.',
    ];

    public const PERMISSION_RECOVER_ITEM = [
        'code' => 'PERMISSION_RECOVER_ITEM',
        'name' => 'Recuperar permissão reciclado',
        'type' => 'PROTECTED',
        'description' => 'Permissão para recuperar permissão.',
    ];

    public static function all(): array
    {
        return [
            self::PERMISSION_CREATE,
            self::PERMISSION_VIEW,
            self::PERMISSION_UPDATE,
            self::PERMISSION_DELETE,
            self::PERMISSION_DESTROY,
            self::PERMISSION_RECICLE_VIEW,
            self::PERMISSION_RECOVER_ITEM,
        ];
    }
}
