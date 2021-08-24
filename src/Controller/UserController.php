<?php

namespace App\Controller;

use App\Service\User;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    /**
     * @Route("/user/create", name="user_create", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function create(Request $request): Response
    {
        $request = $this->transformJsonBody($request);
        if (!$request->get('email') || !$request->request->get('password')) {
             return $this->return_json('Bad request params');
        }
        $user = new User();
        if ($user->createUser($request)) {
            return $this->return_json('User has been created successfully');
        } else {
            return $this->return_json('User hasn`t been created');
        }
    }

    /**
     * @Route("/user/login", name="user_login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        $request = $this->transformJsonBody($request);
        if (!$request->get('email') || !$request->request->get('password')) {
            return $this->return_json('Bad request params');
        }
        $user = new User();
        $session = $this->requestStack->getSession();
        if ($user->loginUser($request)) {
            $session->set('user_logged', true);
            return $this->return_json('User has been logged in successfully');
        } else {
            $session->set('user_logged', false);
            return $this->return_json('User hasn`t been logged in');
        }
    }

    private function return_json($message): JsonResponse
    {
        return $this->json([
            'message' => $message
        ]);
    }

    private function transformJsonBody(Request $request): Request
    {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
