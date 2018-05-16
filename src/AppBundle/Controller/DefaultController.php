<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Thread;
use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ThreadType;
use AppBundle\Form\Type\CommentType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('list.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'orderBy' => 'score',
            'way' => 'desc'
        ]);
    }

    /**
     * @Route("/thread/{id}", name="thread")
     */
    public function showThreadAction($id, Request $request)
    {
        $thread = $this->getDoctrine()
            ->getRepository('AppBundle:Thread')
            ->find($id);

        return $this->render('thread.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'thread' => $thread
        ]);
    }

    /**
     * @Route("/new", name="new_thread")
     */
    public function newThreadAction(Request $request)
    {
        $thread = new Thread();

        $form = $this->createForm(ThreadType::class, $thread);


        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $thread->setDate(new \DateTime());
                $thread->setScore(0);

                $em = $this->getDoctrine()->getManager();
                $em->persist($thread);
                $em->flush();

                return $this->redirect($this->generateUrl('homepage'));
            }
        }

        return $this->render('new.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/thread/{id}/comment", name="add_comment")
     */
    public function addCommentAction($id, Request $request)
    {
        $comment = new Comment();

        $action = $this->generateUrl('add_comment', array('id' => $id));

        $form = $this->createForm(CommentType::class, $comment, array('action' => $action));

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $thread = $this->getDoctrine()
                    ->getRepository('AppBundle:Thread')
                    ->find($id);

                $comment->setDate(new \DateTime());
                $comment->setThread($thread);


                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

            }

            return $this->redirect($this->generateUrl('thread', array('id' => $id)));
        }

        return $this->render('partials/add_comment.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView()
        ]);

    }
}
