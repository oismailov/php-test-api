<?php

namespace App\Resource;

use App\Entity;
use Ramsey\Collection\Collection;

/**
 * Class ItemList
 *
 * @package App\Resource
 */
class ItemList
{
    /**
     * @var Collection
     */
    private $items;

    /**
     * ItemList constructor.
     *
     * @param Collection $items
     */
    public function __construct(Collection $items)
    {
        $this->items = $items;
    }

    /**
     * Convert Items Entity to array.
     *
     * @return array[]
     */
    public function toArray()
    {
        return array_map(function (Entity\Item $item) {
            return (new Item($item))->toArray();
        }, $this->items->toArray());
    }
}