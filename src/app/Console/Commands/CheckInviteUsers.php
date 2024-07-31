<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckInviteUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:invite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверяет активировал-ли юзер аккаунт после приглашения по email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('logged_in', false)
            ->where('created_at', '<', Carbon::now()->subWeek())
            ->get();

        foreach ($users as $user){
            $user->delete();
            $this->info('Пользователь удален!');
        }

        $this->info('Все пользователи удалены!');
    }
}
