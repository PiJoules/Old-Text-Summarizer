<?php

    /*
     *
     *  REPLICATES JAVASCRIPT MATCH
     *
     *  INPUT: STRING; REGULAR EXPRESSION
     *
     *  OUTPUT: ARRAY OF MATCHES; FALSE IF CANNOT FIND PATTERN
     *
     */
    
    function match($string, $regex){
        $matches = array();
        $result = preg_match_all($regex, $string, $matches);
        return ($result === 0 || !$result ? false : $matches[0]);
    }

?>