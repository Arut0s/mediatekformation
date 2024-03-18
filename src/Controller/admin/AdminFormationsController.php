<?php

namespace App\Controller\admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of AdminFormationsController
 *
 * @author FENOUILLET Paul
 */
class AdminFormationsController extends AbstractController{
   /**
     *
     * @var FormationRepository
     */
    private $formationRepository;
    /**
     *
     * @var CategorieRepository
     */
    private $categorieRepository;

    /**
     * @Route("/admin", name="admin.formations")
     * @return Response
     */
    public function index(): Response {
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.formations.html.twig", [
                    'formations' => $formations,
                    'categories' => $categories
        ]);
    }
    
    
    /**
     * @Route("/admin/formation/suppr/{id}", name="admin.formation.suppr")
     * @param int $id
     * @return Response
     */
    public function suppr(int $id): Response {
        $formation = $this->formationRepository->find($id);
        $this->formationRepository->remove($formation, true);
        return $this->redirectToRoute('admin.formations');
    }
    
      /**
     * @Route("/admin/formation/edit/{id}", name="admin.formation.edit")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function edit(int $id, Request $request): Response {
        $formation = $this->formationRepository->find($id);
        $formFormation = $this->createForm(FormationType::class, $formation);

        $formFormation->handleRequest($request);
        if ($formFormation->isSubmitted() && $formFormation->isValid()) {
            $this->formationRepository->add($formation, true);
            return $this->redirectToRoute('admin.formations');
        }
        return $this->render("admin/admin.formation.edit.html.twig", [
                    'formation' => $formation,
                    'formformation' => $formFormation->createView()
        ]);
    }
    
     /**
     * @Route("/admin/formation/ajout", name="admin.formation.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response {
        $formation = new Formation();
        $formFormation = $this->createForm(FormationType::class, $formation);

        $formFormation->handleRequest($request);
        if ($formFormation->isSubmitted() && $formFormation->isValid()) {
            $this->formationRepository->add($formation, true);
            return $this->redirectToRoute('admin.formations');
        }
        return $this->render("admin/admin.formation.ajout.html.twig", [
                    'formation' => $formation,
                    'formformation' => $formFormation->createView()
        ]);
    }
    
     /**
     * @Route("admin/formations/tri/{champ}/{ordre}/{table}", name="admin.formations.sort")
     * @param type $champ
     * @param type $ordre
     * @param type $table
     * @return Response
     */
    public function sort($champ, $ordre, $table = ""): Response
    {
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.formations.html.twig", [
                    'formations' => $formations,
                    'categories' => $categories
        ]);
    }
    
     /**
     * @Route("admin/formations/recherche/{champ}/{table}", name="admin.formations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table = ""): Response
    {
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.formations.html.twig", [
                    'formations' => $formations,
                    'categories' => $categories,
                    'valeur' => $valeur,
                    'table' => $table
        ]);
    }
    

     public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository)
    {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
    }

}
