<?php

namespace App\Controller;

use App\Repository\AddRepository;
use App\Entity\Add;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UtilsService;
class AddController extends AbstractController
{
    private $em;
    private $serializer;
    private $repo;
    private $user;

    public function __construct(EntityManagerInterface $em,
    SerializerInterface $serializerInterface,AddRepository $addRepository,
    UserRepository $userRepository){
        $this->em = $em;
        $this->serializer = $serializerInterface;
        $this->repo = $addRepository;
        $this->user = $userRepository;
    }

    #[Route('/add/add', name:'app_add_add')]
    public function createAdd(Request $request):Response{
        return $this->json([],200,[]);
    }
}
