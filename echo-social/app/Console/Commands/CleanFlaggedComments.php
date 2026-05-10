<?php

namespace App\Console\Commands;

use App\Models\Comment;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CleanFlaggedComments extends Command
{
    protected $signature = 'comments:clean';
    protected $description = 'Elimina i commenti flaggati non revisionati dopo 7 giorni';

    public function handle()
    {
        $deleted = Comment::where('isFlagged', true)
            ->where(function ($query) {
                $query->where('reviewStatus', 'rejected')
                      ->orWhere(function ($q) {
                          $q->whereNull('reviewStatus')
                            ->where('flaggedAt', '<=', Carbon::now()->subDays(7));
                      });
            })
            ->delete();

        $this->info("Eliminati {$deleted} commenti flaggati.");
    }
}