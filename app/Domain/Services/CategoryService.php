<?php

namespace App\Domain\Services;

require_once __DIR__ . '/../../Repositories/CategoryRepository.php';


use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

    public function getCategory($id)
    {
        $category = $this->categoryRepository->findById($id);
        return $category;
    }

    public function getCategories()
    {
        $category = $this->categoryRepository->findAll();
        return $category;
    }
}
