<?php

namespace App\Interfaces;

use GuzzleHttp\Psr7\Request;

interface UserInterface
{
    public function all();

    public function store(array $request);

    public function update(array $request);

    public function delete(array $request);

}
