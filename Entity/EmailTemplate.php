<?php
/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\Entity;

use Accurateweb\EmailTemplateBundle\Template\EmailTemplateInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Email template entity
 *
 * @package Accurateweb\EmailTemplateBundle\Entity
 *
 * @ORM\MappedSuperclass()
 */
abstract class EmailTemplate implements EmailTemplateInterface
{
  /**
   * @var int
   *
   * @ORM\Column(type="string", length=64)
   * @ORM\Id()
   */
  protected $alias;

  /**
   * @var string
   *
   * @ORM\Column(length=255)
   */
  protected $subject;

  /**
   * @var string
   *
   * @ORM\Column(type="text")
   */
  protected $body;

  /**
   * @var string
   */
  protected $description;

  /**
   * @var array
   */
  protected $supportedVariables;

  public function getId()
  {
    return $this->getAlias();
  }

  /**
   * @return mixed
   */
  public function getAlias()
  {
    return $this->alias;
  }

  /**
   * @param mixed $alias
   * @return EmailTemplate
   */
  public function setAlias($alias)
  {
    $this->alias = $alias;
    return $this;
  }

  /**
   * @return string
   */
  public function getSubject()
  {
    return $this->subject;
  }

  /**
   * @param string $subject
   *
   * @return EmailTemplate
   */
  public function setSubject($subject)
  {
    $this->subject = $subject;

    return $this;
  }

  /**
   * @return string
   */
  public function getBody()
  {
    return $this->body;
  }

  /**
   * @param string $body
   *
   * @return EmailTemplate
   */
  public function setBody($body)
  {
    $this->body = $body;

    return $this;
  }

  /**
   * @return string
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * @param string $description
   *
   * @return EmailTemplate
   */
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * @return array
   */
  public function getSupportedVariables()
  {
    return $this->supportedVariables;
  }

  /**
   * @param array $supportedVariables
   * @return EmailTemplate
   */
  public function setSupportedVariables($supportedVariables)
  {
    $this->supportedVariables = $supportedVariables;

    return $this;
  }

  public function fromEmailTemplate(\Accurateweb\EmailTemplateBundle\Template\EmailTemplate $template)
  {
    $this->setAlias($template->getAlias());
    $this->setSubject($template->getSubject());
    $this->setBody($template->getBody());
    $this->setDescription($template->getDescription());
    $this->setSupportedVariables($template->getSupportedVariables());
  }
}