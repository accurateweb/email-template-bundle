<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\Model;


use Accurateweb\EmailTemplateBundle\DataGrid\ProxyQuery;
use Accurateweb\EmailTemplateBundle\Exception\TemplateNotFoundException;
use Accurateweb\EmailTemplateBundle\Email\Factory\EmailFactory;
use Accurateweb\EmailTemplateBundle\Template\EmailTemplate;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager as BaseModelManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ModelManager extends BaseModelManager
{
  private $emailFactory;

  function __construct(RegistryInterface $registry, EmailFactory $emailFactory)
  {
    $this->emailFactory = $emailFactory;

    parent::__construct($registry);
  }

  public function createQuery($class, $alias = 'o')
  {
    $repository = $this->getEntityManager($class)->getRepository($class);

    return new ProxyQuery($repository->createQueryBuilder($alias), $class, $this->emailFactory,
      $this->registry->getManager());
  }

  public function find($class, $id)
  {
    $obj = $this->createQuery($class)
                ->getQueryBuilder()
                  ->where('o.alias = :alias')
                  ->setParameter('alias', $id)
                ->getQuery()
                ->getOneOrNullResult();

    try
    {
      $template = $this->emailFactory->getTemplate($id);

      if (!$obj)
      {
        $obj = new $class();
        $obj->fromEmailTemplate($template);

        $this->registry->getManager()->persist($obj);
      }
      else
      {
        $obj->setDescription($template->getDescription());
        $obj->setSupportedVariables($template->getSupportedVariables());
      }
    }
    catch (TemplateNotFoundException $e)
    {
      if ($obj)
      {
        $obj = null;
      }
    }

    return $obj;
  }
}