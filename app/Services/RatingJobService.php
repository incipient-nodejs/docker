<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\RatingService;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Interfaces\ICrud;
use App\Models\Service;

class RatingJobService implements ICrud
{
    /** @override */
    public function findAll()
    {
        $ratingService = RatingService::all();
        return $ratingService;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = RatingService::paginate();
        return $paginatedData;
    }

    /** @override */
    public function create(array $data)
    {
        try {
            $ratingService = RatingService::updateOrCreate([
                'user_id' => $data['user_id'], 'service_id' => $data['service_id']
            ], $data);

            $totalRatedUser = RatingService::where('service_id',$data['service_id'])->get();
            $totalUser = $totalRatedUser->count();
            $ratingCounts = $totalRatedUser->sum('value');
            $rating = $totalUser > 0 ? round($ratingCounts / $totalUser, 1) : 0;

            // Store rating value service table
            if(isset($data['service_id'])){

                $storeRatigValue = Service::where('id',$data['service_id'])->update(['rating'=>$rating,'rated_user_count'=>$totalUser]);
            }
            $ratingService['rating'] = $rating;
            $ratingService['rated_user_count'] = $totalUser;
            return $ratingService;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id)
    {
        try {
            $ratingService = $this->findById($id);
            $ratingService->update($data);
            return $ratingService;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function delete(string $id)
    {
        try {
            $ratingService = $this->findById($id);
            $ratingService->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findById(string $idOrUuid): RatingService
    {
        try {
            $ratingService = RatingService::findOrFail($idOrUuid);
            return $ratingService;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function userRatingForService($request){
        $getUserRatingByService = RatingService::where("user_id",$request['user_id'])->where("service_id",$request['service_id'])->first();
        if (!$getUserRatingByService) {
            throw new ModelNotFoundException('Rating not found for this user and product.');
        }
        return $getUserRatingByService;
    }
}
