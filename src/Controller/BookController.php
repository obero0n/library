<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Repository\BookRepository;
use App\Form\BookType;
use App\Form\SortByType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    /**
     * @Route("/index", name="book_index", methods={"GET","POST"})
     * @Route("/")
    */
    public function home(BookRepository $bookRepository, Request $request): Response
    {

        $form = $this->createForm(SortByType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $categorySearch = $form->getData();
          $books = $bookRepository->getBookWithCategory($categorySearch['categoryName']);
        }
        else {
          $books = $bookRepository->findAll();
        }
        return $this->render('book/index.html.twig', [
            'book' => $books,
            'form' => $form->createView()
]);
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

           return $this->redirectToRoute('book_index');
       }

       return $this->render('book/addbook.html.twig', [
           'book' => $book,
           'form' => $form->createView(),

       ]);
   }
}
