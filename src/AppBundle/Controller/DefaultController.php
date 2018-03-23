<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Form\CommentType;
use AppBundle\Form\NewPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    //const LIMIT_POSTS = 3;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->get('doctrine')->getManager()->getRepository('AppBundle:Post');

        $posts = $repository->findBy(
            ['status' => true],
            ['createdAt' => 'DESC'],
            $this->getParameter('limit_posts')
        );

        return $this->render('default/list.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/category/{category}", requirements = { "category": "\d+" }, name = "show_category")
     */
    public function showCategoryAction(Category $category)
    {
        return $this->render('default/category.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/hello/{name}")
     */
    public function helloAction($name)
    {
        return $this->render('default/hello.html.twig', [
            'name' => $name,
        ]);
    }

    /**
     * @Route("/post/list")
     */
    public function listPostsAction()
    {
        $repository = $this->get('doctrine')->getManager()->getRepository('AppBundle:Post');
        $posts = $repository->findAll();

        //$repository->findBy()

        return $this->render('default/list.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post/show/{post}", requirements = { "post": "\d+" }, name = "show_post")
     */
    public function showPostAction(Request $request, Post $post)
    {
        $comment = new Comment($post);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $comment = $form->getData();

            $em = $this->get('doctrine')->getManager();
            $em->persist($comment);
            $em->flush();
        }

        return $this->render('default/post.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/new")
     */
    public function newPostAction(Request $request)
    {
        $post = new Post();
        $post->setCreatedAt(new \DateTime());
        $post->setUpdatedAt(new \DateTime());

        $form = $this->createForm(NewPostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();

            $em = $this->get('doctrine')->getManager();
            $em->persist($post);
            $em->flush();

            $this->redirectToRoute('homepage');
        }

        return $this->render('default/new.html.twig', [
            'postForm' => $form->createView(),
        ]);
    }
}
