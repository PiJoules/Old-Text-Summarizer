<?php

    /*
     *
     *  CALCULATES THE OVERALL WORD WEIGHT OF EACH TERM FROM THEIR TDs AND ISDs
     *
     *  INPUT: TERMS; TERM DISTRIBUTIONS; INVERSE SENTENCE DISTRIBUTIONS
     *
     *  OUTPUT: NEW COMPUTED WORD WEIGHTS FOR EACH TERM
     *
     */
    
    function word_weight_from_TDandISD($terms, $td, $isd){
        
        $ww = array();
        
        foreach ($terms as $sentence){
            $newsentence = array();
            foreach ($sentence as $term){
                $newsentence[$term] = $td[$term]*$isd[$term];
            }
            array_push($ww, $newsentence);
        }
        
        return $ww;
        
    }

?>