<?php

namespace Nossis\NossisBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NossisBundle extends Bundle
{
    
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
