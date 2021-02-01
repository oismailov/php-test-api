<?php

namespace App\Service\Item;

use App\Entity;
use Ramsey\Collection\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface Item
 *
 * @package App\Service\Item
 */
interface UserItem
{
    /**
     * Get all user items.
     *
     * @param UserInterface $user
     *
     * @return Entity\Item[] | Collection
     */
    public function getAll(UserInterface $user): Collection;

    /**
     * Create item.
     *
     * @param UserInterface $user
     * @param string $data
     *
     * @return Entity\Item
     */
    public function create(UserInterface $user, string $data): Entity\Item;

    /**
     * Get user item by id.
     *
     * @param UserInterface $user
     * @param int $id
     *
     * @return Entity\Item|null
     */
    public function get(UserInterface $user, int $id): ?Entity\Item;

    /**
     * Delete user item by id.
     *
     * @param Entity\Item $item
     *
     * @return void
     */
    public function delete(Entity\Item $item): void;

    /**
     * Update user item by id.
     *
     * @param Entity\Item $item
     * @param string $data
     *
     * @return Entity\Item
     */
    public function update(Entity\Item $item, string $data): Entity\Item;
}