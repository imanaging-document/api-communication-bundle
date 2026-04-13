<?php

declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle\Entity;

class RequestResult
{
  private ?string $httpCode = null;
  private ?string $data = null;
  private bool $error = false;
  private ?string $libelleError = null;
  private ?string $globalUrl = null;

  /**
   * @param array|null $postData
   */
  public function __construct(
    private string $url,
    private bool $postMode,
    private ?array $postData
  ) {
  }

  public function getHttpCode(): ?string
  {
    return $this->httpCode;
  }

  public function setHttpCode(?string $httpCode): void
  {
    $this->httpCode = $httpCode;
  }

  public function getData(): ?string
  {
    return $this->data;
  }

  public function setData(?string $data): void
  {
    $this->data = $data;
  }

  public function isError(): bool
  {
    return $this->error;
  }

  public function setError(bool $error): void
  {
    $this->error = $error;
  }

  public function getLibelleError(): ?string
  {
    return $this->libelleError;
  }

  public function setLibelleError(?string $libelleError): void
  {
    $this->libelleError = $libelleError;
  }

  public function getUrl(): string
  {
    return $this->url;
  }

  /**
   * @return array|null
   */
  public function getPostData(): ?array
  {
    return $this->postData;
  }

  public function isPostMode(): bool
  {
    return $this->postMode;
  }

  public function getGlobalUrl(): ?string
  {
    return $this->globalUrl;
  }

  public function setGlobalUrl(?string $globalUrl): void
  {
    $this->globalUrl = $globalUrl;
  }
}