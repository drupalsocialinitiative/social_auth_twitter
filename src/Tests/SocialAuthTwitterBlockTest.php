<?php

namespace Drupal\social_auth_twitter\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests block module functionality.
 *
 * @group social_auth_twitter
 * @author Andriy Khomych
 */
class SocialAuthTwitterBlockTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['block', 'test_page_test', 'social_api', 'social_auth', 'social_auth_twitter'];

  /**
   * The block entity.
   *
   * @var \Drupal\block\Entity\Block
   */
  protected $socialAuthLoginBlock;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->socialAuthLoginBlock = $this->drupalPlaceBlock("social_auth_login", array('label' => 'Social auth login', 'id' => 'social_auth_login'));
    $this->socialAuthLoginBlock->getPlugin()->setConfigurationValue('label_display', 1);
    $this->socialAuthLoginBlock->save();
  }

  /**
   * Test that twitter link in social auth block exists.
   */
  public function testExistsTwitterLinkgInSocialAuthBlock() {
    // Confirm that the block is now being displayed on pages.
    $this->drupalGet('test-page');
    // Block exists.
    $this->assertText($this->socialAuthLoginBlock->label(), 'Social auth login.');
    // Twitter login link exists.
    $link = $this->xpath('//a[@href = :href]', array(':href' => '/user/login/twitter'));
    $this->assertEqual((string) $link[0]['href'], '/user/login/twitter');
  }

}
