<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\PersonalData;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Interfaces\ICrud;

class PersonalDataService implements ICrud
{
    private $userService;

    function __construct(){
        $this->userService = new UserService();
    }

    /** @override */
    public function findAll()
    {
        $personalData = PersonalData::with('user')->where(Auditor::filter())->orderBy('id','DESC')->get();
        return $personalData;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = PersonalData::with('user')->where(Auditor::filter())->orderBy('id','DESC')->paginate();
        return $paginatedData;
    }

    /** @override */
    public function create(array $data): PersonalData
    {
        try {
            $user = $this->userService->findByUuid($data['user_id']);
            $data = $this->requestData($user, $data);
            $personalData = PersonalData::create(Auditor::create($data));
            return $personalData;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id)
    {
        return $this->updateWithModel($data, $this->findByUuid($id));
    }

    /** @override */
    public function delete(string $id)
    {
        try {
            $personalData = $this->findByIdOrUuid($id);
            $personalData->update(array_merge(Auditor::delete()));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findByUuid(string $uuid): PersonalData
    {
        $personalData = PersonalData::where(array_merge(['uuid' => $uuid], Auditor::filter()))->firstOrFail();
        return $personalData;
    }

    public function findByIdOrUuid(string $idOrUuid): PersonalData
    {
        try {
            $query = PersonalData::where(function ($query) use ($idOrUuid) {
                $query->where('uuid', $idOrUuid)->where(Auditor::filter());
            });

            if (is_numeric($idOrUuid)) {
                $query->orWhere('id', $idOrUuid);
            }

            $personalData = $query->firstOrFail();
            return $personalData;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function updateWithModel(array $data, $personalData): PersonalData
    {
        try {
            $user = $personalData->user;
            if (isset($data['user_id'])) $user = $this->userService->findByIdOrUuid($data['user_id']);
            $data = $this->requestData($user, $data);
            $personalData->update(Auditor::update($data));
            return $personalData;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** Private methods with logic */
    private function requestData($user, $data)
    {
        if (!isset($data['name'])) $data['name'] = $user->name;
        if (!isset($data['full_name'])) $data['full_name'] = $user->name;
        if (!isset($data['phone'])) $data['phone'] = $user->phone;

        $data['concat'] = $data['name'] . $data['full_name'] . $data['phone'];
        $data['user_id'] = $user->id;

        if (isset($data['nif_bi'])) $data['concat'] .= $data['nif_bi'];

        return $data;
    }
}
