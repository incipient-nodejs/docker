<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\User;
use App\Models\Banner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ICrud;
use App\Util\FileUpload;
class BannerService implements ICrud
{

    function __construct(){
    }

    /** @override */
    public function findAll()
    {
        return Banner::get();
    }

    /** @override */
    public function paginate()
    {
        return Banner::paginate();
    }

    /** @override */
    public function create($request)
    {
        $data = $request->all();
        return Banner::create(Auditor::create($data));
    }

    /** @override */
    public function update($request, string $id)
    {
        return $this->updateWithModel($request, $this->findByIdOrUuid($id));
    }

    /** @override */
    public function delete(string $id)
    {
        $product = $this->findByIdOrUuid($id);
        $product->delete();
    }

    public function findByIdOrUuid(string $idOrUuid)
    {
        $query = Banner::where(function ($query) use ($idOrUuid) {
            $query->where('uuid', $idOrUuid);
        });

        if (is_numeric($idOrUuid))  $query->orWhere('id', $idOrUuid);

        return $query->firstOrFail();
    }

    public function getBannersByScreenProdutos(){
        return Banner::where('posicao_tela', 'produtos')
                    ->orderBy('type')
                    ->orderBy('posicao_grupo')
                    ->orderBy('posicao_interna')
                    ->get();
    }

    public function getBannersByScreen($screen){
        return Banner::where('posicao_tela', $screen)
                    ->where('type', 'horizontal')
                    ->orderBy('posicao_grupo')
                    ->orderBy('posicao_interna')
                    ->get();
    }

    public function getBannersByScreenVertical($screen){
        return Banner::where('posicao_tela', $screen)
                    ->where('type', 'vertical')
                    ->orderBy('posicao_grupo')
                    ->orderBy('posicao_interna')
                    ->get();
    }

    public function updateWithModel($request, $product): Banner
    {
        $data = $request->all();
        $product->update(Auditor::update($data));
        return $product;
    }
}
