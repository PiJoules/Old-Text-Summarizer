/*
 *
 *  CALLS THE SUMMARIZER
 *
 */

function summarize() {
    
    // reset stuff
    document.getElementById("organized_terms").innerText = "";
    
    // call the spinner
    GLOBALS.spinner = new Spinner().spin(document.getElementById("main"));
    
    // get the main document
    var doc = replacements(document.getElementById("doc").value, GLOBALS.replacements);
    
    // takes time for spinner to get ready ?????
    setTimeout(function(){
        
        // get percentage
        var percent = parseInt(document.getElementById("maxSentenceCount").value);
        
        // get text from the other docs
        var other_docs = [];
        for (var i = 2; i < GLOBALS.doc_count+1; i++){
            other_docs.push(document.getElementById("doc" + i).innerText);
        }
        
        // run the summarizer
        var summary = "";
        var request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if (request.readyState === 4 && request.status === 200) {
                summary = request.responseText;
            }
            else {
                summary = "no response";
            }
        };
        request.open("POST", "php/summarize.php", false);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send("text=" + encodeURIComponent(doc) + "&others=" + encodeURIComponent(JSON.stringify(other_docs)) + "&perc=" + percent);
        
        // display the summary + stop spinner
        document.getElementById("summary").value = summary;
        GLOBALS.spinner.stop();
    },100);
    
}