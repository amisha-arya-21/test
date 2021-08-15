<?php

namespace Test\Controller\Player;

use Exception;
use Test\Application\Handler\Player\CreatePlayerHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PlayerController
{
    private $createPlayer;

    public function __construct(CreatePlayerHandler $createPlayer)
    {
        $this->createPlayer = $createPlayer;
    }

    public function index(Request $request): JsonResponse
    {
        $playerArray = json_decode($request->getContent(), true);

        try {
            $this->createPlayer->handle(
                [
                    'username' => $playerArray['username'],
                    'email' => $playerArray['email'],
                    'password' => $playerArray['password'],
                    'avatar' => 2
                ]
            );
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage());
        }

        return new JsonResponse('User created');
    }
}
