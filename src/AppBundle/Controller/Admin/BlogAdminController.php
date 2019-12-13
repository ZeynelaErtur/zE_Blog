<?php
/**
 * Created by PhpStorm.
 * User: zeynelabidin
 * Date: 14.09.2017
 * Time: 14:07
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Blog;
use AppBundle\Form\BlogFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class BlogAdminController extends Controller
{
    /**
     * @Route("/admin/blog/list", name="admin_blog_list")
     */

    public function listAction()
    {
        $blogs = $this->getDoctrine()
            ->getRepository('AppBundle:Blog')
            ->findAll();

        return $this->render('admin/blog/list.html.twig', array(
            'blogs' => $blogs
        ));
    }

    /**
     * @Route("/admin/blog/new", name="admin_blog_new")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(BlogFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $blog = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash('success',"You are awesome :)");

            return $this->redirectToRoute('admin_blog_list');
        }

        return $this->render('admin/blog/new.html.twig', [
            'blogForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/blog/{id}/edit", name="admin_blog_edit")
     * @param Request $request
     * @param Blog $blog
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Blog $blog)
    {
        $form = $this->createForm(BlogFormType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $blog = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash('success',"You are awesome :)");

            return $this->redirectToRoute('admin_blog_list');
        }

        return $this->render('admin/blog/edit.html.twig', [
            'blogForm' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/blog/delete/{id}", name="admin_blog_delete")
     * @param Blog $blog
     * @return JsonResponse
     * @internal param Request $request
     */

    public function deleteAction(Blog $blog)
    {
        $em = $this->getDoctrine()->getManager();
        $entryTitle = $blog->getTitle();

        try
        {
            $em->remove($blog);
            $em->flush();
            $response = [
                "success" => true,
                "message" => "'".$entryTitle."' titled entity removed. aaafferin hıhh çok güzel oldu affferin..."
            ];
        }catch (Exception $e)
        {
            $response = [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }

        return JsonResponse::create($response);
    }
}