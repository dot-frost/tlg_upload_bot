<?php

namespace App\Http\Controllers;

use App\Services\Telegram\Bot;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function webhook(Request $request, Bot $bot)
    {
        \Illuminate\Support\Facades\Log::info([
            "data" => $request->input("message")
        ]);
    }
}
