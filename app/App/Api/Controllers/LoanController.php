<?php

namespace App\Api\Controllers;

use App\Api\Requests\GetLoanRequest;
use App\Api\Requests\GetLoansRequest;
use App\Api\Requests\RequestLoanRequest;
use App\Api\Transformers\LoanTransformer;
use App\Http\Controller;
use Domain\Loans\Actions\RequestLoanAction;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Models\Loan;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    public function get(GetLoansRequest $request): JsonResponse
    {
        $loans = Loan::where('customer_id', $request->user()->id)->paginate(10);

        return $this->respondWithPaginatedCollection(new LoanTransformer(), $loans);
    }

    public function find(GetLoanRequest $request): JsonResponse
    {
        $loan =  $request->getLoan();

        return $this->respondOk(new LoanTransformer(), $loan);
    }

    public function store(RequestLoanRequest $request, RequestLoanAction $action): JsonResponse
    {
        $requestLoan = [
            'customer_id' => $request->user()->id,
            'repayment_term' => $request->input('repayment_term'),
            'repayment_frequency' => $request->input('repayment_frequency'),
            'amount' => $request->input('amount'),
            'interest_rate' => Loan::INTEREST_RATE,
            'status' => LoanStatus::PENDING,
        ];

        $loan = $action->execute($requestLoan);

        return $this->respondCreated(new LoanTransformer(), $loan);
    }
}
