<?php

namespace App\Service;

use App\Repository\MenuRepository;
use App\Entity\Menu;

class MenuService
{
    public function __construct(private MenuRepository $menuRepo)
    {
        
    }

    /**
     * @return Menu[]
     */
    public function findAll(): array
    {
        return $this->menuRepo->findAllForTwig();
    }
}