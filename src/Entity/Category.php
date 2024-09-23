<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Entity;

final class Category
{
    /** @var string */
    private $name;
    /** @var mixed */
    private $id;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Category
    {
        $this->name = $name;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
