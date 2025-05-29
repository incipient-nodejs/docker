<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\Website;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Interfaces\ICrud;

class WebsiteService implements ICrud
{
    private $businessDetailService;

    function __construct(){
        $this->businessDetailService = new BusinessDetailService();
    }

    /** @override */
    public function findAll()
    {
        try {
            $websites = Website::with('businessDetail')->where(Auditor::filter())->orderBy('id','DESC')->get();
            return $websites;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function paginate()
    {
        try {
            $paginatedWebsites = Website::with('businessDetail')->where(Auditor::filter())->orderBy('id','DESC')->paginate();
            return $paginatedWebsites;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function create(array $data)
    {
        try {
            $businessDetail = $this->businessDetailService->findByUuid($data['businessDetail_id']);
            $data = $this->requestData($businessDetail, $data);
            $website = Website::create(Auditor::create($data));
            return $website;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id)
    {
        try {
            return $this->updateWithModel($data, $this->findByUuid($id));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function delete(string $id): void
    {
        try {
            $website = $this->findByUuid($id);
            $website->update(Auditor::delete());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateWithModel(array $data, $website): Website
    {
        try {
            $businessDetail = $website->businessDetail;
            if (isset($data['businessDetail_id'])) {
                $businessDetail = $this->businessDetailService->findByIdOrUuid($data['businessDetail_id']);
            }
            $data = $this->requestData($businessDetail, $data);
            $website->update(Auditor::update($data));
            return $website;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findByIdOrUuid(string $idOrUuid): Website
    {
        try {
            $website = Website::where(function ($query) use ($idOrUuid) {
                $query->where('uuid', $idOrUuid)->where(Auditor::filter());
            });

            if (is_numeric($idOrUuid)) {
                $website->orWhere('id', $idOrUuid);
            }
            $website = $website->firstOrFail();
            return $website;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }


    private function requestData($businessDetail, $data)
    {
        if (!isset($data['name'])) $data['name'] = $businessDetail->name;
        $data['business_detail_id'] = $businessDetail->id;
        return $data;
    }
}

