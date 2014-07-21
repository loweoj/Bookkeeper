<?php namespace Bookkeeper\Commanding\Base;

interface CommandHandler {

    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle($command);

} 