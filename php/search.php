<?php

    /*
     *
     *  EQUIVALENT TO JAVASCRIPT SEARCH METHOD
     *
     *  INPUT: STRING; REGULAR EXPRESSION
     *
     *  OUTPUT: INDEX OF FIRST INSTANCE OF REGULAR EXPRESSION; FALSE IF UNABLE TO FIND PATTERN IN STRING
     *
     */
    
    function search($string, $regex){
        return (preg_match($regex, $string, $matches, PREG_OFFSET_CAPTURE) === 1 ? $matches[0][1] : -1);
    }

?>