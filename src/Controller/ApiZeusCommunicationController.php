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
    $url = "/app/infos?login=".$this->apiZeusCommunication->getApiZeusLogin().'&password='.$this->apiZeusCommunication->getApiZeusPassword();
    $result = $this->apiZeusCommunication->sendGetRequest($url);
    $data = json_decode($result->getData());

    return $this->render('@ApiCommunication/Zeus/testing_page.html.twig', [
      'result' => $result,
      'data' => $data
    ]);
  }
}