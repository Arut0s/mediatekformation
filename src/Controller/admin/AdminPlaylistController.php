<?php

namespace App\Controller\admin;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * Description of AdminPlaylistController
 *
 * @author FENOUILLET Paul
 */
class AdminPlaylistController extends AbstractController{
    
     public function __construct(PlaylistRepository $playlistRepository,
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository)
    {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }
    
     /**
     * @Route("admin/playlists", name="admin.playlists")
     * @return Response
     */
    public function index(): Response
    {
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.playlists.html.twig", [
                    'playlists' => $playlists,
                    'categories' => $categories
        ]);
    }
    
     /**
     * @Route("/admin/playlist/suppr/{id}", name="admin.playlist.suppr")
     * @param int $id
     * @return Response
     */
    public function suppr(int $id): Response {
        $playlist = $this->playlistRepository->find($id);
        $this->playlistRepository->remove($playlist, true);
        return $this->redirectToRoute('admin.playlists');
    }
    
     /**
     * @Route("/admin/playlist/edit/{id}", name="admin.playlist.edit")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function edit(int $id, Request $request): Response {
        $playlist = $this->playlistRepository->find($id);
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);

        $formPlaylist->handleRequest($request);
        if ($formPlaylist->isSubmitted() && $formPlaylist->isValid()) {
            $this->playlistRepository->add($playlist, true);
            return $this->redirectToRoute('admin.playlists');
        }
        return $this->render("admin/admin.playlist.edit.html.twig", [
                    'playlist' => $playlist,
                    'formplaylist' => $formPlaylist->createView()
        ]);
    }
    
     /**
     * @Route("/admin/playlist/ajout", name="admin.playlist.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response {
        $playlist = new Playlist();
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);

        $formPlaylist->handleRequest($request);
        if ($formPlaylist->isSubmitted() && $formPlaylist->isValid()) {
            $this->playlistRepository->add($playlist, true);
            return $this->redirectToRoute('admin.playlists');
        }
        return $this->render("admin/admin.playlist.ajout.html.twig", [
                    'playlist' => $playlist,
                    'formplaylist' => $formPlaylist->createView()
        ]);
    }
}
