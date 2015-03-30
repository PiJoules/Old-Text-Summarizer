<?php

    /*
     *
     *  COMPUTES THE PAGERANK FOR EACH SENTENCE GIVEN THE WORD WEIGHTS
     *  OF EACH WORD IN EACH SENTENCE VECTOR
     *
     *  INPUT: WORD WEIGHTS; NUMBER OF TIMES TO RUN PAGERANK FUNCTION
     *
     *  OUTPUT: SENTENCES WITH ASSOCIATED PAGERANKS
     *
     */
    
    function pageRanks_from_wordWeights($ww, $iterations){
        
        $pageranks = array();
        
        // initial pageranks (1/total_number_of_sentences)
        for ($i = 0; $i < count($ww); $i++){
            array_push($pageranks, 1/count($ww));
        }
        
        for ($i = 0; $i < $iterations; $i++){
            $newpageranks = array();
            for ($first_sent = 0; $first_sent < count($ww); $first_sent++){
                $sum = 0;
                for ($secnd_sent = 0; $secnd_sent < count($ww); $secnd_sent++){
                    if ($first_sent !== $secnd_sent){
                        // get similarity between first and second sentences
                        $Wji = similarity_between_sentences($ww[$first_sent], $ww[$secnd_sent]);
                        $denominator_sum = 0;
                        
                        // get similarity between sentence 2 and every other sentence pointing to it
                        for ($third_sent = 0; $third_sent < count($ww); $third_sent++){
                            if ($third_sent !== $secnd_sent) $denominator_sum += similarity_between_sentences($ww[$secnd_sent], $ww[$third_sent]);
                        }
                        
                        // calculate sum from similarity between product of all similarities between
                        // sentence 1 and 2, the PR of sentence2, divided by the sum of all similarities
                        // between sentence2 and all other sentences
                        if ($denominator_sum !== 0) $sum += $Wji*$pageranks[$secnd_sent]/$denominator_sum;
                    }
                }
                $newrank = $sum;
                array_push($newpageranks, $newrank);
            }
            $pageranks = $newpageranks;
        }
        
        return $pageranks;
    }

?>