<?php

namespace App\Controller;

use App\Entity\Posters;
use App\Entity\User;
use App\Form\CommentsType;
use App\Entity\Comments;
use App\Form\PostersType;
use App\Repository\PostersRepository;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/posters")
 */
class PostersController extends AbstractController
{
    /**
     * @Route("/", name="posters_index", methods={"GET"})
     */
    public function index(PostersRepository $postersRepository): Response
    {
        return $this->render('posters/index.html.twig', [
            'posters' => $postersRepository->findByPost(),
        ]);
    }

    /**
     * @Route("/new", name="posters_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }
        $poster = new Posters();
        $form = $this->createForm(PostersType::class, $poster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user = $this->getUser();
            $poster->setuser($user);
            $poster->setCountView();
            $poster->setDatePost();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($poster);
            $entityManager->flush();
            return $this->redirect('/posters/' . $poster->getId());
        }

        return $this->render('posters/new.html.twig', [
            'poster' => $poster,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="posters_show", methods={"GET","POST"})
     */
    public function show(Posters $poster, Request $request): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($this->getUser()) {
            if ($this->getUser()->getId() != $poster->getuser()->getId()) {
                $poster->NumCountView(1);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($poster);
                $entityManager->flush();
            }
        }

        $comments = $this->getDoctrine()
            ->getRepository(Comments::class)
            ->findByIdPost($poster);

        if ($form->isSubmitted('submitProduct') && $form->isValid()) {
            if ($this->getUser() == null) {
                return $this->redirectToRoute('app_login');
            }

            if ($this->getUser()->getId() != $poster->getuser()->getId()) {
                $poster->NumCountView(-2);#для того чтобы при добавлении комментария не прибавлялся просмотр
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($poster);
                $entityManager->flush();
            }

            $user = new User();
            $user = $this->getUser();
            $comment->setUserComments($user);
            $comment->setDateComment();
            $comment->setPoster($poster);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirect('/posters/' . $poster->getId());
        }

        return $this->render('posters/show.html.twig', [
            'Form' => $form->createView(),
            'poster' => $poster,
            'comment' => $comments,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="posters_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Posters $poster): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }

        $comment = new Comments();
        $formComment = $this->createForm(CommentsType::class, $comment);
        $form = $this->createForm(PostersType::class, $poster);
        $form->handleRequest($request);

        $comments = $this->getDoctrine()
            ->getRepository(Comments::class)
            ->findByIdPost($poster);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect('/posters/' . $poster->getId());
        }

        return $this->render('posters/edit.html.twig', [
            'Form' => $form->createView(),
            'comment' => $comments,
            'poster' => $poster,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="posters_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Posters $poster): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->isCsrfTokenValid('delete' . $poster->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($poster);
            $entityManager->flush();
        }

        return $this->redirectToRoute('posters_index');
    }
}
