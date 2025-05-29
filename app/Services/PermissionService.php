<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\Permission;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;

class PermissionService
{
    public function findAll(): Collection
    {
        $permissions = Permission::where(Auditor::filter())->get();

        Log::create([
            'source' => 'laravel',
            'event_type' => 'fetch_all',
            'message' => "Listagem de todas as permissões solicitada.",
            'ip_address' => request()->ip()
        ]);

        return $permissions;
    }

    public function paginate(): LengthAwarePaginator
    {
        $paginatedData = Permission::where(Auditor::filter())->paginate();

        Log::create([
            'source' => 'laravel',
            'event_type' => 'paginate',
            'message' => "Paginação de permissões realizada.",
            'ip_address' => request()->ip()
        ]);

        return $paginatedData;
    }

    public function findById(int $id): Permission
    {
        try {
            $permission = Permission::where(Auditor::filter())->findOrFail($id);

            Log::create([
                'source' => 'laravel',
                'event_type' => 'fetch_by_id',
                'message' => "Permissão encontrada com ID: {$id}.",
                'ip_address' => request()->ip()
            ]);

            return $permission;
        } catch (ModelNotFoundException $e) {
            Log::create([
                'source' => 'laravel',
                'event_type' => 'fetch_by_id_failed',
                'message' => "Erro ao buscar permissão com ID: {$id}.",
                'ip_address' => request()->ip()
            ]);

            throw $e;
        }
    }

    public function create(array $data): Permission
    {
        try {
            $data['concat'] = $data['name'] . ($data['description'] ?? '');
            $permission = Permission::create(Auditor::create($data));

            Log::create([
                'source' => 'laravel',
                'event_type' => 'create',
                'message' => "Nova permissão criada: {$data['name']}.",
                'ip_address' => request()->ip()
            ]);

            return $permission;
        } catch (\Exception $e) {
            Log::create([
                'source' => 'laravel',
                'event_type' => 'create_failed',
                'message' => "Erro ao criar permissão: " . $e->getMessage(),
                'ip_address' => request()->ip()
            ]);

            throw $e;
        }
    }

    public function update(int $id, array $data): Permission
    {
        try {
            $permission = $this->findById($id);
            $data['concat'] = $data['name'] . ($data['description'] ?? '');
            $permission->update(Auditor::update($data));

            Log::create([
                'source' => 'laravel',
                'event_type' => 'update',
                'message' => "Permissão ID {$permission->id} atualizada.",
                'ip_address' => request()->ip()
            ]);

            return $permission;
        } catch (\Exception $e) {
            Log::create([
                'source' => 'laravel',
                'event_type' => 'update_failed',
                'message' => "Erro ao atualizar permissão ID {$id}: " . $e->getMessage(),
                'ip_address' => request()->ip()
            ]);

            throw $e;
        }
    }

    public function delete(int $id): void
    {
        try {
            $permission = $this->findById($id);
            $permission->update(Auditor::delete());

            Log::create([
                'source' => 'laravel',
                'event_type' => 'delete',
                'message' => "Permissão ID {$permission->id} foi excluída.",
                'ip_address' => request()->ip()
            ]);
        } catch (\Exception $e) {
            Log::create([
                'source' => 'laravel',
                'event_type' => 'delete_failed',
                'message' => "Erro ao excluir permissão ID {$id}: " . $e->getMessage(),
                'ip_address' => request()->ip()
            ]);

            throw $e;
        }
    }
}
