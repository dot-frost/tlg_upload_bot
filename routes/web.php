<?php

use App\Services\Telegram\Bot;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::any("tlg_webhook", function (Request $request, Bot $bot) {
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
    \Illuminate\Support\Facades\Log::info([
        "data" => $fileinfo
    ]);
    $filePath = $fileinfo["file_path"];

    $res = $bot->downloadFile($filePath);

    $http = new Client();

    // $res = Http::post("https://api.bayfiles.com/upload", [
    //     'headers' => [
    //         'Content-Type' => 'multipart/form-data',
    //     ],
    //     "multipart" => [
    //         [
    //             'name'     => 'file',
    //             'contents' => $res->getBody(),
    //             'filename' => 'file' . '.png'
    //         ]
    //     ],
    // ]);

    Log::info($res->getBody());
});
