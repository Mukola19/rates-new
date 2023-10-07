<?php

namespace App\Console\ParsersHtml;





class ParserIndex
{
    public function __invoke()
    {
        ParserOschadbank::index();
        ParserPrivatbank::index();
        ParserBalance::index();

    }
}
