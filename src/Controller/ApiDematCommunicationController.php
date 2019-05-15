<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 13/03/2019
 * Time: 12:07
 */

namespace Imanaging\ApiCommunicationBundle\Controller;

use Imanaging\ApiCommunicationBundle\ApiDematCommunication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiDematCommunicationController extends AbstractController
{
  private $apiDematCommunication;

  public function __construct(ApiDematCommunication $apiDematCommunication)
  {
    $this->apiDematCommunication = $apiDematCommunication;
  }

  public function index()
  {
    $url = "/app/infos?login=".$this->apiDematCommunication->getApiDematLogin().'&password='.$this->apiDematCommunication->getApiDematPassword();
    $result = $this->apiDematCommunication->sendGetRequest($url);

    return $this->render('@ApiCommunication/Demat/testing_page.html.twig', [
      'result' => $result
    ]);
  }
}