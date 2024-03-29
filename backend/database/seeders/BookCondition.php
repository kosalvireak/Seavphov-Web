<?php

class BookCondition
{

    public string $AS_NEW = 'As New';
    public string $GOOD = 'Good';
    public string $WELL_WORN = 'Well-worn';
    public array $Condition = ['As New', 'Good', 'Well-worn'];

    public function getCondition()
    {
        $randomNumber = mt_rand(0, 2);
        return $this->Condition[$randomNumber];
    }
}
