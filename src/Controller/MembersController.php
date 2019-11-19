<?php

namespace App\Controller;

use App\Entity\Members;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MembersController extends AbstractController
{

    public $members;

    public function __construct()
    {
        $this->members= new Members();
    }

    /**
     * @Route("/members", name="members")
     */
    public function index()
    {
        $members=$this->getDoctrine()->getRepository(Members::class)->findAll();
        return $this->render('members/index.html.twig', ['members' => $members]);
    }

    /**
     *@Route("/members/new", methods={"POST","GET"}, name="new_member")
     */
    public function new(Request $request){
        $form=$this->createFormBuilder($this->members)
            ->add('name',TextType::class,['required'=>true])
            ->add('level',TextType::class,['required'=>true])
            ->add('submit',SubmitType::class,['attr'=>['class'=>'btn btn-dark m-auto']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $member = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();
            return $this->redirectToRoute('members');
        }
        return $this->render('members/new.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/member/update/{id}", methods={"GET","POST"})
     */
    public function update(Request $request, $id){
        $this->members=$this->getDoctrine()->getRepository(Members::class)->find($id);

        $form=$this->createFormBuilder($this->members)
            ->add('name', TextType::class,['required'=>true])
            ->add('level',TextType::class,['required'=>true])
            ->add('submit',SubmitType::class,['attr'=>['class'=>'btn btn-dark m-auto']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('members');
        }
        return $this->render('members/new.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/member/{id}")
     */
    public function card($id){
        $member=$this->getDoctrine()->getRepository(Members::class)->find($id);

        return $this->render('members/card.html.twig',['member'=>$member]);
    }

    /**
     * @Route("/member/delete/{id}", methods={"DELETE"})
     */
    public function delete($id){

        $member=$this->getDoctrine()->getRepository(Members::class)->find($id);
        $entityManager= $this->getDoctrine()->getManager();
        $entityManager->remove($member);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }
}
