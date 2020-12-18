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
     * @var int
     */
    public $points;

    /**
     * @param string $pseudo
     * @param string $gender
     * @param int    $points
     */
    public function __construct(string $pseudo, string $gender, int $points)
    {
        $this->pseudo = $pseudo;
        $this->gender = $gender;
        $this->points = $points;
    }
}
