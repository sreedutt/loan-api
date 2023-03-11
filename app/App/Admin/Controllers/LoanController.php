<?php

namespace App\Admin\Controllers;

use App\Admin\Requests\ApproveLoanRequest;
use App\Admin\Requests\GetLoansRequest;
use App\Api\Transformers\LoanTransformer;
use App\Http\Controller;
use Domain\Loans\Actions\ApproveLoanAction;
use Domain\Loans\Models\Loan;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    public function get(GetLoansRequest $request): JsonResponse
    {
        $loans = Loan::paginate(10);

        return $this->respondWithPaginatedCollection(new LoanTransformer(), $loans);
    }

    public function approveLoan(ApproveLoanRequest $request, ApproveLoanAction $action): JsonResponse
    {
        $loan = $action->execute($request->getLoan()->id, $request->user()->id);

        return $this->respondOk(new LoanTransformer(), $loan);
    }
}
