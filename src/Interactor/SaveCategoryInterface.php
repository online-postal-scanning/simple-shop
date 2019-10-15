<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\Category;

interface SaveCategoryInterface
{
    public function save(Category $category): bool;
}
