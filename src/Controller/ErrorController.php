<?php

namespace App\Controller;

use App\Service\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error")
     */
    public function error(Throwable $throwable): Response
    {
        $logger = new Logger();
        if ($_ENV{'APP_ENV'} == 'prod') {
            $logger->log(Logger::ERROR, $throwable->getMessage());
        } else {
            $msg = $throwable->getMessage() . "\n"
                . $throwable->getFile() . "\n"
                . $throwable->getTrace() . "\n"
                . $throwable->getCode() . "\n";
            $logger->log(Logger::DEBUG, $msg);
        }
        return $this->json([
            'message' => 'Oops.. some mistakes',
        ]);
    }
}
