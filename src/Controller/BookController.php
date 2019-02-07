<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Repository\BookRepository;
class BookController extends AbstractController
{
    /**
     * @Route("/index", name="book_index")
     * @Route("/")
    */
    public function home()
    {
        // $repository = $this->getDoctrine()->getRepository(Book::class);
        // $books = $repository->findAll();

        $repository = $this->getDoctrine()
              ->getRepository(Book::class)
              ->getBookWithCategory();
        $books = $repository;

          var_dump($books);
        return $this->render("book/index.html.twig", ["book" => $books]);
    }

    /**
     * Matches @Route("/single/{id}", requirements={"id"="\d+"}) exactly
     * @Route("/single/{id}", requirements={"id"="\d+"}, name="single")
    */
    public function single($id)
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);
        $book = $repository->find($id);

        return $this->render('book/single.html.twig',["book" => $book]);
        return new Response();
    }
}
