<?php

namespace App\Controller;

use App\Entity\User;
use Cassandra\Type\UserType;
use HttpHeaderException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/signup", name="signup", methods={"POST", "GET"})
     * @param Request $request
     * @return string
     * @throws HttpHeaderException
     */
    public function signup(Request $request): string
    {
        $request->request->get('username');
        $user = $this->getDoctrine()
            ->getRepository(\Symfony\Component\Security\Core\User\User::class)
            ->findOneBy(['username' => $request]);


        if (!$user){
            $userNew = new User($request->getUser(), $request->getPassword());

            //add to DB
            $this->getDoctrine()->getManager()->flush();
            return new Response(null,201);
        }
        throw new HttpHeaderException("user not created");

//        $user = new User();
//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityUser = $this->getDoctrine()->getManager();
//            $entityUser->persist($user);
//            $entityUser->flush();
//
//            return "ff";
////            return $this->json([], 201);
//        }
//
//        //реализовать: при не прохождении валидации вывести json file
//        return "Test";
    }
}
