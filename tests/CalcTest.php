<?php

namespace ElecManagement;

use PHPUnit\Framework\TestCase;

// use dirname() because phpunit is shit with parent dir (..)
require_once dirname(__DIR__) . "\src\helper\helper_methods.php";

class CalcTest extends TestCase {
  public function test_minus_133_usage(): void {
    $this->assertEquals(-1, getElectricityCost(-133)[1]);
  }
  public function test_zero_usage(): void {
    $this->assertEquals(0, getElectricityCost(0)[1]);
  }
  public function test_34_usage(): void {
    $this->assertEquals(62757, getElectricityCost(34)[1]);
  }
  public function test_50_usage(): void {
    $this->assertEquals(92290, getElectricityCost(50)[1]);
  }
  public function test_71_usage(): void {
    $this->assertEquals(132345, getElectricityCost(71)[1]);
  }
  public function test_160_usage(): void {
    $this->assertEquals(320584, getElectricityCost(160)[1]);
  }
  public function test_231_usage(): void {
    $this->assertEquals(495678, getElectricityCost(231)[1]);
  }
  public function test_302_usage(): void {
    $this->assertEquals(694395, getElectricityCost(302)[1]);
  }
  public function test_473_usage(): void {
    $this->assertEquals(1234938, getElectricityCost(473)[1]);
  }
  public function test_500_usage(): void {
    $this->assertEquals(1321870, getElectricityCost(500)[1]);
  }
  public function test_526_usage(): void {
    $this->assertEquals(1405582, getElectricityCost(526)[1]);
  }
}