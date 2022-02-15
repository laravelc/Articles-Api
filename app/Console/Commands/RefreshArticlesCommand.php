<?php

namespace App\Console\Commands;

use App\Modules\API\Article\ArticleManager;
use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class RefreshArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh articles';

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
        $news->handle();

        return CommandAlias::SUCCESS;
    }
}
