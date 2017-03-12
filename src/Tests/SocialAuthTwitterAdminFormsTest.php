<?php

namespace Drupal\social_auth_twitter\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Test Social Auth Twitter module functionality of settings' forms.
 *
 * @group social_auth_twitter
 * @author Andriy Khomych
 */
class SocialAuthTwitterAdminFormsTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['social_api', 'social_auth', 'social_auth_twitter'];

  /**
   * A test user with corresponding permissions.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    // Create and log in an administrative user.
    $this->adminUser = $this->drupalCreateUser(
        array(
          'access administration pages',
          'administer social api widgets',
          'administer social api blocks',
          'administer social api autoposting',
          'administer social api authentication',
        )
    );
    $this->drupalLogin($this->adminUser);
  }

  /**
   * Test that module is available in social api list.
   */
  public function testIsAvailableInSocialApiList() {
    $this->drupalGet('admin/config/social-api/social-auth');
    // Assert that module is enabled in social api list.
    $this->assertText('social_auth_twitter');
  }

  /**
   * Test module settings form.
   */
  public function testSubmitSocialAuthTwitterSettingsForm() {
    $this->drupalGet('admin/config/social-api/social-auth/twitter');
    $edit = [
      'consumer_key' => 'consumer_key',
      'consumer_secret' => 'consumer_secret',
    ];
    $this->drupalPostForm('admin/config/social-api/social-auth/twitter', $edit, t('Save configuration'));
    $this->assertText('The configuration options have been saved.');
  }

}
