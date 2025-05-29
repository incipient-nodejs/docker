<?php

namespace App\Interfaces;

interface ICrudUpdate{
    function update(array $data, string $id);
}
