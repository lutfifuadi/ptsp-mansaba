<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AiService;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    protected $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function chat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:500',
            'history' => 'nullable|array',
            'history.*.role' => 'required|in:user,assistant',
            'history.*.content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Input tidak valid.'
            ], 422);
        }

        $message = strip_tags($request->message);

        $response = $this->aiService->generateResponse(
            $message,
            $request->history ?? []
        );

        return response()->json([
            'status' => 'success',
            'reply' => $response
        ]);
    }
}
