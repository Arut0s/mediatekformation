<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Formation;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationTest
 *
 * @author FENOUILLET Paul
 */
class FormationTest extends TestCase{
    public function testGetDateparutionString(){
        $formation = new Formation();
        $formation->setPublishedAt(new DateTime("2024-03-11"));
        $this->assertEquals("11/03/2024", $formation->getPublishedAtString());
    }
}
