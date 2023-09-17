<?php
class CurrencyFormat{
  public $dollar_amt;
  public $sign;

  function set_region_dollar_amt($dollar_amt){
    $this->dollar_amt = $dollar_amt;
  }

  public function __toString() {
    return '$' . $this->dollar_amt;
  }

  function get_region_dollar_amt(){
    $length = strlen($this->dollar_amt);
    $n = $length;
    for($n; $n > 3 ; $n -= 3){
      $this->dollar_amt = substr_replace($this->dollar_amt, ',', $n - 3, 0);
    }
  }
}//end class Currency Format
/*
$savings = new CurrencyFormat();
$savings->set_region_dollar_amt('30000','$');
$savings-> get_region_dollar_amt();
echo $savings;
*/
?>
