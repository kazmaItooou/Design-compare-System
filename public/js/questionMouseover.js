function changeColorBadLayout(mouse, id) {
    if (mouse == "over") {
        document.getElementById(id).style.backgroundColor = "#F3FFD8";
        document.getElementById(id).style.color = "#333333";
    } else if (mouse == "out") {
        document.getElementById(id).style.backgroundColor = "unset";
        document.getElementById(id).style.color = "unset";
    }
}
function changeColorBasicLayout(mouse, id) {
    if (mouse == "over") {
        if(document.getElementById(id).style.textDecoration == "line-through"){
            document.getElementById(id).style.textDecoration = "underline line-through";
            document.getElementById(id).style.cursor = "pointer";//動かない
        }else{
            document.getElementById(id).style.textDecoration = "underline";
            document.getElementById(id).style.cursor = "pointer";//動かない

        }
        //document.getElementById(id).style.fontWeight = "bold";
        // document.getElementById(id).style.backgroundColor = "#DDDDDD";
        // document.getElementById(id).style.color = "#333333";
        // document.getElementById(id).style.borderRadius = "8px";
        // document.getElementById(id).style.border = "solid";
        // document.getElementById(id).style.borderColor = "black";
        // document.getElementById(id).style.borderWidth = "1px";
    } else if (mouse == "out") {
        if(document.getElementById(id).style.textDecoration == "underline line-through"){
            document.getElementById(id).style.textDecoration = "line-through";
        }else{
            document.getElementById(id).style.textDecoration = "none";
        }
        //document.getElementById(id).style.fontWeight = "unset";
        // document.getElementById(id).style.backgroundColor = "unset";
        // document.getElementById(id).style.color = "unset";
        // document.getElementById(id).style.borderRadius = "8px";
        // document.getElementById(id).style.border = "double";
        // document.getElementById(id).style.borderColor = "transparent";
        // document.getElementById(id).style.borderWidth = "1px";
    }
}
