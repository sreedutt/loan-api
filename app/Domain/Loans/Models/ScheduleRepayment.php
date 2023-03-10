<?php

namespace Domain\Loans\Models;

use App\Helpers\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleRepayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_to_be_paid',
        'repayment_date',
        'status',
    ];
}
