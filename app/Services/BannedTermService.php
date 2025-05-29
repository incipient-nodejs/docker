<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\User;
use App\Models\BannedTerms;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ICrud;

class BannedTermService implements Icrud
{

    function __construct(){
    }

    /** @override */
    public function findAll()
    {
        return BannedTerms::get();
    }

    /** @override */
    public function paginate()
    {
        return BannedTerms::paginate();
    }

    /** @override */
    public function findById($id){
        return BannedTerms::find($id);
    }

    /** @override */
    public function create($request)
    {
        $data = $this->requestData($request);
        return BannedTerms::create($data);
    }

    /** @override */
    public function update($request, string $id)
    {
        $data = $this->requestData($request);
        $bannedTerm = $this->findById($id);
        $bannedTerm->update($data);
        return $bannedTerm;
    }

    /** @override */
    public function delete(string $id): void
    {
        $bannedTerm = $this->findById($id);
        $bannedTerm->delete();
    }

    private function requestData($request){
        $data = $request->all();
        $data['concat'] = $data['text_en'];
        if($data['text_pt']) $data['concat'] .= $data['text_pt'];
        return $data;
    }
}
