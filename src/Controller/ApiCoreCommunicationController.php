<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 13/03/2019
 * Time: 12:07
 */

namespace Imanaging\ApiCommunicationBundle\Controller;

use Imanaging\ApiCommunicationBundle\ApiCoreCommunication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApiCoreCommunicationController extends AbstractController
{
  private $apiCoreCommunication;

  public function __construct(ApiCoreCommunication $apiCoreCommunication)
  {
    $this->apiCoreCommunication = $apiCoreCommunication;
  }

  public function index()
  {
    $cryptedToken = hash('sha256', $this->apiCoreCommunication->getApiCoreToken());
    $url = "/app/infos?token=".$cryptedToken;
    $result = $this->apiCoreCommunication->sendGetRequest($url);
    $data = json_decode($result->getData());

    return $this->render('@ApiCommunication/Core/testing_page.html.twig', [
      'result' => $result,
      'data' => $data
    ]);
  }
}