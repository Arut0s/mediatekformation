<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FormationControllerTest
 *
 * @author FENOUILLET Paul
 */
class FormationsControllerTest extends WebTestCase{
    public function testAccesPage(){
        $client = static::createClient();
        $client->request('GET', '/formations');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
      public function testFormationsTriASC() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/title/ASC');
        $this->assertSelectorTextContains('th', 'formation');
        $this->assertCount(5, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Bases de la programmation n°61');
    }
    
    public function testPlaylistsTriASC() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/name/ASC/playlist');
        $this->assertSelectorTextContains('th', 'formation');
        $this->assertCount(5, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', "Bases de la programmation n°61 - événementiel");
    }
    
    public function testFiltreFormations(){
        $client = static::createClient();
        $client->request('GET', '/formations');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Bases de la programmation n°61'
        ]);
        $this->assertCount(1, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Bases de la programmation n°61');
    }
    
}