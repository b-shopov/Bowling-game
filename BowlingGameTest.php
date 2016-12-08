# BowlingGameTest.php

<?php
require_once 'BowlingGame.php';

class BowlingGameTest extends PHPUnit_Framework_TestCase {

    protected $game;

    public function setUp() {

        $this->game = new BowlingGame;
    }

    protected function rollMany($n, $pins) {

        for ($i = 0; $i < $n; $i++) {

            $this->game->roll($pins);
        }
    }

    public function rollSpare() {
        $this->game->roll(5);
        $this->game->roll(5);
    }

    protected function rollStrike() {
        $this->game->roll(10);

    }

    public function testScoreForGutterGame() {

        $this->rollMany(20, 0);

        $this->assertEquals(0, $this->game->score());
    }

    public function testScoreForAllOnes() {

        $this->rollMany(20, 1);

        $this->assertEquals(20, $this->game->score());
    }

    public function testScoreForOneSpare() {

        $this->rollSpare();
        $this->game->roll(3);

        // verifying that this roll is only counted once
        //and is not included in the spare bonus
        $this->game->roll(2);
        $this->rollMany(16, 0);
        $this->assertEquals(18, $this->game->score());
    }

    public function testScoreForOneStrike() {
        $this->rollStrike();
        $this->game->roll(3);
        $this->game->roll(4);
        $this->rollMany(17, 0);
        $this->assertEquals(24, $this->game->score());
    }

    public function testScoreForPerfectGame()
    {
        $this->rollMany(12, 10);
        $this->assertEquals(300, $this->game->score());
    }

    public function testScoreForSpareInLastFrame()
    {
        $this->rollMany(18, 0);
        $this->rollSpare();
        $this->game->roll(7);
        $this->assertEquals(17, $this->game->score());
    }

    public function testScoreForStrikeInLastFrame()
    {
        $this->rollMany(18, 0);
        $this->rollStrike();
        $this->game->roll(7);
        $this->game->roll(3);
        $this->assertEquals(20, $this->game->score());
    }

}
?>
