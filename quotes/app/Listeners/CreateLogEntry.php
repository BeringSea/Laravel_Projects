<?php

namespace App\Listeners;

use App\Events\QuoteCreated;
use App\QuoteLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateLogEntry
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  QuoteCreated  $event
     * @return void
     */
    public function handle(QuoteCreated $event)
    {
        $author = $event->author_name;
        $log_entry = new QuoteLog();
        $log_entry->author = $author;
        $log_entry->save();
    }
}
