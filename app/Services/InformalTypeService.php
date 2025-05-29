<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\InformalType;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Interfaces\ICrud;

class InformalTypeService implements ICrud
{
    private $userService;

    function __construct(){
        $this->userService =  new UserService();
    }

    /** @override */
    public function findAll()
    {
        $informalTypes = InformalType::with('user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())->orderBy('id','DESC')->get();
        return $informalTypes;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = InformalType::with('user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())->orderBy('id','DESC')->paginate();
        return $paginatedData;
    }

    /** @override */
    public function create(array $data)
    {
        try {
            $user = $this->userService->findByUuid($data['user_id']);
            $data = $this->requestData($user, $data);
            $informalType = InformalType::create(Auditor::create($data));
            return $informalType;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id)
    {
        try {
            $informalType = $this->findByUuid($id);
            $data = $this->requestData($informalType->user, $data);
            $informalType->update(Auditor::update($data));
            return $informalType;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function delete(string $id): void
    {
        try {
            $informalType = $this->findByUuid($id);
            $informalType->update(array_merge(Auditor::delete()));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findByIdOrUuid($idOrUuid): InformalType
    {
        $query = InformalType::with('user.personalData', 'user.companyData', 'user.businessDetail')->where(function ($query) use ($idOrUuid) {
            $query->where('uuid', $idOrUuid)->where(Auditor::filter());
        });
        if (is_numeric($idOrUuid)) {
            $query->orWhere('id', $idOrUuid);
        }
        return $query->firstOrFail();
    }

    /** Private methods with logic */
    private function requestData($user, $data)
    {
        if (!isset($data['name'])) $data['name'] = $user->name;
        if (!isset($data['phone'])) $data['phone'] = $user->phone;
        if (!isset($data['whatsapp'])) $data['whatsapp'] = $user->phone;

        $data['concat'] = $data['name'].$data['phone'].$data['whatsapp'];
        $data['user_id'] = $user->id;

        if (isset($data['website'])) $data['concat'] .= $data['website'];
        if (isset($data['offers'])) $data['concat'] .= $data['offers'];

        return $data;
    }
}
