<?php 
class HtmlSelect {
    public $stmt;    
    public $result; 
    public $count_cols; 
    public $count_rows; 
    public $option_values=[]; // alle values 
    public $option_titles=[]; // alle titles 
    public $option_values_selected=[]; // alle ausgewählten values 
    public $option_titles_selected=[]; // alle ausgewählten titles  
    public $titles_list; // String, der die Liste der Titels enthält 
    public $titles_selected_list; // String, der die Liste der ausgewählten Titels enthält
    public $autofocus=false; // true, wenn Auswahlbox beim Öffnen eines Formulars den Focus erhalten soll  

    // config. multi-select 
    protected $visible_rows_default=5; // Zeilen Standard
    public $visible_rows; 

    function __construct($stmt) {
        $this->stmt = $stmt; 
        $this->result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        $this->count_cols=$stmt->columnCount(); 
        $this->count_rows = count($this->result); 

        $this->visible_rows=$this->visible_rows_default;         
        if ($this->count_rows < $this->visible_rows ) {
            $this->visible_rows = $this->count_rows; 
        }
    }
    
    function print_select($keyname, $value_selected='', $add_null_option=true) {
        $html = '';
        if ($this->count_rows > 0) {
            $html = '<select name="'.$keyname.'" oninput="changeBackgroundColor(this);"'.($this->autofocus?' autofocus="autofocus"':'').'>' . PHP_EOL;    
            if($add_null_option) {
                $html .= '<option value="" '.($value_selected=='' ? 'selected' : ''). '></option>'. PHP_EOL;
            }
            foreach($this->result as $key => $title) {
                $html .= ' <option value="' . $key . '"'.($value_selected==$key ? ' selected' : ''). '>' . $title . '</option>'. PHP_EOL;
                }
            $html .= '</select>';
        }
        echo $html;
    }    

    function print_select_multi($id
        , $keyname
        , $options_selected=[]
        , $caption=''
        , $print_check_excl=false // Anzeige Checkbox Genaue Suche
        , $check_excl=false // Genaue Suche aktiviert 
        ) {
        // $add_check_excl: Checkbox für Ausschluss-Suche anzeigen 
        $html = '<p>';
        if ($caption!='') {
            $html.='<b>'.$caption.'</b><br/>'. PHP_EOL;
        }
        if ($this->count_rows > 0) {
            $html.= '<select id="'.$id.'" name="'.$keyname.'" multiple size="'.$this->visible_rows.'" style="width:100%;font-size:9pt">' . PHP_EOL;  
            foreach($this->result as $key => $title) {
                if (in_array($key,$options_selected)) {
                    $html .= '<option value="' . $key .'" selected>' . $title . '</option>'. PHP_EOL;
                    $this->option_values_selected[]=$key;  
                    $this->option_titles_selected[]=$title;  
                } 
                else {
                    $html .= '<option value="' . $key .'">' . $title . '</option>'. PHP_EOL;   
                    $this->option_values[]=$key;  
                    $this->option_titles[]=$title;                                      
                }
             }
            $html.= '</select>'. PHP_EOL;;
        }
        
        // XXX verworfen 
        // $html .='<br/><input type="button" id="btnReset_'.$id.'" value="Filter zurücksetzen" onclick="Reset_'.$id.'();" />  
        //      <script type="text/javascript">  
        //         function Reset_'.$id.'() {  
        //         var dropDown = document.getElementById("'.$id.'");  
        //         dropDown.selectedIndex = -1;  
        //     }  
        //     </script>';

        if ($print_check_excl) {
            $html.='<input type="checkbox" name="ex_'.$id.'" '.($check_excl?' checked':'').'>
             <label for="ex_'.$id.'">Genaue Suche</label>';
        }   

        $html.='</p>'. PHP_EOL;;
        echo $html;
        $this->titles_selected_list= '* '.$caption.' '.implode('; ', $this->option_titles_selected).PHP_EOL; 
    }    

    function print_preselect($keyname, $value_selected='', $add_null_option=true) {
        $html = '';
        if ($this->count_rows > 0) {
            $html = '<select name="'.$keyname.'" onchange="this.form.submit()" tabindex="-1">' . PHP_EOL;  
            if($add_null_option) {
                $html .= '<option value="" '.($value_selected=='' ? 'selected' : ''). '></option>'. PHP_EOL;
            }
            foreach($this->result as $key => $title) {
                $html .= ' <option value="' . $key . '"'.($value_selected==$key ? ' selected' : ''). '>' . $title . '</option>'. PHP_EOL;
                }
            $html .= '</select>';
        }
        echo $html;
    }    


}


?>