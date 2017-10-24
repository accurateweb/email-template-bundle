<?php
/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\EmailTemplateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;


class SupportedVariablesType extends AbstractType
{
  public function getBlockPrefix()
  {
    return 'aw_email_templating_supported_variables';
  }
}