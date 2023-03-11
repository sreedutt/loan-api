<?php
namespace App\Http;

use Illuminate\Database\Eloquent\Model;

interface Transformer 
{
    public function transform($model): array;
}