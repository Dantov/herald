<?php

/**
 * Generate unknown language text
 * on cyrillic symbols
 */
class Herald
{

    /**
	* @var array
     * Гласные
     */
    public $vowels = ['а','е','ё','и','о','у','ы','э','ю','я'];

    /**
	* @var array
     * Согласные
     */
    public $consonants = ['б','в','г','д','ж','з','к','л','м','н','п','р','с','т','ф','х','ц','ч','ш','щ'];

    /**
     * @var array
     * конфигурация по умолчанию
     */
    protected $config = [
        'word'      => [1,14], // Кол-во букв в словах от-до
        'sentence'  => [3,10], // Кол-во слов в предложениях от-до
        'paragraph' => [4,20], // Кол-во предложений в параграфе от-до
        'text'      => [3,10], // Кол-во абзацев в тексте от-до
    ];

    /**
     * Herald constructor.
     * @param array $config
     * @throws Exception
     */
    public function __construct( $config=[] )
    {
        if ( !empty($config) && is_array($config) )
        {
			try {
				$this->setConfig($config);
			} catch (Exception $e) {
				debug('Error message: ' . $e->getMessage());
			}
        }
    }

    /**
     * @param array $config
     * @throws Exception
     */
    public function setConfig($config)
    {
        foreach ( $config as $paramName => $param  )
        {
			if ( !array_key_exists($paramName, $this->config) ) continue;
            if ( !is_array($param) ) continue;
            
            if ( isset($param[0]) )
            {
				$this->paramException($param[0]);
				$this->config[$paramName][0] = $param[0];
            }
            if ( isset($param[1]) )
            {
				$this->paramException($param[1]);
				$this->config[$paramName][1] = $param[1];
            }
        }
    }
    
    /**
	* 
	* @param {object} $param
	* @return
	*/
	protected function paramException($param)
	{
		if ( !is_int($param) )
			throw new Exception("Config parameters must be int",500);
		if ( $param < 0 )
			throw new Exception("Config parameters must be above zero",500);
		if ( $param > 40 )
			throw new Exception("Config parameters too high!",500);
	}
    
    public function getConfig()
    {
		return $this->config;
    }

    /**
     * @param $arr
     * @return mixed
     * Взяли случайный символ
     */
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
	* Генерирует случайное число на основе конфигурации
	* для заданного метода
	* @param string $param
	* @return
	*/
    protected function fromToRand( $param )
    {
		$from = $this->config[$param][0];
		$to = $this->config[$param][1];
		
		return mt_rand($from, $to);
    }

    /**
	 * Generating a random length word
     * @param bool $firstUpper
     * Upper case for the first letter
     * @return string
     */
    public function word( $firstUpper = false )
    {
		$symbolsCount = $this->fromToRand('word');

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
		$wordsCount =  $this->fromToRand('sentence');
        $sentence = [];

        $firstWord = $this->word(true);
        array_push($sentence, $firstWord);

        while ( count($sentence) < $wordsCount )
        {
            array_push($sentence, $this->word());
        }
        
		// запятые
		$count = count($sentence);
		if ( $count > 3 && $count < 8 )
		{
			$rand = mt_rand(0, $count-2);
			$sentence[$rand] .= ",";
		} elseif ( $count > 8 ) {
			$rand1 = $rand2 = 0;
			while ( $rand1 === $rand2 ) {
				$rand1 = mt_rand(0, $count-2);
				$rand2 = mt_rand(0, $count-2);
			}
			$sentence[$rand1] .= ",";
			$sentence[$rand2] .= ",";
		}
		
		$sentenceEnd = '.';
		if ( mt_rand(1, 100) < 5 ) $sentenceEnd = "!";
		return implode(' ', $sentence) . $sentenceEnd;
    }
    
    /**
	* Generate random height paragraph
	* 
	* @return string
	*/
    public function paragraph()
    {
		$sentencesCount = $this->fromToRand('paragraph');
        $paragraph = [];

        while ( count($paragraph) < $sentencesCount )
        {
            array_push($paragraph, $this->sentence());
        }

        return "\t" . implode(' ', $paragraph);
    }
    
    /**
	* Wall of text
	* @return string
	*/
    public function text()
    {
		$paragraphsCount = $this->fromToRand('text');
        $text = [];

        while ( count($text) < $paragraphsCount )
        {
            array_push($text, $this->paragraph());
        }

        return implode("\n", $text);
    }

}