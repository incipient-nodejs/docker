<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\RatingProduct;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Interfaces\ICrud;
use App\Models\Product;

class RatingProductService implements ICrud
{
    /** @override */
    public function findAll()
    {
        $ratingProduct = RatingProduct::all();
        return $ratingProduct;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = RatingProduct::paginate();
        return $paginatedData;
    }

    /** @override */
    public function create(array $data)
    {

        try {
            // Store rating value
            $ratingProduct = RatingProduct::updateOrCreate([
                'user_id' => $data['user_id'], 'product_id' => $data['product_id']
            ], $data);

            $totalRatedUser = RatingProduct::where('product_id',$data['product_id'])->get();
            $totalUser = $totalRatedUser->count();
            $ratingCounts = $totalRatedUser->sum('value');
            $rating = $totalUser > 0 ? round($ratingCounts / $totalUser, 1) : 0;

            // Store rating value product table
            if(isset($data['product_id'])){

                $storeRatigValue = Product::where('id',$data['product_id'])->update(['rating'=>$rating,'rated_user_count'=>$totalUser]);
            }
            $ratingProduct['rating'] = $rating;
            $ratingProduct['rated_user_count'] = $totalUser;
            return $ratingProduct;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id)
    {
        try {
            $ratingProduct = $this->findById($id);
            $ratingProduct->update($data);
            return $ratingProduct;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function delete(string $id): void
    {
        try {
            $ratingProduct = $this->findById($id);
            $ratingProduct->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function findById(string $idOrUuid): RatingProduct
    {
        try {
            $ratingProduct = RatingProduct::findOrFail($idOrUuid);
            return $ratingProduct;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function userRatingForProduct($request){

            $getUserRatingByProduct = RatingProduct::where("user_id",$request['user_id'])->where("product_id",$request['product_id'])->first();
            if (!$getUserRatingByProduct) {
                throw new ModelNotFoundException('Rating not found for this user and product.');
            }
            return $getUserRatingByProduct;
    }
}
