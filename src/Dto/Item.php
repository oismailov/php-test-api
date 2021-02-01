<?php

namespace App\Dto;

/**
 * Class Item
 *
 * @package App\Dto
 */
class Item
{
    /**
     * @var string|null
     */
    private $data;

    public function __construct(array $rawData)
    {
        $this->data = $rawData['data'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getData(): ?string
    {
        return $this->data;
    }
}