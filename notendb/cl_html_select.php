<?php 
class HtmlSelect {
    public $stmt;    
    public $result; 
    public $count_cols; 
    public $count_rows; 

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
            $html = '<select name="'.$keyname.'" autofocus oninput="changeBackgroundColor(this);">' . PHP_EOL;    
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

    function print_select_multi($id, $keyname, $options_selected=[], $caption='') {
        $html = '';
        if ($caption!='') {
            $html.='<p><b>'.$caption.'</b><br/>'. PHP_EOL;
        }
        if ($this->count_rows > 0) {
            $html.= '<select id="'.$id.'" name="'.$keyname.'" multiple size="'.$this->visible_rows.'" style="width:100%;">' . PHP_EOL;  
            foreach($this->result as $key => $title) {
                $html .= ' <option value="' . $key .'"'.(in_array($key,$options_selected)?' selected':'').'>' . $title . '</option>'. PHP_EOL;
             }
            $html.= '</select>'. PHP_EOL;;
        }

        $html .='<br/><input type="button" id="btnReset_'.$id.'" value="Filter zurücksetzen" onclick="Reset_'.$id.'();" />  
             <script type="text/javascript">  
                function Reset_'.$id.'() {  
                var dropDown = document.getElementById("'.$id.'");  
                dropDown.selectedIndex = -1;  
            }  
        </script>';
        if ($caption!='') {
            $html.='</p>'. PHP_EOL;;
        }
        echo $html;
    }    
    function print_preselect($keyname, $value_selected='', $add_null_option=true) {
        $html = '';
        if ($this->count_rows > 0) {
            $html = '<select name="'.$keyname.'" onchange="this.form.submit()">' . PHP_EOL;  
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