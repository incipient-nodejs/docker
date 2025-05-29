<?php

namespace App\Permission;

class UserPerm
{
    public const USER_CREATE = [
        'code' => 'USER_CREATE',
        'name' => 'Criar Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para criar usuários.',
    ];

    public const USER_VIEW = [
        'code' => 'USER_VIEW',
        'name' => 'Visualizar Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para visualizar usuários.',
    ];

    public const USER_VIEW_SUSPEND = [
        'code' => 'USER_VIEW_SUSPEND',
        'name' => 'Visualizar Usuário com conta suspensa',
        'type' => 'PROTECTED',
        'description' => 'Permissão para visualizar usuários com conta suspensa.',
    ];

    public const USER_UPDATE = [
        'code' => 'USER_UPDATE',
        'name' => 'Atualizar Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para atualizar usuários.',
    ];

    public const USER_DELETE = [
        'code' => 'USER_DELETE',
        'name' => 'Excluir Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para excluir usuários.',
    ];

    public const USER_DESTROY = [
        'code' => 'USER_DESTROY',
        'name' => 'Destruir Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para destruir usuários.',
    ];

    public const USER_RECICLE_VIEW = [
        'code' => 'USER_RECICLE_VIEW',
        'name' => 'Visualizar usuários reciclados',
        'type' => 'PROTECTED',
        'description' => 'Permissão para visualizar usuários reciclados.',
    ];

    public const USER_RECOVER_ITEM = [
        'code' => 'USER_RECOVER_ITEM',
        'name' => 'Recuperar usuário reciclado',
        'type' => 'PROTECTED',
        'description' => 'Permissão para recuperar usuário.',
    ];

    public static function all(): array
    {
        return [
            self::USER_CREATE,
            self::USER_VIEW,
            self::USER_VIEW_SUSPEND,
            self::USER_UPDATE,
            self::USER_DELETE,
            self::USER_DESTROY,
            self::USER_RECICLE_VIEW,
            self::USER_RECOVER_ITEM,
        ];
    }
}
