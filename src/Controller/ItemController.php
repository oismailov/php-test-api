<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto;
use App\Resource;
use App\Service;
use App\Validator;
use App\Traits;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends AbstractController
{
    use Traits\Validator;

    /**
     * @var Service\Item\UserItem
     */
    private $userItemService;

    /**
     * ItemController constructor.
     *
     * @param Service\Item\UserItem $userItemService
     */
    public function __construct(Service\Item\UserItem $userItemService)
    {
        $this->userItemService = $userItemService;
    }

    /**
     * List all user items.
     *
     * @Route("/item", name="item_list", methods={"GET"})
     * @IsGranted("ROLE_USER")
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $items = $this->userItemService->getAll($this->getUser());

        return $this->json((new Resource\ItemList($items))->toArray());
    }

    /**
     * Create user item.
     *
     * @Route("/item", name="item_create", methods={"POST"})
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $itemDto = new Dto\Item(['data' => $request->get('data')]);

        $itemValidator = new Validator\Item($itemDto->getData());
        $errors = $this->getValidator()->validate($itemValidator);

        if ($errors->count() > 0) {
            return $this->json(['error' => $errors->get(0)->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $item = $this->userItemService->create($this->getUser(), $itemDto->getData());

        return $this->json((new Resource\Item($item))->toArray());
    }

    /**
     * Delete user item.
     *
     * @Route("/item/{id}", name="item_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     * @IsGranted("ROLE_USER")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        $item = $this->userItemService->get($this->getUser(), $id);

        if ($item === null) {
            return $this->json(['error' => 'No item'], Response::HTTP_BAD_REQUEST);
        }

        $this->userItemService->delete($item);

        return $this->json((new Resource\Item($item))->toArray());
    }

    /**
     * Update user item.
     *
     * @Route("/item/{id}", name="item_update", methods={"PUT"}, requirements={"id"="\d+"})
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $item = $this->userItemService->get($this->getUser(), $id);

        if ($item === null) {
            return $this->json(['error' => 'No item'], Response::HTTP_BAD_REQUEST);
        }

        $itemDto = new Dto\Item(['data' => $request->get('data')]);

        $dataValidator = new Validator\Item($itemDto->getData());
        $errors = $this->getValidator()->validate($dataValidator);

        if ($errors->count() > 0) {
            return $this->json(['error' => $errors->get(0)->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json((new Resource\Item($this->userItemService->update($item, $itemDto->getData())))->toArray());
    }
}
