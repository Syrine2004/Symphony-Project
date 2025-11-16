<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface; 
use App\Entity\Article; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Routing\Attribute\Route; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class IndexController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();
        
        return $this->render('articles/index.html.twig', [
            'articles' => $articles
        ]);
    }
    


    #[Route('/article/new', name: 'new_article', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        
        $form = $this->createFormBuilder($article)
            ->add('nom', TextType::class)
            ->add('prix', NumberType::class) 
            ->add('save', SubmitType::class, [
                'label' => 'Créer'
            ])
            ->getForm();

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

    #[Route('/article/{id}', name: 'show')]
    public function show(Article $article): Response 
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article
        ]);
    }
    
    #[Route('/article/edit/{id}', name: 'edit_article', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response 
    {
        $form = $this->createFormBuilder($article)
            ->add('nom', TextType::class)
            ->add('prix', NumberType::class) 
            ->add('save', SubmitType::class, [
                'label' => 'Modifier'
            ])->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('articles/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/article/delete/{id}', name: 'delete_article', methods: ['GET','DELETE', 'POST'])]
    public function delete(EntityManagerInterface $entityManager, $id) {
        $article = $entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('home');
    }
}