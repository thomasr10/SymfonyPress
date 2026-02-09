<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;

final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function show(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('/pages/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{slug}', name: 'app_article_category')]
    public function showArticleByCategory(string $slug, CategoryRepository $categoryRepository, UserRepository $userRepository, ArticleRepository $articleRepository): Response
    {
        $category = $categoryRepository->findOneBySlug($slug);        
        $articles = $articleRepository->findAllByCategory($category);
        

        return $this->render('/pages/category/articles-category.html.twig', [
            'articles' => $articles,
            'category' => $category
        ]);
    }
}
