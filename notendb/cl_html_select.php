<?php 
class HtmlSelect {
    public $stmt;    
    public $result; 
    public $count_cols; 
    public $count_rows; 
    
    function __construct($stmt) {
        $this->stmt = $stmt; 
        $this->result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        $this->count_cols=$stmt->columnCount(); 
        $this->count_rows = count($this->result); 
    }
   
    function print_select($keyname, $value_selected='', $add_null_option=true) {
        $html = '';
        if ($this->count_rows > 0) {
            $html = '<select name="'.$keyname.'" autofocus>' . PHP_EOL;    
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