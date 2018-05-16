<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Thread;
use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ThreadController extends Controller
{
    /**
     * @Route("/getThreads", name="get_threads")
     */
    public function getThreadsAction(Request $request)
    {
        $orderBy = $request->request->get('orderBy') !== "" ? $request->request->get('orderBy') : 'score';
        $way = $request->request->get('way') !== "" ? $request->request->get('way') : 'DESC';

        $threads = $this->getDoctrine()
            ->getRepository('AppBundle:Thread')
            ->findBy([],[$orderBy => $way]);

        $threadArray = [];
        $i = 0;
        foreach($threads as $thread) {

            $threadArray[$i]['index'] = $i+1;
            $threadArray[$i]['title'] = $thread->getTitle();
            $threadArray[$i]['added_by'] = $thread->getAddedBy();
            $threadArray[$i]['link'] = $thread->getLink();
            $threadArray[$i]['date'] = $thread->getDate()->format('Y-m-d');
            $threadArray[$i]['score'] = $thread->getScore();
            $threadArray[$i]['vote'] = 'vote_'.$thread->getId();
            $threadArray[$i]['nb_comments'] = $thread->getComments()->count();
            $threadArray[$i]['thread_link'] = $this->generateUrl('thread', array('id' => $thread->getId()));
            $i++;
        }

        $response = new Response();
        $threadsJSON = json_encode(array('threads' => $threadArray));

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($threadsJSON);

        return $response;

    }

    /**
     * @Route("/vote", name="vote")
     */
    public function voteForThreadAction(Request $request)
    {

        $id = $request->request->get('id') !== "" ? $request->request->get('id') : null;

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'UPDATE AppBundle:Thread t
              SET t.score = t.score + 1
              WHERE t.id = :thread_id'
        )
            ->setParameter('thread_id', $id);

        $result = $query->execute();



        $response = new Response();
        $resultJSON = json_encode(array('result' => $result));

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($resultJSON);

        return $response;
    }
}