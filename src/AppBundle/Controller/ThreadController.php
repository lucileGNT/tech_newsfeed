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

        $threads = $this->getDoctrine()
            ->getRepository('AppBundle:Thread')
            ->findBy([],['score' => 'DESC']);

        $threadArray = [];
        $i = 1;
        foreach($threads as $thread) {
            $threadArray[$thread->getId()]['index'] = $i;
            $threadArray[$thread->getId()]['title'] = $thread->getTitle();
            $threadArray[$thread->getId()]['link'] = $thread->getLink();
            $threadArray[$thread->getId()]['date'] = $thread->getDate()->format('Y-m-d');
            $threadArray[$thread->getId()]['score'] = $thread->getScore();
            $threadArray[$thread->getId()]['vote'] = $this->generateUrl('vote', array('id' => $thread->getId()));
            $threadArray[$thread->getId()]['nb_comments'] = $thread->getComments()->count();
            $threadArray[$thread->getId()]['thread_link'] = $this->generateUrl('thread', array('id' => $thread->getId()));
            $i++;
        }

        $response = new Response();
        $threadsJSON = json_encode(array('threads' => $threadArray));

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($threadsJSON);

        return $response;

    }
}