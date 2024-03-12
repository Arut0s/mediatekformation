<?php



namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistsControllerTest
 *
 * @author FENOUILLET Paul
 */
class PlaylistsControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase{
    public function testAccesPage(){
        $client = static::createClient();
        $client->request('GET', '/playlists');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    public function testFiltreFormations(){
        $client = static::createClient();
        $client->request('GET', '/playlists');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Bases de la programmation'
        ]);
        $this->assertCount(1, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Bases de la programmation');
    }
    
}
