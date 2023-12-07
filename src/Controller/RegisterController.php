<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\UtilsService;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class RegisterController extends AbstractController
{
    private $em;
    private $serializer;
    private $repo;
    private $hash;
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, UserRepository $repo, UserPasswordHasherInterface $hash)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->repo = $repo;
        $this->hash = $hash;
    }
    #[Route('/user/add', name: 'app_register_add',methods:'POST')]
    public function addUser(Request $request): Response
    {
        $message = "";
        $code = 200;
        $json = $request->getContent();
        if ($json) {
            $data = $this->serializer->decode($json, 'json');
            if (empty($data["name"]) or empty($data['firstname']) or empty($data["email"]) or empty($data["password"])) {
                $message = ["error" => "Veuillez remplir tous les champs"];
                $code = 400;
            }
            //test le compte existe déja
            else if ($this->repo->findOneBy(["email" => $data["email"]])) {
                $message = ["error" => "le compte existe déja"];
                $code = 400;
            } else {
                $user = new User();
                $user->setName(UtilsService::cleanInput($data["name"]));
                $user->setFirstname(UtilsService::cleanInput($data["firstname"]));
                $user->setEmail(UtilsService::cleanInput($data["email"]));
                $pass = UtilsService::cleanInput($data["password"]);
                $hash = $this->hash->hashPassword($user, $pass);
                $user->setPassword($hash);
                $user->setActivate(true);
                $user->setRoles(["ROLE_USER"]);
                $user->setToken(md5($user->getEmail() . "2023"));
                $this->em->persist($user);
                $this->em->flush();
                $message = ["error" => "le compte : " . $user->getEmail() . " a ete ajoute en BDD"];
            }
        } else {
            $message = ["error" => "Json Invalide"];
            $code = 200;
        }
        return $this->json($message, $code, [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
    #[Route('/user/add2', name: 'app_register_add',methods:'POST')]
    public function addUser2(Request $request, SluggerInterface $slug): Response
    {
        $message = "";
        $code = 200;
        //recupération de la requête POST
        $data = $request;
        //récupération des informations utilisateur
        $infoUser = $data->request->all();
        //récupération du fichier
        $img = $data->files->get('img_user');
        //test si les champs sont remplis
        if (empty($infoUser["name_user"]) or empty($infoUser["firstname_user"]) 
        or empty($infoUser["email_user"]) or empty($infoUser["password_user"])) {
            $message = ["error" => "Veuillez remplir tous les champs"];
            $code = 400;
        }
        //test le compte existe déja
        else if ($this->repo->findOneBy(["email" => $infoUser["email_user"]])) {
            $message = ["error" => "le compte existe déja"];
            $code = 400;
        } 
        //enregistrement du compte
        else {
            $user = new User();
            $user->setName(UtilsService::cleanInput($infoUser["name_user"]));
            $user->setFirstname(UtilsService::cleanInput($infoUser["firstname_user"]));
            $user->setEmail(UtilsService::cleanInput($infoUser["email_user"]));
            $pass = UtilsService::cleanInput($infoUser["password_user"]);
            $hash = $this->hash->hashPassword($user, $pass);
            $user->setPassword($hash);
            $user->setActivate(true);
            $user->setRoles(["ROLE_USER"]);
            $user->setToken(md5($user->getEmail() . "2023"));
            //test si l'image n'est pas importée 
            if($img===null){
                $user->setImgUsers("default.png");
            }
            //test l'image existe
            else{
                //récupération des informations du fichier
                $imgInfo = pathinfo($img->getClientOriginalName());
                //safe imgFileName
                $safeFilename = $slug->slug($imgInfo["basename"]);
                //set des informations de l'utilisateur
                $user->setImgUsers($imgInfo["basename"]);
                //déplacement de l'image dans /public/uploads
                try {
                    $img->move(
                        $this->getParameter('upload_directory'),
                        $imgInfo["basename"]
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            //sauvegarde en BDD du compte
            $this->em->persist($user);
            $this->em->flush();
            $message = ["error" => "le compte : " . $user->getEmail() . " a ete ajoute en BDD"];
        }
        return $this->json($message, $code, [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    #[Route('user/token', name: 'app_register_token',methods:'POST')]
    public function getToken(Request $request): Response
    {
        $message = "";
        $code = 200;
        $groupe = "";
        $json = $request->getContent();
        //test json valide
        if ($json) {
            $data = $this->serializer->decode($json, 'json');
            $recup = $this->repo->findOneBy(["email" => $data["email"]]);
            //test compte existe
            if ($recup) {
                //test password valide
                if ($this->hash->isPasswordValid($recup, $data["password"])) {
                    $message = $recup;
                    $groupe = ['groups' => 'user'];
                }
                //test password invalide
                else {
                    $message = ["error" => "Informations de connexion invalides"];
                    $code = 400;
                    $groupe = [];
                }
            }
            //test compte n'existe pas
            else {
                $message = $message = ["error" => "Informations de connexion invalides"];
                $code = 400;
                $groupe = [];
            }
        }
        //test json invalide
        else {
            $message = ["error" => "Json Invalide"];
            $code = 400;
            $groupe = [];
        }
        return $this->json($message, $code, [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ],$groupe);
    }
    #[Route('/user/id/{id}', name: 'app_register_id',methods:'GET')]
    public function getUserById($id): Response
    {
        $message = "";
        $code = 200;
        $groupe = "";
        $user = $this->repo->find(UtilsService::cleanInput($id));
        if ($user) {
            $message = $user;
            $groupe = ['groups' => 'user'];
        } else {
            $message = ["error" => "Le compte n'existe pas"];
            $code = 400;
            $groupe = [];
        }
        return $this->json($message, $code, [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ], $groupe);
    }
    #[Route('/user/all', name: 'app_register_all',methods:'GET')]
    public function getUserAll(): Response
    {
        $message = "";
        $code = 200;
        $groupe = "";
        $users = $this->repo->findAll();
        if ($users) {
            $message = $users;
            $groupe = ['groups' => 'user'];
        } else {
            $message = ["error" => "Il n'y a pas d'utilisateurs en BDD"];
            $code = 400;
            $groupe = [];
        }
        return $this->json($message, $code, [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ], $groupe);
    }
    #[Route('/user/update', name: 'app_register_update',methods:'POST')]
    public function updateUser(Request $request): Response
    {
        $message = "";
        $code = 200;
        $json = $request->getContent();
        if ($json) {
            $data = $this->serializer->decode($json, 'json');
            $user = $this->repo->findOneBy(["token" => $data["token"]]);
            if ($user) {
                $user->setName(UtilsService::cleanInput($data["name"]));
                $user->setFirstname(UtilsService::cleanInput($data["firstname"]));
                $user->setEmail(UtilsService::cleanInput($data["email"]));
                $this->em->persist($user);
                $this->em->flush();
                $message = ["error" => "Le compte : " . $user->getEmail() . " a ete mis a jour"];
            } else {
                $message = ["error" => "Le compte n'existe pas"];
                $code = 400;
            }
        } else {
            $message = ["error" => "Json Invalide"];
            $code = 400;
        }
        return $this->json($message, $code, [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
}
