<?php

namespace App\Services\Importers;

interface ImporterInterface
{
    public function import(): ?array;
    public function getSourceName(): string;
}
