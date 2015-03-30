/*
 *
 *  REPLACES ANY CONTENT FROM ORIGINAL STRING WITH NEW STRING
 *
 *  INPUT: ORIGINAL STRING; ASSOCIATIVE ARRAY OF REGULAR EXPRESSIONS WITH REPLACEMENTS (KEY(REPLACEMENT STRING) => VALUE(REGEX))
 *
 *  OUTPUT: TEXT WITH REPLACED STRINGS
 *
 */

function replacements(text, regex) {
    
    // replace any new lines with spaces
    text = text.replace(/\n/g," ");
    
    // then start implementing the replacements
    for (var replacement in regex){
        text = text.replace(regex[replacement], replacement);
    }
    
    return text;
    
}