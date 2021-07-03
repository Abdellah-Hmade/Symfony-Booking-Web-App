<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Service\PaginationService;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments/{page<\d+>?1}", name="admin_comments_index")
     */
    public function index(PaginationService $pagination,$page)
    {
        $pagination->setEntityClass(Comment::class)
                    ->setPage($page);
        return $this->render('admin/comment/index.html.twig', [
            'pagination' =>$pagination
        ]);
    }

      /**
     * @Route("/admin/comments/{id}/delete",name="admin_comments_delete")
     *
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Comment $comment,EntityManagerInterface $manager){
        
        $manager->remove($comment);
        $manager->flush();
        $this->addFlash('success',"Le Commentaire N° <strong>{$comment->getId()}</strong> a bien été supprimée !");
        return $this->redirectToRoute('admin_comments_index');
    }
}
