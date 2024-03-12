<?php

namespace App\Tests\Repository;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Formation;

/**
 * Description of FormationRepositoryTest
 *
 * @author FENOUILLET Paul
 */
class FormationRepositoryTest extends KernelTestCase{
    public function recupRepository(): FormationRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    public function newFormation() : Formation
    {
        return (new Formation())
                ->setTitle("Programmation Python")
                ->setVideoId("BLPIdhAHQmQ");
    }
    
    public function testRemoveFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation,true);
        $nbFormations = $repository->count([]);
        $repository->remove($formation,true);
        $this->assertEquals($nbFormations-1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testAddFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $nbFormations = $repository->count([]);
        $repository->add($formation,true);
        $this->assertEquals($nbFormations+1, $repository->count([]), "erreur lors de l'ajout");
    }
        
        public function testNbFormations(){
            $repository = $this->recupRepository();
            $nbFormations = $repository->count([]);
            $this->assertEquals(2,$nbFormations);
        }
}
