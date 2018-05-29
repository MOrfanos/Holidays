<?php
include_once "Money.php";

class Withdraw extends Money
{
    private $_moneyToRemove = array();
    
    public function withdrawMoney($request) {

        foreach ($this->getAmounts() as $item) {

            if($request <= $item['total_amount'] && ( $mod = ($request%$item['money_type'] )) !== false) {
                $div = (int)($request / $item['money_type']);
                $this->_moneyToRemove[$item['money_type']] = $div; 
                $request -= (int)($request/$item['money_type']) * $item['money_type'];
            } 
            elseif($request > $item['total_amount']) {
                
                $this->_moneyToRemove[$item['money_type']] = (int)($item['total_amount'] / $item['money_type']); 
                $request -= $item['total_amount'];
            }

            if (!$request) break;
        }

        // if(!$request) {
            $this->setAmounts($this->_moneyToRemove);
            return true;
        // }

        // return false;
    }
}