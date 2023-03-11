<?php

namespace App\Api\Controllers;

use App\Http\Controller;
use App\Api\Requests\GetScheduleRepaymentsRequest;
use App\Api\Transformers\ScheduleRepaymentTransformer;

class ScheduleRepaymentController extends Controller
{
    public function get(GetScheduleRepaymentsRequest $request)
    {
        $loan = $request->getLoan();

        $scheduleRepayments = $loan->scheduleRepayments()->paginate();

        return $this->respondWithPaginatedCollection(new ScheduleRepaymentTransformer(), $scheduleRepayments);
    }
}
