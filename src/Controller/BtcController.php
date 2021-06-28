<?php

namespace App\Controller;

use App\Service\Btc;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BtcController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    /**
     * @Route("/btcRate", name="btc", methods={"GET"})
     */
    public function btcRate(): Response
    {
        $session = $this->requestStack->getSession();
        $btc = new Btc();
        $btc_rate = $btc->getBtcRate();
        if ($btc_rate && $session->get('user_logged')){
            return $this->json([
                'btcRate' => $btc_rate,
            ]);
        }
        return $this->json([
            'message' => 'Sorry, but you can`t see btcRate',
        ]);
    }
}
