<?php

namespace App\Api\Controllers;

use App\Api\Requests\RepaymentRequest;
use App\Api\Transformers\RepaymentTransformer;
use App\Http\Controller;
use Domain\Loans\Actions\MakeRepaymentAction;


class RepaymentController extends Controller
{
    public function store(RepaymentRequest $request, MakeRepaymentAction $action)
    {
        $repayment = $action->execute(
            $request->getScheduleRepayment(),
            $request->input('amount'), 
            $request->user()->id
        );

        return $this->respondOk(new RepaymentTransformer(), $repayment);
    }
}
