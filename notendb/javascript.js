
function getSeconds(txt_min) {
  var int_sec = 0; 
  if (!isNaN(txt_min)) {
    // Zahl wurde eingegeben
      sec=Math.floor(txt_min*60);
  } 
  else {
    // format mm:ss, nur zulassen bei vorh. Zahlen-Werte vor und nach ":"
    sec = 0; 
    const arr_values=txt_min.split(":"); 
    if (arr_values.length = 2) {
        if (arr_values[0]!="" & arr_values[1]!="") {
            if (!isNaN(arr_values[0]) & !isNaN(arr_values[1]) ) {
                min_tmp=parseInt(arr_values[0]); 
                sec_tmp=parseInt(arr_values[1]);                     
                sec = (min_tmp*60) + sec_tmp;  
            } 
        }
    }       
  }
  return sec;  
}

function changeBackgroundColor(element) {  
  // element.style.backgroundColor="#E4FF00"; // hellgrüngelb 
  element.style.backgroundColor="#fad0e0"; // 

}  

function linkStyleFocus(element) {
  element.style.backgroundColor="lightgreen"; 
}
function linkStyleNotFocus(element) {
  element.style.backgroundColor="white"; 
}