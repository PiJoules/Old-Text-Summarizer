<?php

    /*
     *
     *  CREATE ARRAY OF INVERSE SENTENCE DISTRIBUTIONS FOR EACH TERM IN DOC1
     *
     *  INPUT: TERMS FROM DOC1; TERMS OF TEXT FROM OTHER DOCS
     *
     *  OUTPUT: ARRAY OF ISD VALUES FOR EACH TERM
     *
     */
    
    function inverse_sentence_distribution($terms, $other_docs){
        
        $isd = array();
        
        // create a master collection of all existing terms in all documents involved
        $all_terms = array($terms);
        foreach ($other_docs as $doc){
            array_push($all_terms, terms_from_sentences(sentences_from_doc($doc)));
        }
        
        // get the frequencies of each term in their respective docs
        $doc_frequency_array = array();
        foreach ($all_terms as $doc){
            $doc_frequency = array();
            foreach ($doc as $sentence){
                foreach ($sentence as $term){
                    if (!array_key_exists($term, $doc_frequency)){
                        $doc_frequency[$term] = 1;
                    }
                    else {
                        $doc_frequency[$term]++;
                    }
                }
            }
            array_push($doc_frequency_array, $doc_frequency);
        }
        
        // now calculate the ISDs
        foreach ($doc_frequency_array[0] as $term => $val){
            $count = 0;
            $sum = 0; // get avg doc frequency among all docs
            foreach ($doc_frequency_array as $doc_frequency){
                $freq = 0;
                if (array_key_exists($term, $doc_frequency)) $freq = $doc_frequency[$term]/words_in_doc($all_terms[$count++]);
                $sum += $freq;
            }
            $sum /= count($doc_frequency_array);
            
            $count = 0;
            $newsum = 0;
            foreach ($doc_frequency_array as $doc_frequency){
                $freq = 0;
                if (array_key_exists($term, $doc_frequency)) $freq = $doc_frequency[$term]/words_in_doc($all_terms[$count++]);
                $newsum += pow($freq-$sum,2)/$sum;
            }
            $isd[$term] = $newsum;
        }
        
        return $isd;
        
    }
    
    // small function for finding the number of terms in  document
    function words_in_doc($doc){
        $count = 0;
        foreach ($doc as $sentence){
            foreach ($sentence as $term){
                $count++;
            }
        }
        return $count;
    }

?>