<?php
/**
 * Created by PhpStorm.
 * User: zeynelabidin
 * Date: 14.09.2017
 * Time: 14:07
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Blog;
use AppBundle\Form\BlogFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @Route("/blog/{name}")
     * @return Response
     */
    public function showAction()
    {
        $blogs = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        return $this->render('blog/show.html.twig', array(
            'blogs' => $blogs
        ));

    }
/*
    public function newAction()
    {
        $form = $this->createForm(BlogFormType::class);
        return $this->render('admin/blog/new.html.twig', [
            'blogFrom' => $form->createView()
        ]);
    }*/
}