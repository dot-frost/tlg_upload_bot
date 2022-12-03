<?php

namespace App\Models;

use App\Services\Telegram\Bot;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        "telegram_file_id",
        "name",
        "path",
        "size",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function url(): Attribute
    {
        return Attribute::get(fn () => Storage::disk("public")->url($this->path));
    }

    protected function telegramFile(): Attribute
    {
        return Attribute::get(function ($value, $attributes) {
            $bot = \app()->make(Bot::class);
            $res = $bot->request("getFile", [
                "file_id" => $attributes['telegram_file_id']
            ]);

            return \json_decode((string) $res->getBody(), true)["result"];
        })->shouldCache();
    }
}
