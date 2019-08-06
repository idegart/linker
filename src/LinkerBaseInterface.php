<?php

namespace Idegart\Linker;

interface LinkerBaseInterface
{
    public function storeLink(string $link) : string ;

    public function getRealLink(string $shortLink) : string ;
}
