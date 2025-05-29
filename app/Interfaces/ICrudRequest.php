<?php

namespace App\Interfaces;

interface ICrudRequest extends ICrudDelete, ICrudFindAll, ICrudPaginate {
    function create($request, array $data);
    function update($request, array $data, string $id);
}
