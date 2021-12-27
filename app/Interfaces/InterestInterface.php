<?php

namespace App\Interfaces;

interface InterestInterface
{
    public function store(array $request);

    public function list();

    public function deposite(array $request);

    public function getUnpaid();

    public function getPaid();
}
