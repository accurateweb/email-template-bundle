<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\Admin;

use Accurateweb\EmailTemplateBundle\Form\Type\SupportedVariablesType;
use Accurateweb\EmailTemplateBundle\Template\EmailTemplate;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EmailTemplateAdmin extends AbstractAdmin
{
  protected $translationDomain = 'EmailTemplateBundle';

  protected function configureFormFields(FormMapper $form)
  {
    $form
      ->add('SupportedVariables', SupportedVariablesType::class, array('label' => 'Available variables'))
      ->add('Subject', TextType::class, array('label' => 'Email subject template'))
      ->add('Body', TextareaType::class, array(
        'label' => 'Email body template',
        'attr' => array('rows' => 20)
      ));
  }

  protected function configureListFields(ListMapper $list)
  {
    $list
      ->add('Alias', NULL, ['label' => 'Алиас'])
      ->add('Description', NULL, ['label' => 'Описание'])
      ->add('_action', 'actions', array(
        'template' => 'SonataAdminBundle:CRUD:list__action.html.twig',
        'actions' => array(
//          'show' => array('template' => 'SonataAdminBundle:CRUD:list__action_show.html.twig'),
          'edit' => array('template' => 'SonataAdminBundle:CRUD:list__action_edit.html.twig'),
//          'delete' => array('template' => 'SonataAdminBundle:CRUD:list__action_delete.html.twig')
        ),
        'label'    => 'Действия'
      ));
  }

  protected function configureDatagridFilters(DatagridMapper $filter)
  {
    parent::configureDatagridFilters($filter);
  }

  protected function configureShowFields(ShowMapper $filter)
  {
    parent::configureShowFields($filter);
  }

  public function toString($object)
  {
    return $object instanceof EmailTemplate
      ? $object->getDescription()
      : 'Email Template';
  }

  protected function configureRoutes(RouteCollection $collection)
  {
    // to remove a single route
    $collection
      ->remove('show')
      ->remove('create')
      ->remove('delete');
    // OR remove all route except named ones
    //$collection->clearExcept(array('list', 'show'));
  }
}