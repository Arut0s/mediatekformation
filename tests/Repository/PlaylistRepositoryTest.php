<?php

namespace App\Tests\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author FENOUILLET Paul
 */
class PlaylistRepositoryTest extends KernelTestCase{
    public function recupRepository(): PlaylistRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
    
     public function newPlaylist() : Playlist
    {
        return (new Playlist())
                ->setName("Playlist de Test");
    }
    
     public function testRemovePlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist,true);
        $nbPlaylists = $repository->count([]);
        $repository->remove($playlist,true);
        $this->assertEquals($nbPlaylists-1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testAddPlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylists = $repository->count([]);
        $repository->add($playlist,true);
        $this->assertEquals($nbPlaylists+1, $repository->count([]), "erreur lors de l'ajout");
    }
        
        public function testNbPlaylists(){
            $repository = $this->recupRepository();
            $nbPlaylists = $repository->count([]);
            $this->assertEquals(2,$nbPlaylists);
        }
}
