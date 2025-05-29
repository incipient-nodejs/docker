<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\FormalType;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Util\FileUpload;
use App\Interfaces\ICrud;

class FormalTypeService implements ICrud
{
    private $userService;

    function __construct(){
        $this->userService =  new UserService();
    }

    /** @override */
    public function findAll()
    {
        $formalTypes = FormalType::with('user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())->orderBy('id','DESC')->get();
        return $formalTypes;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = FormalType::with('user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())->orderBy('id','DESC')->paginate();
        return $paginatedData;
    }

    /** @override */
    public function create(array $data)
    {
        try {
            $user = $this->userService->findByUuid($data['user_id']);
            $data = $this->requestData($user, $data);
            $formalType = FormalType::create(Auditor::create($data));
            return $formalType;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id)
    {
        try {
            $formalType = $this->findByUuid($id);
            $data = $this->requestData($formalType->user, $data);
            $formalType->update(Auditor::update($data));
            return $formalType;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function delete(string $id): void
    {
        try {
            $formalType = $this->findByUuid($id);
            $formalType->update(array_merge(Auditor::delete()));
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function findByIdOrUuid($idOrUuid): FormalType
    {
        $query = FormalType::with('user.personalData', 'user.companyData', 'user.businessDetail')->where(function ($query) use ($idOrUuid) {
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
