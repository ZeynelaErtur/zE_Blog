<?php
/**
 * Created by PhpStorm.
 * User: zeynelabidin
 * Date: 14.09.2017
 * Time: 14:07
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Category;
use AppBundle\Form\CategoryFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CategoryAdminController extends Controller
{
    /**
     * @Route("/admin/category/list", name="admin_category_list")
     */

    public function listAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        return $this->render('admin/category/list.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route("/admin/category/new", name="admin_category_new")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(CategoryFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $blog = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash('success',"You are awesome :)");

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('admin/category/new.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/{id}/edit", name="admin_category_edit")
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success',"You are awesome :)");

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('admin/category/edit.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/category/delete/{id}", name="admin_category_delete")
     * @param Category $category
     * @return JsonResponse
     * @internal param Request $request
     */

    public function deleteAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $entryTitle = $category->getName();

        try
        {
            $em->remove($category);
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