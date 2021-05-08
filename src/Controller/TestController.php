<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/ical', name: 'test')]
    public function index(): Response
    {
        $calendarComponent = 'abcdefg';
        
        $response = new Response($calendarComponent);

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'cal.ics'
        );

        $response->headers->set('Content-Type', 'text/calendar');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
