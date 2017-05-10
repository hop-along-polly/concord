<?php

require_once "phar://concord.phar/ConcordanceItem.php";

class Concordance {

    /**
     * An associative array on Concordance Items.
     *
     * @var concordance
     */
    private $concordance;

    /**
     * Creates new instance of a Concordance with no items.
     *
     * @return void
     */
    public function Concordance()
    {
        $this->concordance = [];
    }

    /**
     * Checks if the specified word already exists in the concordance.
     *
     * @param string $word The word to check the concordance for.
     *
     * @return boolean
     */
    public function contains(string $word)
    {
        return array_key_exists(strtolower($word), $this->concordance);
    }

    /**
     * Adds the specified word and line number to the concordance.
     *
     * @param string  $word The word to add.
     * @param integer $line The line number that the word occured on.
     *
     * @return void
     */
    public function add(string $word, int $line)
    {
        $item = new \ConcordanceItem($line);
        $this->concordance += [strtolower($word) => $item];
    }

    /**
     * Increments the number of occurences for the specified word at the specified line number.
     *
     * @param string  $word The word to increment occurences for.
     * @param integer $line The line number of the occurence.
     *
     * @return void
     */
    public function increment(string $word, int $line)
    {
        $this->concordance[strtolower($word)]->addOccurence($line);
    }

    /**
     * Sorts the concordance in alphabetical order.
     *
     * @return Object A reference to the sorted concordance.
     */
    public function alphabetize()
    {
        ksort($this->concordance, SORT_NATURAL | SORT_FLAG_CASE);
        return $this;
    }

    /**
     * Converts the concordance to a string.
     *
     * @return string The string representation of a concordance.
     */
    public function toString()
    {
        $result = '';
        $row = 0;
        foreach($this->concordance as $key => $item) {
            $index = $this->outputIndex($row);
            $result .= "{$index}. {$key} {$item->tostring()}" . PHP_EOL;
            ++$row;
        }

        return $result;
    }

    private function outputIndex(int $row)
    {
        $alphabet = range('a', 'z');
        $index = $alphabet[$row % 26];
        $count = ($row + 1) / 26;
        $result = '';
        for($i = 0; $i < $count; ++$i)
        {
            $result .= $index;
        }

        return $result;
    }
}

