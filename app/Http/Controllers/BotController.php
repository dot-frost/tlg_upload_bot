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

        $updateid = $request->get("update_id");
        $message = $request->get("message");

        $isPhoto = array_key_exists("photo", $message);
        $isDocument = array_key_exists("document", $message);
        $isAudio = array_key_exists("audio", $message);
        $isText = array_key_exists("text", $message);
        if ($isText) {
            $bot->request("deleteMessage", [
                "chat_id" => $message["chat"]["id"],
                "message_id" => $message["message_id"],
            ]);
            return;
        }

        $fileid = null;

        if ($isPhoto) {
            $fileid = array_pop($message["photo"])["file_id"];
        } else {
            $key = $isDocument ? "document" : "audio";
            $fileid = $message[$key]["file_id"];
        }

        $res = $bot->request("getFile", [
            "file_id" => $fileid
        ]);

        $fileinfo =  json_decode((string) $res->getBody(), 1)["result"];

        $filePath = $fileinfo["file_path"];

        $res = $bot->downloadFile($filePath);
    }
}
