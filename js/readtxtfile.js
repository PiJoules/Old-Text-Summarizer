// read text file containing other documents for IDD comparison
function readtxtfile(file){
    var txt = "";
    var rawfile = new XMLHttpRequest();
    rawfile.open("GET", file, false);
    rawfile.onreadystatechange = function(){
        if (rawfile.readyState === 4 && rawfile.status === 200) {
            txt = rawfile.responseText;
        }
    };
    rawfile.send();
    return txt;
}