<?php

    /*
     *
     *  GENERATES SUMMARY OF TEXT
     *
     *  INPUT: (POST) THE ACTUAL TEXT
     *
     *  OUPTUT: THE SUMMARIZED TEXT
     *
     */
    
    // get any errors
    ini_set('display_errors', true);
    error_reporting(-1);
    
    // include all necessary functions
    include "inverse_sentence_distribution.php";
    include "match.php";
    include "pageRanks_from_wordWeights.php";
    include "search.php";
    include "sentences_from_doc.php";
    include "similarity_between_sentences.php";
    include "term_distribution.php";
    include "terms_from_sentences.php";
    include "word_weight_from_TDandISD.php";
    
    // get the text
    $text = $_POST["text"];
    $other_docs = json_decode($_POST["others"]);
    $percent = intval($_POST["perc"]);
    
    // generate array of sentences from the text
    $sentences = sentences_from_doc($text);
    $terms = terms_from_sentences($sentences);
    $td = term_distribution($terms, 1);
    $isd = inverse_sentence_distribution($terms, $other_docs);
    $ww_from_TDandISD = word_weight_from_TDandISD($terms, $td, $isd);
    $pageranks = pageRanks_from_wordWeights($ww_from_TDandISD, 1);
    
    $newdoc = array();
    for ($i = 0; $i < count($sentences); $i++){
        $newdoc[$sentences[$i]] = $pageranks[$i];
    }
    array_multisort($pageranks, SORT_DESC, SORT_NUMERIC);
    
    $summary = "";
    $max_sentence_count = round($percent/100*count($sentences));
    foreach ($newdoc as $sentence => $pr){
        for ($rank = 0; $rank < $max_sentence_count; $rank++){
            if ($pr === $pageranks[$rank]){
                $summary .= $sentence . "\n\n";
                array_splice($pageranks, $rank, 1);
                $max_sentence_count--;
                break;
            }
        }
    }
    
    echo $summary;
    //var_dump($td);

?>
