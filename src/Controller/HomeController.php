<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function showArticles(CategoryRepository $categoryRepository, ArticleRepository $articleRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $articles = $articleRepository->findAll();

        return $this->render('/pages/home/index.html.twig', [
            'categories' => $categories,
            'articles' => $articles
        ]);
    }
}
