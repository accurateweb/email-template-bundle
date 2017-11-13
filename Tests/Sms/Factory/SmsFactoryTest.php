<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */
class SmsFactoryTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
  private static $container,
                /**
                 * @var \Accurateweb\SmsBundle\Sms\Factory\EmailFactory
                 */
                 $smsFactory;

  public static function setUpBeforeClass()
  {
    //start the symfony kernel
    $kernel = static::createKernel();
    $kernel->boot();

    //get the DI container
    self::$container = $kernel->getContainer();

    //now we can instantiate our service (if you want a fresh one for
    //each test method, do this in setUp() instead
    self::$smsFactory = self::$container->get('aw_sms.template.factory');
  }

  public function testCreateSms()
  {
    $sms = self::$smsFactory->createSms('foo', ['bar' => 'baz']);

    $this->assertNotNull($sms);
  }
}