<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Telegram\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BotController extends Controller
{

    const COMMANDS = [
        '/start' => "start",
        '/upload' => 'upload',
        '/files' => null,
    ];

    public function __construct(private Bot $bot)
    {
    }

    public function webhook(Request $request)
    {
        $update = $request->all();
        if (array_key_exists("my_chat_member", $update)) {
            return;
        }
        $message = $request->input("message");
        Log::info($request);

        $this->proccessMessageForLastCommant($message);
    }

    public function proccessMessageForLastCommant($message)
    {
        if (!$message["from"]) return;

        $user = $this->login($message["from"]);

        if ($this->isCommand($message)) {
            $command = $message['text'];
            $this->setLastCommand($user, $command);
            $commandMethod = static::COMMANDS[$command];
            $this->$commandMethod($message, $user);
        } elseif ($command = $this->getLastCommand($user)) {
            $commandMethod = static::COMMANDS[$command];
            $this->$commandMethod($message, $user);
        }
    }

    public function getLastCommandKey(User $user)
    {
        return "user_last_command{$user->id}";
    }


    public function setLastCommand(User $user, $command)
    {
        return Cache::put($this->getLastCommandKey($user), $command);
    }

    public function getLastCommand(User $user)
    {
        return Cache::get($this->getLastCommandKey($user), null);
    }

    public function login($from)
    {
        $firstName = $from["first_name"];
        $lastName =  array_key_exists("last_name", $from) ? $from["last_name"] : "";

        $fullName = trim($firstName . " " . $lastName);
        $role = $from["is_bot"] ? User::ROLES["BOT"] : User::ROLES["USER"];

        $user = User::firstOrCreate(
            ["id" => $from["id"]],
            [
                "name" => $fullName,
                "role" => $role,
            ]
        );

        \auth()->login($user);
        return $user;
    }

    public function start($message, User|null $user)
    {
        $chat = $message["chat"];

        $this->bot->request("sendMessage", [
            "chat_id" => $chat["id"],
            "text" => "Welcome",
            "reply_to_message_id" => $message["message_id"],
        ]);

        $this->setLastCommand($user, null);
    }

    public function upload($message, User|null $user)
    {
        if ($this->isCommand($message)) {
            $this->bot->request("sendMessage", [
                "chat_id" => $message["chat"]["id"],
                "text" => "فایل مورد نظر را آپلود کنید",
                "reply_to_message_id" => $message["message_id"]
            ]);
            return;
        }

        $files = $this->getFiles($message);
        if (!array_key_exists("document", $files)) {
            $this->bot->request("deleteMessage", [
                "chat_id" => $message["chat"]["id"],
                "message_id" => $message["message_id"]
            ]);
            return;
        }
        $document = $files["document"];

        $fileInfo = $this->bot->request("getFile", [
            "file_id" => $document["file_id"]
        ])->getBody()->getContents();

        $fileInfo = \json_decode($fileInfo, \true)['result'];

        $file = $this->bot->downloadFile($fileInfo["file_path"])->getBody()->getContents();
        $fileName = $document["file_name"];
        $path = "files/{$user->id}/{$message['date']}_$fileName";
        Storage::disk("public")->put($path, $file);
        $this->bot->request("sendMessage", [
            "chat_id" => $message["chat"]["id"],
            "text" => Storage::disk("public")->url($path),
            "reply_to_message_id" => $message["message_id"],
        ]);

        $this->setLastCommand($user, null);
    }

    public function getFiles($message)
    {
        $files = [];

        if (array_key_exists("document", $message)) {
            $files["document"] = $message["document"];
        }

        if (\array_key_exists("photo", $message)) {
            $files["photo"] = $message["photo"];
        }

        if (\array_key_exists("audio", $message)) {
            $files["audio"] = $message["audio"];
        }

        if (\array_key_exists("voice", $message)) {
            $files["voice"] = $message["voice"];
        }

        if (\array_key_exists("video", $message)) {
            $files["video"] = $message["video"];
        }

        return $files;
    }

    public function isCommand($message)
    {
        return array_key_exists($message["text"] ?? "isNotTextMessage", static::COMMANDS);
    }
}
