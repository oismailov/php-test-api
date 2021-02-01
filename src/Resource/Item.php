<?php

namespace App\Resource;

use App\Entity;

/**
 * Class Item
 *
 * @package App\Resource
 */
class Item
{
    /**
     * @var Entity\Item
     */
    private $item;

    /**
     * Item constructor.
     *
     * @param Entity\Item $item
     */
    public function __construct(Entity\Item $item)
    {
        $this->item = $item;
    }

    /**
     * Convert Items Entity to array.
     *
     * @return array[]
     */
    public function toArray()
    {
        return [
            'id' => $this->item->getId(),
            'data' => $this->item->getData(),
            'created_at' => $this->item->getCreatedAt(),
            'updated_at' => $this->item->getUpdatedAt()
        ];

    }
}