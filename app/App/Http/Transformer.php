<?php
namespace App\Http;

interface Transformer 
{
    public function transform(): array;
}