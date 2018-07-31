<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\Email\Factory;

use Accurateweb\EmailTemplateBundle\Event\EmailMessageEvent;
use Accurateweb\EmailTemplateBundle\Exception\TemplateNotFoundException;
use Accurateweb\EmailTemplateBundle\Model\Email;
use Accurateweb\EmailTemplateBundle\Template\Engine\TemplateEngineInterface;
use Accurateweb\EmailTemplateBundle\Template\Loader\TemplateLoaderInterface;
use Accurateweb\EmailTemplateBundle\Template\EmailTemplate;
use Accurateweb\EmailTemplateBundle\Template\EmailTemplateInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Email Factory
 *
 * @package Accurateweb\EmailTemplateBundle\Model
 */
class EmailFactory
{
  /**
   * @var TemplateLoaderInterface
   */
  private $loader;

  /**
   * @var TemplateEngineInterface
   */
  private $engine;

  /**
   * Known template list
   *
   * @var array
   */
  private $templates;

  private $imagesAsAttachments=false;

  private $eventDispatcher;

  /**
   * SmsFactory constructor.
   *
   * @param TemplateLoaderInterface $loader
   */
  public function __construct(TemplateLoaderInterface $loader, TemplateEngineInterface $engine, EventDispatcherInterface $eventDispatcher)
  {
    $this->loader = $loader;
    $this->engine = $engine;
    $this->eventDispatcher = $eventDispatcher;
    $this->templates = [];
  }

  /**
   * Adds a template to the list of known templates.
   *
   * If a template with given alias already exists, it will be replaced with a new one with given configuration
   *
   * @param string $alias
   * @param array $configuration
   */
  public function setTemplate($alias, $configuration)
  {
    $this->templates[$alias] = new EmailTemplate($alias, $configuration['description'],
      $configuration['defaults']['subject'], $configuration['defaults']['body'], $configuration['variables']);
  }

  /**
   * Returns a template for given alias
   *
   * @param string $alias Template alias
   * @return EmailTemplate An SMS Template
   * @throws TemplateNotFoundException
   */
  public function getTemplate($alias)
  {
    if (!isset($this->templates[$alias]))
    {
      throw new TemplateNotFoundException(sprintf('Email template "%s" is not registered', $alias));
    }

    return $this->templates[$alias];
  }

  /**
   * Returns a list of all templates
   *
   * @return EmailTemplate[]
   */
  public function getTemplates()
  {
    return $this->templates;
  }

  /**
   * Loads a template using the given loader
   *
   * @param String $templateName Template alias
   * @return EmailTemplateInterface Template object
   */
  protected function loadTemplate($templateName)
  {
    return $this->loader->load($templateName);
  }

  /**
   * Creates an Email for given template name and variable values
   *
   * @param EmailTemplateInterface|String $templateName Template instance or template name
   * @param array $values Variable values
   * @return Email Email object
   */
  public function createMessage($template, $from, $to, array $values=array())
  {
    if (!$template instanceof EmailTemplateInterface)
    {
      $template = $this->getTemplate($template);

      $this->loadTemplate($template);
    }

    $message = new \Swift_Message($this->engine->render($template->getSubject(), $values));
    $message
      ->setFrom($from)
      ->setTo($to)
      ->setBody(
        $this->engine->render($template->getBody(), $values),
        'text/html');

    $this->eventDispatcher->dispatch('aw.email.message.create', new EmailMessageEvent($message));

    return $message;
  }

  /**
   * @param bool $imagesAsAttachments
   * @return $this
   */
  public function setImagesAsAttachments ($imagesAsAttachments)
  {
    $this->imagesAsAttachments = $imagesAsAttachments;
    return $this;
  }
}