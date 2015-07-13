<?php

namespace AppBundle\Controller;

use Assetic\Extension\Twig\TwigFormulaLoader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/app/example", name="homepage")
     */
    public function indexAction()
    {
        $am = $this->get('assetic.asset_manager');

        $twig = $this->get('twig');

        dump($this->get('templating.finder')->findAllTemplates());

        return $this->render('default/index.html.twig');
    }
}
