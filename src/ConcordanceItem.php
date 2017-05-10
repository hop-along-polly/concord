<?php

class ConcordanceItem {

    private $occurences;
    private $lines;

    /**
     * Creates a new instance of a Concordance given a line number that the item occured on.
     *
     * @param integer $line The line number that the item occurred on.
     *
     * @return void
     */
    public function ConcordanceItem(int $line)
    {
        $this->occurences = 1;
        $this->lines = [ $line + 1];
    }

    /**
     * Adds an occurence at the specified line number.
     *
     * @param integer $line The line number in which the concordance occured.
     *
     * @return void
     */
    public function addOccurence(int $line)
    {
        $this->occurences += 1;
        //Since the file is parsed from line 1 to line N the lines array is already in ascending order.
        //1 has to be added because Arrays are base 0 and a concordance is base 1.
        $this->lines[] = $line + 1;
    }

    /**
     * Converts the concordanceItem to a string.
     *
     * @return String A String representation of the concordance item.
     */
    public function toString()
    {
        $lines = implode($this->lines, ',');
        return "{{$this->occurences}:{$lines}}";
    }
}

