<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\DataGrid;

use Accurateweb\EmailTemplateBundle\Email\Factory\EmailFactory;
use Accurateweb\EmailTemplateBundle\Template\EmailTemplate as EmailTemplatePrototype;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class ProxyQuery extends \Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
{
  private $emailFactory;

  private $class;

  private $entityManager;

  public function __construct(QueryBuilder $queryBuilder, $class,
    EmailFactory $emailFactory, EntityManager $entityManager)
  {
    $this->emailFactory = $emailFactory;
    $this->class = $class;
    $this->entityManager = $entityManager;

    parent::__construct($queryBuilder);
  }

  public function execute(array $params = array(), $hydrationMode = null)
  {
    $result = parent::execute($params, $hydrationMode);

    $templateList = $this->emailFactory->getTemplates();

    $newResult = new ArrayCollection();

    foreach ($templateList as $alias => $template)
    {
      $found = false;
      /* @var $template SmsTemplate */
      foreach ($result as $existingTemplateObject)
      {
        if ($existingTemplateObject->getAlias() == $alias)
        {
          $found = true;
          $newResult->append($existingTemplateObject);

          $existingTemplateObject->setDescription($template->getDescription());
          $existingTemplateObject->setSupportedVariables($template->getSupportedVariables());

          break;
        }
      }

      if (!$found)
      {
        $newTemplate = $this->createTemplateObject($template);

        $this->entityManager->persist($newTemplate);

        $newResult->add($newTemplate);
      }
    }

    $this->result = $newResult;

    return $newResult;
  }

  /**
   * Creates a template model for template
   *
   * @param $alias
   * @param EmailTemplate $template
   * @return
   */
  protected function createTemplateObject(EmailTemplatePrototype $template)
  {
    $obj = new $this->class();
    $obj->fromEmailTemplate($template);

    return $obj;
  }
}