const todoID = document.querySelectorAll("#checkss");

for (var i = 0; i < todoID.length; i++) {
   todoID[i].addEventListener("click", (e) => {
      // console.log(e.srcElement.checked);
      if (e.srcElement.checked) {
         let path = window.location.pathname;
         let page = path.split("/").pop();
         let url = page + "?completed=" + e.target.value;
         httpGet(url);
      } else {
         let path = window.location.pathname;
         let page = path.split("/").pop();
         let url = page + "?incomplete=" + e.target.value;
         httpGet(url);
      }
   });
}

function httpGet(theUrl) {
   var xmlHttp = new XMLHttpRequest();
   xmlHttp.open("GET", theUrl, false); // false for synchronous request
   xmlHttp.send(null);
   return xmlHttp.responseText;
}
