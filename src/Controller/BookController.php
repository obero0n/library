<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Repository\BookRepository;
use App\Form\BookType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    /**
     * @Route("/index", name="book_index")
     * @Route("/")
    */
    public function home()
    {
        $repository = $this->getDoctrine()
              ->getRepository(Book::class)
              ->getBookWithCategory();
        $books = $repository;
        return $this->render("book/index.html.twig", ["book" => $books]);
    }

    /**
     * Matches @Route("/single/{id}", requirements={"id"="\d+"}) exactly
     * @Route("/single/{id}", requirements={"id"="\d+"}, name="single")
    */
    public function single($id)
    {
        $repository = $this->getDoctrine()
              ->getRepository(Book::class)
              ->getOneBookWithCategory($id);
        $book = $repository;

        return $this->render('book/single.html.twig',["book" => $book]);
        return new Response();
    }

    /**
    * @Route("/addbook", name="book_new", methods={"GET","POST"})
    */
   public function new(Request $request): Response
   {
       $book = new Book();
       $form = $this->createForm(BookType::class, $book);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($book);
           $entityManager->flush();

           return $this->redirectToRoute('single');
       }

       return $this->render('book/addbook.html.twig', [
           'book' => $book,
           'form' => $form->createView(),
           'choice_value' => function (MyBookEntity $book = null)
           {
               return $book ? $entity->getCategoryName() : '';
           }
       ]);
   }
}
