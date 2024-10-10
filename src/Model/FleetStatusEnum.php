<?php

namespace App\Model;
use App\Interface\Description;


enum FleetStatusEnum: string implements Description
{
    case Free = 'free';
    case Works = 'works';
    case Downtime = 'downtime';


    public function getDescription():string
    {
        return match($this) {
            self::Works => 'The fleet is operational.',
            self::Free => 'The fleet is not currently assigned or in use.',
            self::Downtime =>  'The fleet is not operational because either the truck or trailer is undergoing service.',
        };
    }
}
