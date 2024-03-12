<?php

namespace App\Controller\admin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminCategoriesController
 *
 * @author FENOUILLET Paul
 */
class AdminCategoriesController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController{
   
    /**
     *
     * @var CategorieRepository
     */
    private $categorieRepository;

    
    /**
     * @Route("/admin/categories", name="admin.categories")
     * @return Response
     */
    public function index(): Response{
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.categories.html.twig", [
            'categories' => $categories
        ]);
    }
    
     /**
     * @Route("/admin/categorie/suppr/{id}", name="admin.categorie.suppr")
     * @param int $id
     * @return Response
     */
    public function suppr(int $id): Response {
        $categorie = $this->categorieRepository->find($id);
        $this->categorieRepository->remove($categorie, true);
        return $this->redirectToRoute('admin.categories');
    }
    
       /**
     * @Route("/admin/categorie/ajout", name="admin.categorie.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response{
        $nomCategorie = $request->get("nom");
        $categorie = new \App\Entity\Categorie;
        $categorie->setName($nomCategorie);
        if($this->categorieRepository->findOneBy(array('name' => $nomCategorie)))
        {
        }
        else
        {  
        $this->categorieRepository->add($categorie, true);
        }
        return $this->redirectToRoute('admin.categories');       
    }        
    
 
      public function __construct(\App\Repository\CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }
}
