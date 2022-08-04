<?php

namespace App\Interfaces;

use App\Models\InputData;

interface InputReaderServiceInterface
{
    /**
     * @return InputData[]
     */
    public function read(string $filename): array;
}
