<?php
/**
 * Created by PhpStorm.
 * User: Dancy
 * Date: 09.11.2017
 * Time: 1:09
 */

namespace Accurateweb\EmailTemplateBundle\Model;


interface EmailTemplateRepositoryInterface
{
  public function find($id);
}