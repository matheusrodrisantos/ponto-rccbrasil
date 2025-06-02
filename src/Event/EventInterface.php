<?php 
namespace App\Event;

interface EventInterface{

    public function ocorreuQuando():\DateTimeImmutable;
    
}