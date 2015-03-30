<?php

    /*
     *
     *  SPLITS TEXT INTO ARRAY OF SENTENCES
     *
     *  INPUT: THE WHOLE TEXT AS STRING
     *
     *  OUTPUT: ARRAY OF SENTENCES AS STRINGS
     *
     */
    
    function sentences_from_doc($text){
        
        // sentences will end with either periods (.), question marks (?), or explamation points (!)
        //
        // sentences will be split by finding indexes in the text that contain precede any one of
        // these sentence-ends followed by a space character (\s), so a pattern of length = 2 will
        // be used (<- this may not be the propper way to put it)
        //
        // sentences (for the purposes of this sumamrizer) can also end in any one of the sentence-
        // ends followed by a double quote (") to indicate a quotation, then followed by a
        // space character, so a pattern of length = 3 will be used
        
        
        // create pattern for sentence-ends length = 2
        $pattern_length2 = "/[\.\?\!]\s/";
            
        // create pattern for sentence-ends length = 3
        $pattern_length3 = "/[\.\?\!]\"\s/";
        
        // create pattern for sentence-ends of either length = 2|3
        $pattern = "/[\.\?\!]\"?\s/";
        
        // find first instance of sentence-end
        $index = search($text, $pattern);
        
        $sentences = array();
        
        // loop through the text looking for either pattern
        // cut the text at the appropriate index and save that text in array
        while ($index !== -1){
            if ($index === search($text, $pattern_length2)){
                array_push($sentences, substr($text, 0, $index+2));
                $text = substr($text, $index+2);
            }
            else if ($index === search($text, $pattern_length3)){
                array_push($sentences, substr($text, 0, $index+3));
                $text = substr($text, $index+3);
            }
            $index = search($text, $pattern);
        }
        
        // if there is still some text left, append it
        if (strlen($text) !== 0){
            array_push($sentences, $text);
        }
        
        
        // the methods above may cut off some quotations short
        // ex: The person with no soul said, "I don't like cats. They are stupid becuase I'm an idiot."
        // the methods above will split the following into 2 separate sentences
        // for the purposes of this summarizer, sentences contained in the same set of quotation marks
        // will be treated as one sentence and should be combined
        //
        // this will be done by recording how many quotes are in each sentence in the current sentence array
        // then combining sentences that inclusively between two sentences with odd amounts of quotes
        // ex: the quote above will be split into 2 sentences
        // 1) The person with no soul said, "I don't like cats.
        // 2) They are stupid becuase I'm an idiot."
        //
        // sentences with odd amounts of quotes are incomplete contrary to sentences with
        // even amounts of quotes
        
        // record number of times a quote appears in each sentence
        $quote_count = array();
        foreach($sentences as $sentence){
            $matches = match($sentence, "/\"/");
            array_push($quote_count, ($matches ? count($matches) : 0));
        }
        
        // create a new array to place the sentences and a temporary string to concatonate adjascent sentencess
        $combined_sentences = array();
        $concat = "";
        
        // loop through each sentence and if spot a sentence that has odd number of quotes, concat it to
        // temporary string, then reset string once find the sentence with end quote
        for ($i = 0; $i < count($sentences); $i++){
            if ($quote_count[$i]%2 === 0 && $concat === ""){
                array_push($combined_sentences, $sentences[$i]);
            }
            else {
                $concat .= $sentences[$i];
                if (count(match($concat, "/\"/"))%2 === 0){
                    array_push($combined_sentences, $concat);
                    $concat = "";
                }
            }
        }
        
        return $combined_sentences;
    }

?>