<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MagicTokenVerifyRequest;
use App\Services\SiteService\MagicLoginService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MagicLoginController extends Controller
{
    public function verifyMagicToken(MagicTokenVerifyRequest $request, MagicLoginService $magicLoginService)
    {
        $site = $magicLoginService->getSiteByToken(token: $request->token);

        if (!$site) {
            return $this->errorResponse(message: 'Invalid token', code: Response::HTTP_BAD_REQUEST);
        }

        return $this->successResponse(data: [
            'is_valid' => true,
        ]);
    }
}
