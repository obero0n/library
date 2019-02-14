<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Entity\User;
use App\Form\BookType;
use App\Form\SortByType;
use App\Form\BorrowType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* Require ROLE_ADMIN for *every* controller method in this class.
*
* @IsGranted("ROLE_ADMIN")
*/
class BookController extends AbstractController
{

  /**
  * @Route("/listbook", name="book_index", methods={"GET","POST"})
  * @Route("/listbook")
  */

  public function home(BookRepository $bookRepository, Request $request): Response
  {
    $form = $this->createForm(SortByType::class);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid())
    {
      $categorySearch = $form->getData();
      $books = $bookRepository->getBookWithCategory($categorySearch['categoryName']);
    }

    else
    {
      $books = $bookRepository->findAll();
    }

    return $this->render('book/index.html.twig',
    [
      'book' => $books,
      'form' => $form->createView()
    ]);
  }

  /**
  * Matches @Route("/single/{id}", requirements={"id"="\d+"}) exactly
  * @Route("/single/{id}", requirements={"id"="\d+"}, name="book_single")
  */

  public function single($id, Request $request)
  {
    $book = $this->getDoctrine()->getRepository(Book::class)->findBookAndUser($id);
    
    if(!$book)
    {
      throw $this->createNotFoundException("Ce livre n'existe pas");
    }

    $form = $this->createForm(BorrowType::class);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid())
    {
      $data = $form->getData();
      $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["code" => $data["code"]]);
      
      if(!$user)
      {
        $this->addFlash("danger", "Ce code utilisateur n'est pas valide");
      }

      else
      {
        $book->setUser($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($book);
        $entityManager->flush();
        $this->addFlash("success", "Le livre a été emprunté");
      }
    }

    return $this->render('book/single.html.twig',
    [
      'book' => $book,
      'form' => $form->createView()
    ]);
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
    
    return $this->render('book/addbook.html.twig',
    [
      'book' => $book,
      'form' => $form->createView()
    ]);
  }

  /**
  * @Route("back/{id}", name="book_retour")
  */
    public function retour(Book $book)
    {
      if($book->getStatus()) {
        $this->addFlash("danger", "Ce livre n'a jamais été emprunté");
      }
      else {
        $book->setUser(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($book);
        $entityManager->flush();
        $this->addFlash("success", "Le livre a été rendu");
      }
      return $this->redirectToRoute('book_single', ["id" => $book->getId()]);
    }
}