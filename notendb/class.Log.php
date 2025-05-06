
<?php 

class Log {
  private string $UserName; 

  public function __construct(){
    $this->UserName = get_current_user(); 
  }

  public function printUserName() {
    echo 'User: '.$this->UserName; 
  }

}


?>