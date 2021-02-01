<?php

namespace App\Service\Item;

use App\Entity;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Collection\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Service
 *
 * @package App\Service\Item
 */
class Service implements UserItem
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Service constructor.
     *
     * @param ItemRepository $itemRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ItemRepository $itemRepository, EntityManagerInterface $entityManager)
    {
        $this->itemRepository = $itemRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function getAll(UserInterface $user): Collection
    {
        return new Collection(
            Entity\Item::class,
            $this->itemRepository->findBy(['user' => $user])
        );
    }


    /**
     * @inheritDoc
     */
    public function create(UserInterface $user, string $data): Entity\Item
    {
        $item = (new Entity\Item())
            ->setUser($user)
            ->setData($data);

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $item;
    }

    /**
     * @inheritDoc
     */
    public function get(UserInterface $user, int $id): ?Entity\Item
    {
        return $this->itemRepository->findOneBy([
            'user' => $user,
            'id' => $id
        ]);
    }

    /**
     * @inheritDoc
     */
    public function delete(Entity\Item $item): void
    {
        $this->entityManager->remove($item);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function update(Entity\Item $item, string $data): Entity\Item
    {
        $item->setData($data);
        $item->setUpdatedAt(new \DateTime('NOW'));

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $item;
    }
}