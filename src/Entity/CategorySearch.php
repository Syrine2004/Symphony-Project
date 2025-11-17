<?php
namespace App\Entity;

use App\Entity\Category; // <-- Assure-toi que ce 'use' est là

class CategorySearch
{
    private ?Category $category = null;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }
}