<?php

namespace Drupal\social_auth_twitter\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests basic module functionality (login, register via twitter).
 *
 * @TODO: Add `Simulate external API calls` as on https://www.drupal.org/node/30011
 *
 * @group social_auth_twitter
 * @author Andriy Khomych
 */
class SocialAuthTwitterBasicTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['social_api', 'social_auth', 'social_auth_twitter'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
  }

}
