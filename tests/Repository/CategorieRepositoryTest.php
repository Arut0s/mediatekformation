<?php


namespace App\Tests\Repository;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of CategorieRepositoryTest
 *
 * @author FENOUILLET Paul
 */
class CategorieRepositoryTest extends KernelTestCase{
    public function recupRepository(): CategorieRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    public function newCategorie() : Categorie
    {
        return (new Categorie());
    }
    
    public function testRemoveCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie,true);
        $nbCategories = $repository->count([]);
        $repository->remove($categorie,true);
        $this->assertEquals($nbCategories-1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testAddCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $categorie->setName("TEST");
        $nbCategories = $repository->count([]);
        $repository->add($categorie,true);
        $this->assertEquals($nbCategories+1, $repository->count([]), "erreur lors de l'ajout");
        
        $categorieExistante = $this->newCategorie();
        $categorieExistante->setName("Java");
        $this->assertEquals($nbCategories+1, $repository->count([]), "erreur, la catégorie ne devrait pas être ajouter");
        
    }
        
        public function testNbCatégorie(){
            $repository = $this->recupRepository();
            $nbCategories = $repository->count([]);
            $this->assertEquals(2,$nbCategories);
        }
}
