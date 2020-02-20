<?php

/**
 */

class Herald
{


    /**
     * @var string
     * Гласные
     */
    public $vowels = ['а','е','ё','и','о','у','ы','э','ю','я'];

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
        $symbolsCount = mt_rand(1, 4);
        $openSyllable = '';

        if ( $symbolsCount === 1 ) $openSyllable = $this->getSymbol($this->vowels);

        if ( $symbolsCount === 2 ) $openSyllable = $this->getSymbol($this->consonants) . $this->getSymbol($this->vowels);

        if ( $symbolsCount > 2 )
        {
            $firstSymbol = mt_rand(0, 1) ? $this->getSymbol($this->consonants) : $this->getSymbol($this->vowels);
            $openSyllable =  $firstSymbol . $this->getSymbol($this->consonants) . $this->getSymbol($this->vowels);
            if ( $symbolsCount === 4 ) $openSyllable .= 'й';
        }

        return $openSyllable;
    }


    /**
     * Закрытый слог - оканчивается на согласный звук.
     */
    public function closedSyllable()
    {
        $symbolsCount = mt_rand(2, 4);
        $closedSyllable = '';

        if ( $symbolsCount === 2 ) $closedSyllable = $this->getSymbol($this->vowels) . $this->getSymbol($this->consonants);
        if ( $symbolsCount > 2 )
        {
            $closedSyllable = $this->getSymbol($this->consonants).$this->getSymbol($this->vowels).$this->getSymbol($this->consonants);
            if ( $symbolsCount === 4 ) $closedSyllable .= 'ь';
        }

        return $closedSyllable;
    }


    /**
     * @param bool $firstUpper
     * генерирует слово случайной длинны
     * @return string
     */
    public function word( $firstUpper = false )
    {
        $symbolsCount = mt_rand(1, 14);

        $word = '';

        while ( strlen($word) < $symbolsCount )
        {
            $syllable = mt_rand(0, 1) ? $this->openSyllable() : $this->closedSyllable();
            $word .= $syllable;
        }

        if ( $firstUpper )
        {
            $characters = preg_split( '//u', $word, -1, PREG_SPLIT_NO_EMPTY );
            $characters[0] = mb_strtoupper($characters[0]);
            $word = implode($characters);
        }

        return $word;
    }

    /**
     * Формируем предложение
     * @return string
     */
    public function sentence()
    {
        $wordsCount = mt_rand(3, 10);
        $sentence = [];

        $firstWord = $this->word(1);
        array_push($sentence, $firstWord);

        while ( count($sentence) < $wordsCount )
        {
            array_push($sentence, $this->word());
        }

        return implode(' ', $sentence) . '.';
    }

    public function paragraph()
    {
        $sentencesCount = mt_rand(4, 20);
        $paragraph = [];

        while ( count($paragraph) < $sentencesCount )
        {
            array_push($paragraph, $this->sentence());
        }

        return "&nbsp;&nbsp;&nbsp;&nbsp;" . implode(' ', $paragraph);
    }

    public function text()
    {
        $paragraphsCount = mt_rand(3, 10);
        $text = [];

        while ( count($text) < $paragraphsCount )
        {
            array_push($text, $this->paragraph());
        }

        return implode("<br>", $text);
    }

}