<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tag')]
class TagController extends AbstractController
{
    #[Route('/{slug}', name: 'app_tag')]
    public function index(PostRepository $postRepo, Request $request,Tag $tag ): Response
    {
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchData->page = $request->query->getInt('page', 1);
            $posts = $postRepository->findBySearch($searchData);
    
            return $this->render('post/index.html.twig', [
                'form' => $form->createView(),
                'posts' => $posts,
                'tag' => $tag,
            ]);
        }
          
            $page = $request->query->getInt('page', 1);
            $post = $postRepo->findPublished($page, null, $tag);
    

        return $this->render('tag/index.html.twig', [
            'tag' => $tag,
            'posts' => $post,
            'form' => $form->createView(),
        ]);
    }
}
