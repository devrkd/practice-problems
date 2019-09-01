<?php

/*
 * Problem Statement
 * You have to classify a string as “GOOD”, “BAD” or “MIXED”.
 * A string is composed of lowercase alphabets and ‘?’. A ‘?’ is to be replaced by any of the lowercase alphabets.
 * Now you have to classify the string on the basis of some rules.
 * If there are 3 or more than 3 consonants together, the string is considered to be “BAD”.
 * If there are 5 or more than 5 vowels together, the also string is considered to be “BAD”.
 * A string is “GOOD” if its not “BAD”. Now when question marks are involved, they can be replaced with consonants or vowels to make new strings.
 * If all the choices lead to “GOOD” strings then the input is considered as “GOOD”, and if all the choices lead to “BAD” strings then the input is “BAD”,
 * else the string is “MIXED?
 *
 * */


/**
 * Class StringChecker
 */
Class StringChecker
{

    /**
     *  max limit for consonants
     */
    private const CONSTS_LIMIT = 3;

    /**
     * max limit for vowels
     */
    private const VOWELS_LIMIT = 5;

    /**
     * @var \stdClass
     */
    private $vowels;

    /**
     * @var \stdClass
     */
    private $consts;

    /**
     * @var string
     */
    private $input;

    /**
     * StringChecker constructor.
     *
     * @param string $string
     */
    public function __construct(string $string)
    {
        $this->input = $string;
        $this->init();
    }

    /**
     * @return string
     */
    public function isGoodString(): string
    {
        foreach (str_split($this->input) as $char) {

            $this->countVowel($char)
                ->countConst($char)
                ->countMixed($char);
        }

        return $this->checkStringHealth();
    }

    private function init()
    {
        $this->vowels = new stdClass();
        $this->vowels->values = [];
        $this->vowels->all = [];

        $this->consts = new stdClass();
        $this->consts->values = [];
        $this->consts->all = [];
    }

    /**
     * @param string $char
     *
     * @return bool|null
     */
    private function isVowles(string $char): ?bool
    {
        if (in_array($char, ['a', 'e', 'i', 'o', 'u'])) {
            return true;
        }

        if ($char == '?') {
            return null;
        }

        return false;
    }

    /**
     * @param $char
     *
     * @return \StringChecker
     */
    private function countVowel($char): self
    {
        if ($this->isVowles($char) === true) {
            array_push($this->vowels->values,1);
            array_push($this->vowels->all,1);
            $this->resetConsts();
        }

        return $this;
    }

    /**
     * @param $char
     *
     * @return \StringChecker
     */
    private function countConst($char): self
    {
        if ($this->isVowles($char) === false) {
            array_push($this->consts->values,1);
            array_push($this->consts->all,1);
            $this->resetVowels();
        }

        return $this;
    }

    /**
     * @param $char
     *
     * @return \StringChecker
     */
    private function countMixed($char): self
    {
        if($this->isVowles($char) === null) {
            array_push($this->consts->all,2);
            array_push($this->vowels->all,2);
            $this->vowels->values = [];
            $this->consts->values = [];
        }

        return $this;
    }

    private function  resetVowels()
    {
        $this->vowels->values = [];
        if(count($this->vowels->all) < self::VOWELS_LIMIT) {
            $this->vowels->all = [];
        }
    }

    private function resetConsts()
    {
        $this->consts->values = [];
        if(count($this->consts->all) < self::CONSTS_LIMIT) {
            $this->consts->all = [];
        }
    }

    /**
     * @param $type
     * @param $limit
     *
     * @return string
     */
    private function processConstsVowel($type, $limit)
    {
        $keys = array_count_values($type->all);

        if(count($type->values) >= $limit) {
            return "bad";
        }

        if(array_key_exists('2',$keys) && count($type->all) >= $limit) {
            return "mixed";
        }

        return "good";
    }

    /**
     * @return string
     */
    private function checkStringHealth(): string
    {
        $constsResult = $this->processConstsVowel($this->consts, self::CONSTS_LIMIT);
        $vowelsResult = $this->processConstsVowel($this->vowels, self::VOWELS_LIMIT);

        if(($constsResult == "bad" || $vowelsResult == "bad") ||
          ($constsResult == "mixed" && $vowelsResult == "mixed")) {
            return $this->input.':bad';
        }

        if($constsResult == "mixed" || $vowelsResult == "mixed") {
            return $this->input.': mixed';
        }

        return $this->input.':good';
    }
}

$stringChecker1 = new StringChecker('a?fafff');
$stringChecker2 = new StringChecker('??aa??');
$stringChecker3 = new StringChecker('abc');
$stringChecker4 = new StringChecker('aaa?aaafff');
$stringChecker5 = new StringChecker('aaaa?ff?aaa?aaa?fff');
$stringChecker6 = new StringChecker('aaaaff?');
$stringChecker7 = new StringChecker('aaaaf?');
$stringChecker8 = new StringChecker('?aaaaffaaf?aaaafff');
$stringChecker9 = new StringChecker('?aaaaffaaf?aaaaff');
$stringChecker10 = new StringChecker('vaxaaaa?bbadadada');
$stringChecker11 = new StringChecker('aaaa?bb');
$stringChecker12 = new StringChecker('vabb?aaaadadada');
$stringChecker13 = new StringChecker('vabab?aaaadadada');

echo $stringChecker1->isGoodString()."\n";
echo $stringChecker2->isGoodString()."\n";
echo $stringChecker3->isGoodString()."\n";
echo $stringChecker4->isGoodString()."\n";
echo $stringChecker5->isGoodString()."\n";
echo $stringChecker6->isGoodString()."\n";
echo $stringChecker7->isGoodString()."\n";
echo $stringChecker8->isGoodString()."\n";
echo $stringChecker9->isGoodString()."\n";
echo $stringChecker10->isGoodString()."\n";
echo $stringChecker11->isGoodString()."\n";
echo $stringChecker12->isGoodString()."\n";
echo $stringChecker13->isGoodString()."\n";
