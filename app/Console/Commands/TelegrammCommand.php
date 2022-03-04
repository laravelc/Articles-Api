<?php

namespace App\Console\Commands;

use App\Modules\API\Article\ArticleManager;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class TelegrammCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Telegram send';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ArticleManager $news
     * @return int
     * @throws Exception
     */
    public function handle(ArticleManager $news): int
    {
        /**
         * Создаем 2 кнопки
         */
        Telegraph::message('hello world')
            ->keyboard(Keyboard::make()->buttons([
                Button::make('Delete')->action('delete')->param('id', '42'),
                Button::make('open')->url('https://test.it'),
            ]))->send();


        $this->checkStatus();
        $this->chatSend();

        $this->chunk();


        return CommandAlias::SUCCESS;
    }

    /**
     * @return void
     */
    public function checkStatus(): void
    {
        $response = Telegraph::message('hello')->send();

        $response->successful();
        $response->ok();
        $response->failed();
        $response->body();
        $response->json('path.to.json.data', 'default');
    }

    /**
     * @return void
     */
    public function chatSend(): void
    {
        $chat = TelegraphChat::find(44);

// this will use the default parsing method set in config/telegraph.php
        $chat->message('hello')->send();

        $chat->html("<b>hello<b>\n\nI'm a bot!")->send();

        $chat->markdown('*hello*')->send();
    }

    /**
     * @param $notification
     * @return void
     */
    public function chunk($notification): void
    {
        //Вывод элементов последовательно
        Telegraph::message('hello world')
            ->keyboard(
                Keyboard::make()->buttons([
                    Button::make("🗑️ Delete")->action("delete")->param('id', $notification->id),
                    Button::make("📖 Mark as Read")->action("read")->param('id', $notification->id),
                    Button::make("👀 Open")->url('https://test.it'),
                ])->chunk(2))->send();
    }
}
