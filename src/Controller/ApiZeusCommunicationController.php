<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 13/03/2019
 * Time: 12:07
 */

namespace Imanaging\ApiCommunicationBundle\Controller;

use Imanaging\ApiCommunicationBundle\ApiZeusCommunication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiZeusCommunicationController extends AbstractController
{
  private $apiZeusCommunication;

  public function __construct(ApiZeusCommunication $apiZeusCommunication)
  {
    $this->apiZeusCommunication = $apiZeusCommunication;
  }

  public function index()
  {
    return $this->json([
      'api_zeus_login' => $this->apiZeusCommunication->getApiZeusLogin(),
      'api_zeus_password' => $this->apiZeusCommunication->getApiZeusPassword(),
      'client_traitement' => $this->apiZeusCommunication->getClientTraitement()
    ]);
  }
}