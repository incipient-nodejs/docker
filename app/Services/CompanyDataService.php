<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\CompanyData;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Util\FileUpload;
use App\Interfaces\ICrudRequest;
class CompanyDataService implements ICrudRequest
{
    private $userService;

    function __construct(){
        $this->userService = new UserService();
    }

    /** @override */
    public function findAll()
    {
        $companyData = CompanyData::with('user')->where(Auditor::filter())->orderBy('id','DESC')->get();
        return $companyData;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = CompanyData::with('user')->where(Auditor::filter())->orderBy('id','DESC')->paginate();
        return $paginatedData;
    }

    /** @override */
    public function create($request, array $data)
    {
        try {
            $user = $this->userService->findByUuid($data['user_id']);

            FileUpload::uploadCertificationCompanyData($request, $data);

            $data = $this->requestData($user, $data);
            $companyData = CompanyData::create(Auditor::create($data));

            return $companyData;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update($request, array $data, string $id)
    {
        return $this->updateWithModel($request, $data, $this->findByUuid($id));
    }

    /** @override */
    public function delete(string $id): void
    {
        try {
            $companyData = $this->findByIdOrUuid($id);
            $companyData->update(array_merge(Auditor::delete()));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findByUuid(string $uuid): CompanyData
    {
        try {
            $companyData = CompanyData::where(array_merge(['uuid' => $uuid], Auditor::filter()))->firstOrFail();
            return $companyData;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function findByIdOrUuid(string $idOrUuid): CompanyData
    {
        try {
            $query = CompanyData::where(function ($query) use ($idOrUuid) {
                $query->where('uuid', $idOrUuid)->where(Auditor::filter());
            });

            if (is_numeric($idOrUuid)) {
                $query->orWhere('id', $idOrUuid);
            }

            $companyData = $query->firstOrFail();

            return $companyData;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function updateWithModel($request, array $data, $companyData): CompanyData
    {
        try {
            $user = $companyData->user;
            if (isset($data['user_id'])) {
                $user = $this->userService->findByIdOrUuid($data['user_id']);
            }

            FileUpload::uploadCertificationCompanyData($request, $data, $companyData);

            $data = $this->requestData($user, $data);
            $companyData->update(Auditor::update($data));

            return $companyData;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function counterView(string $idOrUuid)
    {
        $companyData = $this->findByIdOrUuid($idOrUuid);
        if(!isset($companyData->id)) return false;
        $companyData->update(['counter_view' => $companyData->counter_view + 1]);
        return true;
    }

    /** Private methods with logic */
    private function requestData($user, $data)
    {
        $data['concat'] = '';
        if (!isset($data['name'])) $data['name'] = $user->name;
        $data['user_id'] = $user->id;

        if (isset($data['certification'])) $data['concat'] .= $data['certification'];
        if (isset($data['location'])) $data['concat'] .= $data['location'];

        return $data;
    }
}
