<?php
include_once "DatabaseUtils.php";

class Money extends DatabaseUtils 
{
    protected $_amounts;
    protected $_totalAmount;
    protected $_total;
    
    public function __construct($dbName, $dbHost, $dbUser, $dbPass) {

        parent::__construct($dbName, $dbHost, $dbUser, $dbPass);
        $this->_amounts = $this->select("select money_type, amount*money_type as total_amount,amount from bank order by money_type desc"); 
        $this->_totalAmount = $this->select("select sum(amount*money_type) as totalAmount from bank");
        $this->_total = $this->select("SELECT sum(amount) FROM bank");
        return $this; 

    }

    public function getTotalAmount() {
        return $this->_totalAmount[0]['totalAmount'];
    }

    public function getTotal() {
        return $this->_total[0]['sum(amount)'];
    }

    public function getAmounts () {
        return $this->_amounts;
    }

    public function setAmounts($amounts) {
        foreach ($amounts as $key => $value) {
            $params = array('amount' => $value,"where_cond" => $key);
            $sql = "UPDATE bank set amount = amount-:amount where money_type = :where_cond";
            $result = $this->update($sql, $params);
        }
               
        $this->_amounts = $this->select("select money_type, amount*money_type as total_amount,amount from bank order by money_type desc"); 
        return $this;
    }

}