<?php
declare(strict_types=1);

/**
 * This file is part of the Karusel project.
 *
 * @copyright 2010-2020 АО «Карусель» <webmaster@karusel-tv.ru>
 */

namespace tests\Happyr\DoctrineSpecification;

final class Player
{
    /**
     * @var string
     */
    public $pseudo;

    /**
     * @var string
     */
    public $gender;

    /**
     * @var int|null
     */
    public $points;

    /**
     * @var Game|null
     */
    public $inGame;

    /**
     * @param string    $pseudo
     * @param string    $gender
     * @param int|null  $points
     * @param Game|null $game
     */
    public function __construct(string $pseudo, string $gender, ?int $points, ?Game $game = null)
    {
        $this->pseudo = $pseudo;
        $this->gender = $gender;
        $this->points = $points;
        $this->inGame = $game;
    }
}
