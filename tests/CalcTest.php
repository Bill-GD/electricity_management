<?php

namespace ElecManagement;

use PHPUnit\Framework\TestCase;

// use dirname() because phpunit is shit with parent dir (..)
require_once dirname(__DIR__) . "\helper\helper_methods.php";

class CalcTest extends TestCase {
  public function testCalc(): void {
    $this->assertEquals(-1, getElectricityCost(-133)[1]);
    $this->assertEquals(0, getElectricityCost(0)[1]);
    $this->assertEquals(62757, getElectricityCost(34)[1]);
    $this->assertEquals(92290, getElectricityCost(50)[1]);
    $this->assertEquals(132345, getElectricityCost(71)[1]);
    $this->assertEquals(320584, getElectricityCost(160)[1]);
    $this->assertEquals(495678, getElectricityCost(231)[1]);
    $this->assertEquals(694395, getElectricityCost(302)[1]);
    $this->assertEquals(1234938, getElectricityCost(473)[1]);
    $this->assertEquals(1321870, getElectricityCost(500)[1]);
  }
}