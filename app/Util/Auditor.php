<?php

namespace App\Util;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class Auditor{

    static function create($data) {
        $auth = auth()->user()->id ?? null;
        $data['uuid'] = Str::uuid()->toString();
        $data['created_by'] = $auth;
        $data['updated_by'] = $auth;
        return $data;
    }

    static function update($data) {
        $data['updated_by'] = auth()->user()->id ?? null;
        return $data;
    }

    static function filter($entity = null){
        if(isset($entity)) return [
            $entity.'.deleted_by' => null, $entity.'.deleted_at' => null
        ];
        return ['deleted_by' => null,'deleted_at' => null];
    }

    static function delete() {
        return [
            'deleted_by' => auth()->user()->id ?? null,
            'deleted_at' => now(),
        ];
    }

    static function uniqueDelete($name){
        return "{$name}@del";
    }

}
