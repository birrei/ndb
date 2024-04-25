function set_seconds() {  
    var txt_min = document.getElementById("input_minutes").value;
    var int_sec = 0; 
    /* 
      zwei Eingabevarianten sollen moeglich sein: 
        - Eine Ganzzahl bzw. ein in eine Ganzzahl umwandelbarer Wert  
        - Eine Minuten/Sekunden-Angabe im Format "mm:ss" 
      wenn davon keine gegeben, wird für Sekunden 0 ausgegeben 
    */
    if (!isNaN(txt_min)) {
      // Zahl wurde eingegeben
        sec=Math.floor(txt_min*60);
    } 
    else {
        sec = 0; // format mm:ss, nur zulassen bei vorh. Zahlen-Werte vor und nach ":"
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
    document.getElementById("input_seconds").value=sec;  
}