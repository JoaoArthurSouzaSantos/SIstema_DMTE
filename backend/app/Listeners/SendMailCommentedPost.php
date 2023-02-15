<?php

namespace App\Listeners;

use App\Events\AlarmeDepreciacao;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMailCommentedPost
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
     * @param  \App\Events\AlarmeDepreciacao  $event
     * @return void
     */
    public function handle(AlarmeDepreciacao $event)
    {
        //
    }
}
