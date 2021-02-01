<?php

namespace App\Tests\Functional;

use App\Entity;
use App\Repository\ItemRepository;

/**
 * Class ItemControllerTest
 *
 * @package App\Tests\Functional
 */
class ItemControllerTest extends BaseTest
{
    /**
     * Test successful item creation.
     */
    public function testSuccessCreate()
    {
        $itemRepository = static::$container->get(ItemRepository::class);

        $data = 'very secure new item data';

        $newItemData = ['data' => $data];

        self::$httpClient->request('POST', '/item', $newItemData);
        $createResponse = self::$httpClient->getResponse()->getContent();

        self::$httpClient->request('GET', '/item');
        $ListResponse = self::$httpClient->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString($data, $ListResponse);

        // test changes in database.
        /** @var Entity\Item $itemFromDB */
        $itemFromDB = $itemRepository->find((json_decode($createResponse)->id));
        $this->assertEquals($itemFromDB->getData(), $data);
    }

    /**
     * Test failed item creation.
     *
     * @param string $data
     * @param string $errorMessage
     *
     * @dataProvider getInvalidInputData
     */
    public function testFailedCreate(string $data, string $errorMessage)
    {
        self::$httpClient->request('POST', '/item', ['data' => $data]);
        $response = json_decode(self::$httpClient->getResponse()->getContent());

        $this->assertEquals($errorMessage, $response->error);
    }

    /**
     * Data provider with invalid input.
     *
     * @return array
     */
    public function getInvalidInputData(): array
    {
        return [
            [
                'data' => "123",
                'errorMessage' => "This value is too short. It should have 4 characters or more."
            ],
            [
                'data' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                            when an unknown printer took a galley of type and scrambled it to make a type 
                            specimen book. It has survived not only five centuries, but also the leap into e",
                'errorMessage' => "This value is too long. It should have 200 characters or less."
            ],
            [
                'data' => "<script>alert('Hello from XSS');</script>",
                'errorMessage' => "The string \"<script>alert('Hello from XSS');</script>\" contains illegal characters."
            ],
            [
                'data' => "",
                'errorMessage' => "This value should not be blank."
            ],
        ];
    }
}
