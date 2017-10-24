<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\Template\Loader;

use Doctrine\ORM\EntityManager;

class DoctrineTemplateLoader implements TemplateLoaderInterface
{
  /**
   * @var EntityManager
   */
  private $em;
  private $entity;

  /**
   * DoctrineTemplateLoader constructor.
   *
   * @param EntityManager $em
   */
  function __construct(EntityManager $em, $entity)
  {
    $this->em = $em;
    $this->entity = $entity;
  }

  /**
   * Loads template from database
   *
   * @param $templateName
   * @return
   */
  public function load($templateName)
  {
    //$entity = $this->em;
  }
}