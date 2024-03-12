<?php


namespace App\Tests\Validations;

use App\Entity\Formation;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of FormationValidationsTest
 *
 * @author FENOUILLET Paul
 */
class FormationValidationsTest extends KernelTestCase{
    public function getFormation() : Formation
    {
        return (new Formation())
                ->setTitle("Programmation Python")
                ->setVideoId("BLPIdhAHQmQ");
    }
    
    public function testValidDateFormation(){
        $this->assertErrors($this->getFormation()->setPublishedAt(new DateTime("2024-03-11")),0,"Antérieure à la date du jour, devrait réussir");
        $this->assertErrors($this->getFormation()->setPublishedAt(new DateTime("today")),0,"Égale à la date du jour, devrait réussir");
        $this->assertErrors($this->getFormation()->setPublishedAt(new DateTime("2200-03-11")),1,"Postérieure à la date du jour, devrait échouer");
    }
    
    public function assertErrors(Formation $formation, int $nbErreursAttendues, string $message){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($formation);
        $this->assertCount($nbErreursAttendues,$error, $message);
    }
}
