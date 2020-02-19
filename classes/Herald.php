<?php

/**
 */

class Herald
{


    /**
     * @var string
     * Гласные
     */
    public $vowels = ['а','е','и','о','у','ы','э','ю','я'];

    /**
     * @var string
     * Согласные
     */
    public $consonants = ['б','в','г','д','ж','з','к','л','м','н','п','р','с','т','ф','х','ц','ч','ш','щ'];


    public function getSymbol($arr)
    {
        $randomChar = mt_rand(0, count($arr)-1);
        shuffle( $arr );
        return $arr[$randomChar];
    }

    /**
     * Открытый слог - оканчивается на гласный звук.
     */
    public function openSyllable()
    {
        // случайное кол-во символов в слоге от 1 до 4
        $syllablesCount = mt_rand(1, 4);

        if ( $syllablesCount === 1 ) return $this->getSymbol($this->vowels);

        if ( $syllablesCount === 2 ) return $this->getSymbol($this->consonants) . $this->getSymbol($this->vowels);

        if ( $syllablesCount === 3 )
        {
            $firstSymbol = mt_rand(0, 1) ? $this->getSymbol($this->consonants) : $this->getSymbol($this->vowels);
            return  $firstSymbol . $this->getSymbol($this->consonants) . $this->getSymbol($this->vowels);
        }

        if ( $syllablesCount === 4 )
        {
            $firstSymbol = mt_rand(0, 1) ? $this->getSymbol($this->consonants) : $this->getSymbol($this->vowels);
            return  $firstSymbol . $this->getSymbol($this->consonants) . $this->getSymbol($this->consonants) . $this->getSymbol($this->vowels);
        }

    }

    /**
     * Закрытый слог - оканчивается на согласный звук.
     */
    public function closedSyllable()
    {

    }

}