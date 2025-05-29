<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Interfaces\ICrud;
use App\Util\FileUpload;
use App\Module\Product\Models\ProductApi;
use Illuminate\Http\Request;
use App\Models\Favorite;

class ProductService implements ICrud
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
        /*
        if (Redis::exists('products:json')) {
            $products = json_decode(Redis::get('products:json'), true);
            return collect($products);
        }
        */

        $product = Product::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())->get();
        Redis::set('products:json', $product);
        return $product;
    }

    /** @override */
    public function paginate()
    {
        return Product::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')->inRandomOrder()->where(Auditor::filter())->paginate(25); //150
    }

    /** @override */
    public function create($request)
    {
        if (Redis::exists('products:json')) {
            Redis::del('products:json');
        }
        $data = $request->all();

        FileUpload::uploadImageProduct($request, $data);
        FileUpload::uploadImageTraseiroProduct($request, $data);
        FileUpload::uploadImageEsquerdaProduct($request, $data);
        FileUpload::uploadImageDireitaProduct($request, $data);
        FileUpload::uploadVideoProduct($request, $data);

        $category = $this->categoryService->findByIdOrUuid($data['category_id']);
        $user = $this->userService->findByIdOrUuid($data['user_id']);
        $data = $this->requestData($user, $category, $data);
        return Product::create(Auditor::create($data));
    }

    /** @override */
    public function update($request, $id)
    {
        if (Redis::exists('products:json')) {
            Redis::del('products:json');
        }
        return $this->updateWithModel($request, $this->findByIdOrUuid($id));
    }

    /** @override */
    public function delete($id)
    {
        if (Redis::exists('products:json')) {
            Redis::del('products:json');
        }
        $product = $this->findByIdOrUuid($id);
        $product->update(array_merge(Auditor::delete()));
        Favorite::where('product_id', $product->id)
        ->delete();
    }

    public function findByIdOrUuid($idOrUuid): Product
    {
        $query = Product::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')->where(function ($query) use ($idOrUuid) {
            $query->where('uuid', $idOrUuid)->where(Auditor::filter());
        });
        if (is_numeric($idOrUuid)) {
            $query->orWhere('id', $idOrUuid);
        }
        return $query->firstOrFail();
    }

    public function findAllByUser($userId): Collection
    {
        $user = $userId instanceof User ? $userId : $this->userService->findByIdOrUuid($userId);
        return Product::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')
            ->where('user_id', $user->id)
            ->where(Auditor::filter())
            ->get();
    }

    public function findAllSuppliers(){
        $items = [];
        $categories = $this->categoryService->findAllSupplier();
        $productCategories = $categories->map(function($it){
            $products = $this->findByCategory($it->id);
            return (object)[
                "category" => $it,
                "products" => $products,
            ];
        })->all();

        return $productCategories;
    }

    // orignal code (old)
    // public function search(string $search): LengthAwarePaginator
    // {
    //   $producst = Product::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')->whereHas('user.companyData')->where(Auditor::filter())->where('concat', 'like', '%'.$search.'%')->orderBy('id', 'DESC')->paginate(100);
    //   Log::info('product', ['producst' => $producst]);
    //       $productsApi = ProductApi::where('name', 'like', '%'.$search.'%')->orderBy('id', 'DESC')->limit(100)->get()->map(function($q){
    //         return $q->toProduct();
    //       });

    //   Log::info('product_api', ['product_api' => $productsApi]);
    //   return $this->mergeResults($producst, $productsApi);
    // }

    public function search(string $search): LengthAwarePaginator
    {
            // Product table with all required relations
            $products = Product::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')
                ->whereHas('user.companyData')
                ->where(Auditor::filter())
                ->where('concat', 'like', '%'.$search.'%')
                ->orderBy('id', 'DESC')
                ->paginate(100);

            Log::info('product', ['products' => $products]);

            // ProductApi table with eager loaded user + companyData
            $productApiResults = ProductApi::with('user.companyData')
                ->where('name', 'like', '%'.$search.'%')
                ->orderBy('id', 'DESC')
                ->limit(100)
                ->get()
                ->map(function ($q) {
                    $product = $q->toProduct();
                    // Attach user + companyData to the fake Product model
                    if ($q->relationLoaded('user')) {
                        $product->setRelation('user', $q->user);
                    }
                    return $product;
                });

            Log::info('product_api', ['product_api' => $productApiResults]);

            // Merge both into a single collection
            $merged = $products->getCollection()->merge($productApiResults);

            // Create a new paginator manually
            $mergedPaginated = new LengthAwarePaginator(
                $merged,
                $products->total() + $productApiResults->count(),
                $products->perPage(),
                $products->currentPage(),
                ['path' => request()->url(), 'query' => request()->query()]
            );

            return $mergedPaginated;
    }
    // with('user.companyData','user.personalData')
    public function supplierSearch(string $search): LengthAwarePaginator
    {
        return Product::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')
                ->join('users', 'users.id', 'products.user_id')
                ->where(Auditor::filter("products"))
                ->where('category', 'Fabricantes')
                ->where('products.concat', 'like', '%'.$search.'%')
                ->orderBy('id', 'DESC')
                ->select('products.*')
                ->paginate(150);
    }

    public function paginateCategory(string $idOrUuid): LengthAwarePaginator
    {
        $category = $this->categoryService->findByIdOrUuid($idOrUuid);
        return Product::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')->where(Auditor::filter())->where('category_id', $category->id)->paginate();
    }

    public function findByCategory(string $idOrUuid)
    {
        return Product::with('category', 'user.personalData', 'user.companyData', 'user.businessDetail')
                ->join('users', 'users.id', 'products.user_id')
                ->where(Auditor::filter("products"))
                ->where('category_id', $idOrUuid)
                ->orWhere('category', 'Fabricantes')
                ->select('products.*')
                ->get();
    }

    public function updateWithModel($request, $product): Product
    {
        if (Redis::exists('products:json')) {
            Redis::del('products:json');
        }
        $data = $request->all();
        $category = $product->category;
        $user = $product->user;

        FileUpload::uploadImageProduct($request, $data);
        FileUpload::uploadImageTraseiroProduct($request, $data);
        FileUpload::uploadImageEsquerdaProduct($request, $data);
        FileUpload::uploadImageDireitaProduct($request, $data);
        FileUpload::uploadVideoProduct($request, $data);

        if(isset($data['category_id'])) $category = $this->categoryService->findByIdOrUuid($data['category_id']);
        if(isset($data['user_id'])) $user = $this->userService->findByIdOrUuid($data['user_id']);
        $data = $this->requestData($user, $category, $data);
        $product->update(Auditor::update($data));
        return $product;
    }

    public function counterView(string $idOrUuid)
    {
        $product = $this->findByIdOrUuid($idOrUuid);
        if(!isset($product->id)) return false;
        $product->update(['counter_view' => $product->counter_view + 1]);
        return true;
    }

    /** Private methods with logic */
    private function requestData($user, $category, $data){

        $data['user_id'] = $user->id;
        $data['category_id'] = $category->id;
        $data['concat'] = '';


        if(!isset($data['address'])) {
            if(isset($user->address)) $data['address'] =  $user->address;
            if(isset($user->companyData->location)) $data['address'] =  $user->companyData->location;
        }

        if(isset($data['name'])) $data['concat'] .= $data['name'];
        if(isset($data['price'])) $data['concat'] .= $data['price'];
        if(isset($data['description'])) $data['concat'] .= $data['description'];

        return $data;
    }

    private function mergeResults($products, $productsApi ){
        $perPage = 100;
        $merged = $products->merge($productsApi)->sortByDesc('id')->values();
        $page = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $merged->slice(($page - 1) * $perPage, $perPage);
        return new LengthAwarePaginator($currentItems, $merged->count(), $perPage, $page, []);
    }

}
