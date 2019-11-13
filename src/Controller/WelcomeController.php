<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function welcome(){
        $msg='';
        return $this->render('welcome.html.twig',['msg'=>$msg]);
    }
}