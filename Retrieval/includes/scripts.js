$( document ).ready(function() {
    var cssLink = document.createElement("link") ;
    cssLink.href = "../style.css";
    cssLink.rel = "stylesheet";
    cssLink.type = "text/css";
    var t = document.getElementById("iframeTables")[0];
    t.body.appendChild(cssLink);
    //frames['iframeTables'].document.head.appendChild(cssLink);
});
