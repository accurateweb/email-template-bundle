<?php
/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SupportedVariablesType extends AbstractType
{
  public function configureOptions(OptionsResolver $resolver)
  {
    parent::configureOptions($resolver);

    $resolver->setDefault('required', false);
  }

  public function getBlockPrefix()
  {
    return 'aw_email_templating_supported_variables';
  }
}