<?php

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use Database\Seeders\UserTypeSeeder;
use App\Models\UserType;
use App\Models\Log;
use App\Util\Auditor;
use App\Interfaces\ICrud;
class UserTypeService implements ICrud
{

    /** @override */
    public function findAll()
    {
        try {
            $userTypes = UserType::where(Auditor::filter())->get();
            return $userTypes;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function paginate()
    {
        try {
            $paginatedUserTypes = UserType::where(Auditor::filter())->paginate();
            return $paginatedUserTypes;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function create(array $data)
    {
        try {
            if (!isset($data['code'])) {
                $data['code'] = strtoupper($data['name']);
            }
            $data['concat'] = $data['name'] . $data['code'];
            if (isset($data['description'])) {
                $data['concat'] .= $data['description'];
            }

            $userType = UserType::create(Auditor::create($data));
            return $userType;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id)
    {
        try {
            $userType = $this->findByUuid($id);
            $data['concat'] = $data['name'] . $data['code'];
            if (isset($data['description'])) {
                $data['concat'] .= $data['description'];
            }
            $userType->update(Auditor::update($data));
            return $userType;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function delete(string $id): void
    {
        try {
            $userType = $this->findByUuid($id);
            $userType->update(array_merge(Auditor::delete(), [
                'name' => Auditor::uniqueDelete($userType->name)
            ]));
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function findByIdOrUuid(string $uuid): UserType
    {
        try {
            $userType = UserType::where(array_merge(['uuid' => $uuid], Auditor::filter()))
                                ->orWhere('id', $idOrUuid)
                                ->firstOrFail();
            return $userType;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function findUserTypeDefaultOrCreate()
    {
        return $this->findOrCreate(UserTypeSeeder::NORMAL);
    }

    public function findUserTypeFormalOrCreate()
    {
        return $this->findOrCreate(UserTypeSeeder::FORMAL_TYPE);
    }

    public function findUserTypeInformalOrCreate()
    {
        return $this->findOrCreate(UserTypeSeeder::INFORMAL_TYPE);
    }

    private function findOrCreate($data)
    {
        try {
            $userType = UserType::where(array_merge(['name' => $data['name']], Auditor::filter()))->first();
            if (isset($userType->id))  return $userType;
            return $this->create($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
