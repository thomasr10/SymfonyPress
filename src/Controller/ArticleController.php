<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArticleType;
use Symfony\Component\String\Slugger\AsciiSlugger;
use App\Repository\UserRepository;

final class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'app_article_show')]
    public function showArticleBySlug(string $slug, ArticleRepository $articleRepository, UserRepository $userRepository): Response
    {
        $article = $articleRepository->findArticleBySlug($slug);
        $user = $userRepository->findOneById($article->getUser());

        return $this->render('/pages/article/index.html.twig', [
            'article' => $article,
            'user_mail' => $user->getEmail(),
            'user_id' => $user->getId()
        ]);
    }

    #[Route('/article/user/{id}', name: 'app_article_user')]
    #[IsGranted('ROLE_USER')]
    public function showUserArticle(int $id, ArticleRepository $articleRepository): Response
    {
        $user = $this->getUser();
        $articles = $articleRepository->findAllByUser($user);

        return $this->render('/pages/article/article-user.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/add/article', name: 'app_add_article')]
    #[IsGranted('ROLE_USER')]
    public function addArticle(EntityManagerInterface $em, Request $request): Response
    {    
    
        $user = $this->getUser();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article->setUser($user);
            $article->setCreatedAt(new \DateTimeImmutable());
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($form->get('title')->getData())->lower();
            $article->setSlug($slug);

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_article_user', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('/pages/article/add-article.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/article/delete/{id}', name: 'app_delete_article', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function deleteArticle(Article $article, EntityManagerInterface $em): Response
    {   
        $user = $this->getUser();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('app_article_user', [ 
            'id' => $user->getId()
        ]);
    }

    #[Route('/article/update/{id}', name: 'app_update_article', methods:['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function updateArticle(Article $article, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($form->get('title')->getData())->lower();
            $article->setSlug($slug);

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_article_user', [
                'id' => $user->getId()
            ]);
        }            

        return $this->render('/pages/article/update-article.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }
}
