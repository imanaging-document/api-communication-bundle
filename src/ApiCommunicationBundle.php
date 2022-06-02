<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 11/03/2019
 * Time: 14:49
 */

namespace Imanaging\ApiCommunicationBundle;


use Imanaging\ApiCommunicationBundle\DependencyInjection\ApiCommunicationExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApiCommunicationBundle extends Bundle
{
  public function getContainerExtension() : ?ApiCommunicationExtension
  {
    if (null === $this->extension){
      $this->extension = new ApiCommunicationExtension();
    }

    return $this->extension;
  }

}