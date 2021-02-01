<?php

namespace App\Validator;

use App\Validator\Constraints as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class Item
 *
 * @package App\Validator
 */
class Item
{
    /**
     * @var string|null
     */
    public $data;

    /**
     * Item constructor.
     *
     * @param string|null $data
     */
    public function __construct(string $data = null)
    {
        $this->data = $data;
    }

    /**
     * Get data.
     *
     * @return string|null
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * Run validation against class properties.
     *
     * @param ClassMetadata $metadata
     *
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('data', new Assert\NotBlank());
        $metadata->addPropertyConstraint('data', new CustomAssert\XSSProtection\ContainsMaliciousCharacters());
        $metadata->addPropertyConstraint('data', new Assert\Type('string'));
        $metadata->addPropertyConstraint('data', new Assert\Length([
            'min' => $_ENV['DATA_MIN_LENGTH'], 'max' => $_ENV['DATA_MAX_LENGTH']
        ]));
    }
}