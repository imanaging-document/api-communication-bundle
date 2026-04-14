<?php

declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle\Entity;

class RequestResult
{
  private ?int $httpCode = null;
  private ?string $data = null;
  private bool $error = false;
  private ?string $libelleError = null;
  private ?string $globalUrl = null;

  /**
   * @param mixed $postData
   */
  public function __construct(
    private string $url,
    private bool $postMode,
    private mixed $postData
  ) {
  }

  public function getHttpCode(): ?int
  {
    return $this->httpCode;
  }

  public function setHttpCode(?int $httpCode): void
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
   * @return mixed
   */
  public function getPostData(): mixed
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