<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\BusinessDetail;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Interfaces\ICrud;
class BusinessDetailService implements ICrud
{
    private $userService;

    function __construct(){
        $this->userService = new UserService();
    }

    /** @override */
    public function findAll()
    {
        $businessDetails = BusinessDetail::with('user')->where(Auditor::filter())->orderBy('id','DESC')->get();
        return $businessDetails;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = BusinessDetail::with('user')->where(Auditor::filter())->orderBy('id','DESC')->paginate();
        return $paginatedData;
    }

    /** @override */
    public function create(array $data)
    {
        try {
            $user = $this->userService->findByUuid($data['user_id']);
            $data = $this->requestData($user, $data);
            $businessDetail = BusinessDetail::create(Auditor::create($data));
            return $businessDetail;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id): BusinessDetail
    {
        return $this->updateWithModel($data, $this->findByUuid($id));
    }

    /** @override */
    public function delete(string $id): void
    {
        try {
            $businessDetail = $this->findByIdOrUuid($id);
            $businessDetail->update(array_merge(Auditor::delete()));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findByUuid(string $uuid)
    {
        try {
            $businessDetail = BusinessDetail::where(array_merge(['uuid' => $uuid], Auditor::filter()))->firstOrFail();
            return $businessDetail;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }


    public function findByIdOrUuid(string $idOrUuid): BusinessDetail
    {
        try {
            $query = BusinessDetail::where(function ($query) use ($idOrUuid) {
                $query->where('uuid', $idOrUuid)->where(Auditor::filter());
            });

            if (is_numeric($idOrUuid)) {
                $query->orWhere('id', $idOrUuid);
            }

            $businessDetail = $query->firstOrFail();
            return $businessDetail;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function updateWithModel(array $data, $businessDetail): BusinessDetail
    {
        try {
            $user = $businessDetail->user;
            if (isset($data['user_id'])) {
                $user = $this->userService->findByIdOrUuid($data['user_id']);
            }
            $data = $this->requestData($user, $data);
            $businessDetail->update(Auditor::update($data));
            return $businessDetail;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function requestData($user, $data)
    {
        if (!isset($data['name'])) $data['name'] = $user->name;
        if (!isset($data['phone_preference'])) $data['phone_preference'] = $user->phone;
        if (!isset($data['whatsapp'])) $data['whatsapp'] = $user->phone;
        if (!isset($data['phone'])) $data['phone'] = $user->phone;
        if (!isset($data['email'])) $data['email'] = $user->email;

        $data['concat'] = $data['name'].$data['phone_preference'].$data['phone'].$data['whatsapp'].$data['email'];
        $data['user_id'] = $user->id;

        return $data;
    }
}
