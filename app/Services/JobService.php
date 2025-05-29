<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\User;
use App\Models\Service;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Interfaces\ICrudRequest;
use App\Models\Favorite;
use App\Util\FileUpload;

class JobService  implements ICrudRequest
{
    private $categoryService;
    private $userService;

    function __construct(){
        $this->categoryService = new CategoryService();
        $this->userService = new UserService();
    }

    /** @override */
    public function findAll()
    {
        $services = Service::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())->orderBy('id','DESC')->get();
        return $services;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = Service::with( 'category', 'user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())->inRandomOrder()->orderBy('id','DESC')->paginate();
        return $paginatedData;
    }

    /** @override */
    public function create($request, array $data)
    {
        try {
            $category = $this->categoryService->findByIdOrUuid($data['category_id']);
            $user = $this->userService->findByIdOrUuid($data['user_id']);

            FileUpload::uploadImageService($request, $data);
            FileUpload::uploadVideoService($request, $data);

            $data = $this->requestData($user, $category, $data);
            $service = Service::create(Auditor::create($data));
            return $service;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update($request, array $data, string $id)
    {
        return $this->updateWithModel($request, $data, $this->findByIdOrUuid($id));
    }

    /** @override */
    public function delete($id)
    {
        $service = $this->findByIdOrUuid($id);
        $service->update(array_merge(Auditor::delete()));
        Favorite::where('service_id', $service->id)
        ->delete();
    }


    public function findByIdOrUuid(string $idOrUuid)
    {
        try {
            $service = Service::with('category','user.personalData', 'user.companyData', 'user.businessDetail')->where(array_merge(['uuid' => $idOrUuid], Auditor::filter()))
                ->orWhere('id', $idOrUuid)
                ->firstOrFail();
            return $service;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function findAllByUser($userId)
    {
        $user = $userId instanceof User ? $userId : $this->userService->findByIdOrUuid($userId);

        return Service::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')
            ->where('user_id', $user->id)
            ->where(Auditor::filter())
            ->get();
    }

    public function searchList($text)
    {
        $services = Service::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())
            ->where("concat", "like", "%{$text}%")
            ->orderBy('id','DESC')
            ->get();
        return $services;
    }

    public function paginateCategory(string $idOrUuid)
    {
        $category = $this->categoryService->findByIdOrUuid($idOrUuid);
        $paginatedData = Service::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())->where('category_id', $category->id)->paginate();
        return $paginatedData;
    }

    public function search(string $search)
    {
        return Service::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())->where('concat', 'like', '%'.$search.'%')->orderBy('id', 'DESC')->paginate();
    }

    public function findByUuid(string $uuid): Service
    {
        try {
            $service = Service::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')->where(array_merge(['uuid' => $uuid], Auditor::filter()))->firstOrFail();
            return $service;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function updateWithModel($request, array $data, $service): Service
    {
        try {
            $category = $service->category;
            $user = $service->user;

            FileUpload::uploadImageService($request, $data, $service);
            FileUpload::uploadVideoService($request, $data, $service);

            if (isset($data['category_id'])) $category = $this->categoryService->findByIdOrUuid($data['category_id']);
            if (isset($data['user_id'])) $user = $this->userService->findByIdOrUuid($data['user_id']);

            $data = $this->requestData($user, $category, $data);
            $service->update(Auditor::update($data));
            return $service;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** Private methods with logic */
    private function requestData($user, $category, $data){
        $data['user_id'] = $user->id;
        $data['category_id'] = $category->id;
        $data['concat'] = '';

        if(isset($data['name'])) $data['concat'] .= $data['name'];
        if(isset($data['description'])) $data['concat'] .= $data['description'];

        return $data;
    }
}
