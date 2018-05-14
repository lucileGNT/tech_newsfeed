<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $threads = $this->getDoctrine()
            ->getRepository('AppBundle:Thread')
            ->findBy([],['score' => 'DESC']);

        // replace this example code with whatever you need
        return $this->render('list.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'threads' => $threads
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
     * @Route("/thread/{id}/vote", name="vote")
     */
    public function voteForThreadAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'UPDATE AppBundle:Thread t
              SET t.score = t.score + 1
              WHERE t.id = :thread_id'
        )
        ->setParameter('thread_id', $id);

        $result = $query->execute();

        return $this->redirectToRoute('homepage');


    }
}
