<?php

namespace App\Services;
use Illuminate\Support\Facades\Redis;

use App\Util\Auditor;
use App\Models\Category;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Interfaces\ICrud;

class CategoryService implements ICrud
{
    /** @override */
    public function findAll()
    {
        // if (Redis::exists('categorys:json')) {
        //     $category = json_decode(Redis::get('categorys:json'), true);
        //     return collect($category);
        // }
        $categories = Category::where(Auditor::filter())->orderBy('id', 'DESC')->get();
        // Redis::set('users:json', $categories);
        return $categories;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = Category::where(Auditor::filter())->orderBy('id', 'DESC')->paginate();
        return $paginatedData;
    }

    /** @override */
    public function create(array $data)
    {
        try {
            if (!isset($data['code'])) $data['code'] = strtoupper($data['name']);
            $data['concat'] = $data['name'].$data['code'].$data['type'];
            if (isset($data['description']))  $data['concat'] .= $data['description'];

            $category = Category::create(Auditor::create($data));

            if (Redis::exists('categorys:json')) {
                Redis::del('categorys:json');
            }

            return $category;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id)
    {
        return $this->updateWithModel($data, $this->findByIdOrUuid($id));
    }

    /** @override */
    public function delete(string $id): void
    {
        try {
            $category = $this->findByUuid($id);
            $category->update(array_merge(Auditor::delete(), [
                'name' => Auditor::uniqueDelete($category->name)
            ]));
            if (Redis::exists('categorys:json')) {
                Redis::del('categorys:json');
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findAllProduct(): Collection
    {
        $data = array_merge(Auditor::filter(), ["type" => "product"]);
        $categories = Category::where($data)->orderBy('id', 'DESC')->get();
        return $categories;
    }

    public function findAllService(): Collection
    {
        $data = array_merge(Auditor::filter(), ["type" => "service"]);
        $categories = Category::where($data)->orderBy('id', 'DESC')->get();
        return $categories;
    }

    public function findAllSupplier(): Collection
    {
        $data = array_merge(Auditor::filter(), ["type" => "supplier"]);
        $categories = Category::where($data)->orderBy('id', 'DESC')->get();
        return $categories;
    }

    public function findByUuid(string $uuid): Category
    {
        try {
            $category = Category::where(array_merge(['uuid' => $uuid], Auditor::filter()))->firstOrFail();
            return $category;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function findByIdOrUuid(string $idOrUuid)
    {
        try {
            $query = Category::where(function ($query) use ($idOrUuid) {
                $query->where('uuid', $idOrUuid)->where(Auditor::filter());
            });

            if (is_numeric($idOrUuid)) {
                $query->orWhere('id', $idOrUuid);
            }

            $category = $query->firstOrFail();
            return $category;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function updateWithModel(array $data, $category): Category
    {
        try {
            if (!isset($data['code'])) $data['code'] = strtoupper($data['name']);
            $data['concat'] = $data['name'].$data['code'].$data['type'];
            if (isset($data['description']))  $data['concat'] .= $data['description'];
            $category->update(Auditor::update($data));

            if (Redis::exists('categorys:json')) {
                Redis::del('categorys:json');
            }
            return $category;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
