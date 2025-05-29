<?php

namespace App\Permission;

class UserTypePerm
{
    public const USER_TYPE_CREATE = [
        'code' => 'USER_TYPE_CREATE',
        'name' => 'Criar Tipo de Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para criar um novo tipo de usuário.',
    ];

    public const USER_TYPE_VIEW = [
        'code' => 'USER_TYPE_VIEW',
        'name' => 'Visualizar Tipos de Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para visualizar os tipos de usuário.',
    ];

    public const USER_TYPE_UPDATE = [
        'code' => 'USER_TYPE_UPDATE',
        'name' => 'Atualizar Tipo de Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para atualizar tipos de usuário existentes.',
    ];

    public const USER_TYPE_DELETE = [
        'code' => 'USER_TYPE_DELETE',
        'name' => 'Excluir Tipo de Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para excluir tipos de usuário.',
    ];

    public const USER_TYPE_DESTROY = [
        'code' => 'USER_TYPE_DESTROY',
        'name' => 'Destruir Tipo de Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para destruir tipos de usuário.',
    ];

    public const USER_TYPE_RECICLE_VIEW = [
        'code' => 'USER_TYPE_RECICLE_VIEW',
        'name' => 'Visualizar Tipos de Usuário Reciclados',
        'type' => 'PROTECTED',
        'description' => 'Permissão para visualizar tipos de usuário na lixeira.',
    ];

    public const USER_TYPE_RECOVER_ITEM = [
        'code' => 'USER_TYPE_RECOVER_ITEM',
        'name' => 'Recuperar Tipo de Usuário',
        'type' => 'PROTECTED',
        'description' => 'Permissão para recuperar tipos de usuário da lixeira.',
    ];

    public static function all(): array
    {
        return [
            self::USER_TYPE_CREATE,
            self::USER_TYPE_VIEW,
            self::USER_TYPE_UPDATE,
            self::USER_TYPE_DELETE,
            self::USER_TYPE_DESTROY,
            self::USER_TYPE_RECICLE_VIEW,
            self::USER_TYPE_RECOVER_ITEM,
        ];
    }
}
