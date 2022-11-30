<?php

namespace App\Console\Commands;

use App\Services\Telegram\Bot;
use Illuminate\Console\Command;

class TelegramBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tlg_bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Telegram Bot';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bot = app()->make(Bot::class);
        $bot->deleteWebhook();
        $res = \json_decode((string) $bot->setWebhook()->getBody(), 1);

        $this->line($res["description"]);

        return Command::SUCCESS;
    }
}
