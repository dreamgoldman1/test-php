<?php

class ElectronicItem{
    private $productName;
    private $price;
    private $type;
    private $wired;
    private $extra;
    private $maxExtras;
    
    public function __construct(array $item){
        if (array_key_exists('productName', $item))
            $this->setProductName($item['productName']);
        if (array_key_exists('price', $item))
            $this->setPrice($item['price']);
        if (array_key_exists('type', $item))
            $this->setType($item['type']);
        if (array_key_exists('wired', $item))
            $this->setWired($item['wired']);

        switch ($item['type']){
            case 'console':
                $this->setMaxExtras(4);
                break;
            case 'microwave':
                $this->setMaxExtras(0);
                break;
            case 'controller':
                $this->setMaxExtras(0);
                break;
        }

        // Invoke function MaxExtras
        $this->maxExtras($item);
    }

    public function maxExtras($item){
        // Get Max Extras from Item, value set by type
        $maxExtras = $this->getMaxExtras();

        // Ask if extra index is define or isn't empty
        if (!empty($item['extra']) && array_key_exists('extra', $item)) {

            // If Max Extras === NULL then extras unlimited
            if ($maxExtras === null) {
                $maxExtras = count($item['extra']);
            // If extras array from item < maxExtras: then save all extras
            } elseif ($maxExtras > count($item['extra'])) {
                $maxExtras = count($item['extra']);
            }
            for ($i = 0; $i <= $maxExtras - 1; $i++) {
                $this->setExtra($item['extra'][$i]);
            }
        }
    }

    public function getMaxExtras(){
        return $this->maxExtras;
    }

    private function setMaxExtras($maxExtras){
        return $this->maxExtras = $maxExtras;
    }

    public function getPrice(){
        return $this->price;
    }

    private function setPrice($price){
        return $this->price = $price;
    }

    public function getProductName(){
        return $this->productName;
    }

    private function setProductName($productName){
        return $this->productName = $productName;
    }

    public function getType(){
        return $this->type;
    }

    private function setType($type){
        return $this->type = $type;
    }

    public function getWired(){
        return $this->wired;
    }

    private function setWired($wired){
        return $this->wired = $wired;
    }

    public function getExtra(){
        return $this->extra;
    }

    private function setExtra($extra){
        return $this->extra[] = $extra;
    }

}
