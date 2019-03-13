<?php
/**
 * Created by PhpStorm.
 * User: antonin
 * Date: 06/07/2018
 * Time: 09:13
 */

namespace Imanaging\ApiCommunicationBundle\Entity;

class RequestResult
{
  private $httpCode;
  private $data;
  private $error;
  private $libelleError;
  private $url;
  private $postMode;
  private $postData;
  private $globalUrl;

  public function __construct($url, $postMode, $postData)
  {
    $this->httpCode = null;
    $this->data = null;
    $this->error = false;
    $this->libelleError = null;
    $this->url = $url;
    $this->postMode = $postMode;
    $this->postData = $postData;
    $this->globalUrl = null;
  }

  /**
   * @return null
   */
  public function getHttpCode()
  {
    return $this->httpCode;
  }

  /**
   * @param null $httpCode
   */
  public function setHttpCode($httpCode): void
  {
    $this->httpCode = $httpCode;
  }

  /**
   * @return null
   */
  public function getData()
  {
    return $this->data;
  }

  /**
   * @param null $data
   */
  public function setData($data): void
  {
    $this->data = $data;
  }

  /**
   * @return bool
   */
  public function isError(): bool
  {
    return $this->error;
  }

  /**
   * @param bool $error
   */
  public function setError(bool $error): void
  {
    $this->error = $error;
  }

  /**
   * @return null
   */
  public function getLibelleError()
  {
    return $this->libelleError;
  }

  /**
   * @param null $libelleError
   */
  public function setLibelleError($libelleError): void
  {
    $this->libelleError = $libelleError;
  }

  /**
   * @return null
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * @return null
   */
  public function getPostData()
  {
    return $this->postData;
  }

  /**
   * @return bool
   */
  public function isPostMode(): bool
  {
    return $this->postMode;
  }

  /**
   * @return null
   */
  public function getGlobalUrl()
  {
    return $this->globalUrl;
  }

  /**
   * @param null $globalUrl
   */
  public function setGlobalUrl($globalUrl): void
  {
    $this->globalUrl = $globalUrl;
  }
}