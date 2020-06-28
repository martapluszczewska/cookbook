<?php
/**
 * Error controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ErrorController
 */
class ErrorController extends Controller
{
    /**
     * Access Denied action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(
     *     "/access_denied",
     *     name="access_denied"
     * )
     */
    public function accessDenied()
    {
        return $this->render('security/show.html.twig');
    }
}
