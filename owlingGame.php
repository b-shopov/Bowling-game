# BowlingGame.php

<?php

class BowlingGame {

    private $score;
    private $rolls = array();
    private $currentRoll = 0;

    public function __construct()
    {

    }

    public function roll($pins) {
        $this->rolls[$this->currentRoll++] = $pins;
    }

    public function score() {

        $this->score = 0;
        $frameIndex = 0;
        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($frameIndex)) {
                $this->score = $this->score + 10 + $this->strikeBonus($frameIndex);
                $frameIndex++;
            } else if ($this->isSpare($frameIndex)) { //spare
                $this->score = $this->score + 10 + $this->spareBonus($frameIndex);
                $frameIndex = $frameIndex + 2;
            } else {
                $this->score = $this->score + $this->sumOfBallsInFrame($frameIndex);
                $frameIndex = $frameIndex + 2;
            }
        }

        return $this->score;
    }

    private function isStrike($frameIndex) {
        return $this->rolls[$frameIndex] == 10;
    }

    private function sumOfBallsInFrame($frameIndex) {
        return $this->rolls[$frameIndex] + $this->rolls[$frameIndex + 1];
    }

    private function spareBonus($frameIndex) {
        return $this->rolls[$frameIndex + 2];
    }

    private function strikeBonus($frameIndex) {
        return $this->rolls[$frameIndex + 1] + $this->rolls[$frameIndex + 2];
    }

    private function isSpare($frameIndex) {
        return $this->rolls[$frameIndex] + $this->rolls[$frameIndex + 1] == 10;
    }

}

