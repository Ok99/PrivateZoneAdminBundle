<?php

namespace Ok99\PrivateZoneCore\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class Ok99PrivateZoneAdminBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataAdminBundle';
    }
}
