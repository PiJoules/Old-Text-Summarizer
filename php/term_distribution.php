<?php

    /*
     *
     *  GENERATES TD VALUES FOR EACH TERM IN THE TERMS MATRIX
     *
     *  INPUT: ARRAY OF ARRAY OF TERMS; NUMBER OF SENTENCES PER PARAGRAPH (BEST TO KEEP IT AT 1 FOR NOW)
     *
     *  OUPUT: ARRAY OF ARRAY OF TD VALUES FOR EACH UNIQUE TERM
     *
     */
    
    function term_distribution($terms, $sentences_per_paragraph){
        
        // for the purposes of this summarizer, each "row" of terms in this "matrix"
        // of terms will be treated as a sentence since each "row" contains the
        // terms of that sentence
        
        // initialize some stuff
        $td = array(); // the actual array to return
        $doc = array(array()); // array containing groups of sentences (paragraphs)
        $paragraph = array(); // temporary array to store paragraphs
        
        // term distribution generation involves grouping sentences into paragraphs
        // (represented by sentences_per_paragraph variable), though the number of
        // sentences in the text may not divide ebenly into this number, so to
        // repsond to this, increase the value of this variable until it is divisible
        while (count($terms)%$sentences_per_paragraph !== 0) $sentences_per_paragraph++;
        
        $paragraph_count = count($terms)/$sentences_per_paragraph; // number of paragraphs in doc
        
        // split sentences into paragrpahs and save them into doc
        $end = count($doc)-1;
        foreach ($terms as $sentence){ // loop through each sentence
            if (count($doc[$end]) === $sentences_per_paragraph){ // append empty array to end of doc if current one is full
                array_push($doc, array());
                $end = count($doc)-1;
            }
            array_push($doc[$end], $sentence);
        }
        
        // find how frequently term (i) appears in paragraph (p) in document (d)
        // f_ip = frequency of term (i) in paragraph (p)
        // f_id = frequency of term (i) in document (d)
        $f_ip_array = array();
        $f_id = array();
        
        // NOTE!!!!: THERE IS AN ERROR IN THE JAVASCRIPT VERSION OF THIS FUNCTION
        // SEE JAVASCRIPT VERSION FOR ERROR, THIS ONE CALCULATES THE CORRECT TD
        //$test = array();
        foreach ($doc as $p){ // for each paragraph in the document
            $f_ip = array();
            foreach ($p as $sentence){ // for each sentence in the paragraph
                foreach ($sentence as $term){ // lol (third nested forloop) for each term in the sentence
                    
                    //-----------PHP VERSION-----------
                    // record frequency for each paragraph
                    /*if (!array_key_exists($term, $f_ip)){
                        $f_ip[$term] = 1;
                    }
                    else {
                        $f_ip[$term]++;
                    }
                    
                    // record frequency for each document
                    if (!array_key_exists($term, $f_id)){
                        $f_id[$term] = 1/$paragraph_count;
                    }
                    else {
                        $f_id[$term] += 1/$paragraph_count;
                    }*/
                    //---------------------------------
                    
                    //------JAVASCRIPT VERSION---------
                    //if ($term === "school") array_push($test, array($f_ip[$term], $f_id[$term]));
                    if (!array_key_exists($term, $f_ip)){
                        $f_ip[$term] = 0;
                        $f_id[$term] = 0;
                        //if ($term === "school") array_push($test, array($f_ip[$term], $f_id[$term]));
                    }
                    if (!$f_ip[$term]){
                        $f_ip[$term] = 1;
                    }
                    else {
                        $f_ip[$term]++;
                    }
                    if (!$f_id[$term]){
                        $f_id[$term] = 1/$paragraph_count;
                    }
                    else {
                        $f_id[$term] += 1/$paragraph_count;
                    }
                    //if ($term === "school") array_push($test, array($f_ip[$term], $f_id[$term]));
                    //--------------------------------
                }
            }
            array_push($f_ip_array, $f_ip);
        }
        
        
        // run the chai-square test for each term, then calculate the final term distribution
        // for each unique term
        foreach ($f_id as $term => $val){
            $sum = 0;
            foreach ($f_ip_array as $f_ip){
                $f_ip_term = (array_key_exists($term, $f_ip) ? $f_ip[$term] : 0);
                $sum += pow($f_ip_term-$f_id[$term],2)/$f_id[$term];
            }
            $td[$term] = 1/(1+$sum);
        }
        
        return $td;
        
    }

?>