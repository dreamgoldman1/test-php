<?php

class ElectronicItems{
    private $items = [];

    public function addItem($item){
        $this->items[$item->getPrice()] = $item;
    }

    public function getStoredItems(){
        return $this->items;
    }

    public function getSortItems(){
        ksort($this->items);
        return $this->items;
    }

    public function getItemsByType($type){
        foreach ($this->items as $item){
            if ($item->getType() == $type){
                $result[] = $item;
            }
        }
        return $result;
    }

    public function getTotalPrice(){
        $sum = 0;
        foreach ($this->items as $item){
            $sum += $item->getPrice();
            $extras = $item->getExtra();
            if (!empty($extras)){
                foreach ($extras as $extra){
                    $sum += $extra->getPrice();
                }
            }
        }
        return $sum;
    }

    public function getTotalPriceByType($type){
        $items = $this->getItemsByType($type);
        $sum = 0;
        foreach ($items as $item){
            $sum += $item->getPrice();
            $extras = $item->getExtra();
            if (!empty($extras)){
                foreach ($extras as $extra){
                    $sum += $extra->getPrice();
                }
            }
        }
        return $sum;
    }
}