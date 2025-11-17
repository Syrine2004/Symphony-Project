<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface; 
use App\Entity\Article; 
use App\Entity\Category;
use App\Entity\PropertySearch;     // <-- (TP7) ASSURE-TOI D'AVOIR ÇA
use App\Form\ArticleType; 
use App\Form\CategoryType;
use App\Form\PropertySearchType;   // <-- (TP7) ASSURE-TOI D'AVOIR ÇA
use App\Entity\CategorySearch;     // <-- (TP7) C'EST LA LIGNE MANQUANTE
use App\Form\CategorySearchType;   // <-- (TP7) ASSURE-TOI D'AVOIR ÇA
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route; 

class IndexController extends AbstractController
{
    // 1. Page d'accueil (avec recherche par NOM)
    #[Route('/', name: 'home')]
    public function home(Request $request, EntityManagerInterface $entityManager): Response
    {
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);

        $articles = $entityManager->getRepository(Article::class)->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getNom();
            if ($nom != "") {
                $articles = $entityManager->getRepository(Article::class)->findBy(['nom' => $nom]);
            }
        }

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView() 
        ]);
    }

    // 2. NOUVELLE PAGE - RECHERCHE PAR CATEGORIE (DOIT ÊTRE AVANT /article/{id})
    #[Route('/article/category', name: 'article_par_cat')]
    public function articlesParCategorie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorySearch = new CategorySearch();
        $form = $this->createForm(CategorySearchType::class, $categorySearch);
        $form->handleRequest($request);

        $articles = []; 

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $categorySearch->getCategory();

            if ($category != null) {
                $articles = $category->getArticles();
            } else {
                $articles = $entityManager->getRepository(Article::class)->findAll();
            }
        }

        return $this->render('articles/articlesParCategorie.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles
        ]);
    }
    
    // 3. CRÉER UN NOUVEL ARTICLE
    #[Route('/article/new', name: 'new_article', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // ... (ton code pour "new" est correct) ...
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('home'); 
        }
        
        return $this->render('articles/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    // 4. CRÉER UNE NOUVELLE CATEGORIE
    #[Route('/category/new', name: 'new_category', methods: ['GET', 'POST'])]
    public function newCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        // ... (ton code pour "newCategory" est correct) ...
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('home'); 
        }

        return $this->render('articles/newCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // 5. AFFICHER UN ARTICLE
    #[Route('/article/{id}', name: 'show')]
    public function show(Article $article): Response 
    {
        // ... (ton code pour "show" est correct) ...
        return $this->render('articles/show.html.twig', [
            'article' => $article
        ]);
    }
    
    // 6. MODIFIER UN ARTICLE
    #[Route('/article/edit/{id}', name: 'edit_article', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response 
    {
        // ... (ton code pour "edit" est correct) ...
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('articles/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // 7. SUPPRIMER UN ARTICLE
    #[Route('/article/delete/{id}', name: 'delete_article', methods: ['GET','DELETE', 'POST'])]
    public function delete(EntityManagerInterface $entityManager, $id) {
        // ... (ton code pour "delete" est correct) ...
        $article = $entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('home');
    }
}