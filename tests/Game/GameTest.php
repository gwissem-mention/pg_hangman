<?php
/**
 * Created by PhpStorm.
 * User: wissem.garouachi
 * Date: 28/03/2018
 * Time: 09:33
 */

namespace App\Test\Game;


use App\Game\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{

    /**
     * @dataProvider provideTryLetter
     */
    public function testTryLetter($word, $attempts, $triedLetters, $foundLetters, $letter, $expected)
    {
        $game = new Game($word, $attempts, $triedLetters, $foundLetters);

        $this->assertEquals($expected, $game->tryLetter($letter));
    }

    public function provideTryLetter()
    {
        return [
            /* Nominal Case : Play a new letter that exists in the word */
            [
                'myword',
                11,
                [],
                [],
                'w',
                true,
            ],
            /* Play a new capital letter that exists in the word */
            [
                'myword',
                11,
                [],
                [],
                'W',
                true,
            ],
            /* Play an already played letter */
            [
                'myword',
                11,
                ['w'],
                [],
                'w',
                false,
            ],
            /* Play new letter that doesn't exist in the word */
            [
                'myword',
                11,
                [],
                [],
                'z',
                false,
            ],
        ];
    }
}