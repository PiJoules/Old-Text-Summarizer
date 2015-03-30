<?php

    /*
     *
     *  TAKES THE ARRAY OF SENTENCES, THEN GENERATES AN ARRAY OF TERMS FOR EACH SENTENCE
     *
     *  INPUT: ARRAY OF SENTENCES
     *
     *  OUTPUT: ARRAY OF ARRAY OF TERMS
     *
     */
    
    function terms_from_sentences($sentences){
        
        $terms = array();
        
        foreach ($sentences as $sentence){
            
            // create regex for unecessary characters that won't be included in the lst of terms
            // commas, decimals, double quotes, opening/closing parentheses, apostraphe + s,
            // tabs, semicolons
            //
            // these are the default characters that I have found in most articles used for
            // testing this algorithm, though more can be added anytime in the future
            
            $bad_chars = "/\,|\.|\"|\(|\)|\'s|\t|\:/";
            $sentence = strtolower(preg_replace($bad_chars, "", $sentence));
            
            // replace some characters with spaces and convert string to lowercase
            //$space_chars = "/\-/";
            //$sentence = preg_replace($space_chars, " ", $sentence);
            
            // the actual splitting
            $sentence_terms = preg_split("/\s/", $sentence);
            
            // get rid of any bad elements that contain no real words/numbers
            for ($i = 0; $i < count($sentence_terms); $i++){
                if (search($sentence_terms[$i], "/\w|\d/") === -1) array_splice($sentence_terms, $i--, 1);
            }
            
            // PUSSSSHHHHHHHHH, PUSSSSSHHHHHHH!!!!!!
            array_push($terms, $sentence_terms);
            
        }
        
        return $terms;
        
    }

?>