<?php

use Sculpin\Bundle\SculpinBundle\HttpKernel\AbstractKernel;

class SculpinKernel extends AbstractKernel
{
    protected function getAdditionalSculpinBundles()
    {
        return array(
          'Bcremer\Sculpin\Bundle\CommonMarkBundle\SculpinCommonMarkBundle',
        );
    }
}
