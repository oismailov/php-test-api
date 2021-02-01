<?php

namespace App\Tests\Functional;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class BaseTest
 *
 * @package App\Tests\Functional
 */
abstract class BaseTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    public static $httpClient;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        self::$httpClient = self::$httpClient ?? static::createClient();
    }

    /**
     * Log user in before tests.
     */
    public static function setUpBeforeClass()
    {
        $userRepository = static::$container->get(UserRepository::class);

        $user = $userRepository->findOneByUsername('john');

        self::$httpClient->loginUser($user);
    }

    /**
     * Log user out after tests.
     */
    public static function tearDownAfterClass()
    {
        self::$httpClient->request('POST', '/logout');
    }
}