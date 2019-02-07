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
}
