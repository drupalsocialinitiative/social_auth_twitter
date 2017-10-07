<?php

namespace Drupal\Tests\social_auth_twitter\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test Social Auth Twitter module functionality of settings' forms.
 *
 * @group social_auth
 *
 * @ingroup social_auth_linkedin
 */
class SocialAuthTwitterAdminFormTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['social_auth_twitter'];

  /**
   * The installation profile to use with this test.
   *
   * @var string
   */
  protected $profile = 'minimal';

  /**
   * A test user with no permissions.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $noPermsUser;

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

    // Create a non-administrative user.
    $this->noPermsUser = $this->drupalCreateUser();

    // Create an administrative user.
    $this->adminUser = $this->drupalCreateUser(
        [
          'access administration pages',
          'administer social api authentication',
        ]
    );
  }

  /**
   * Tests that module is available in social api list.
   */
  public function testIsAvailableInIntegrationList() {
    $this->drupalLogin($this->adminUser);
    $this->drupalGet('/admin/config/social-api/social-auth');

    // Assert that module is enabled in social auth list.
    $this->assertSession()->pageTextContains('social_auth_twitter');
  }

  /**
   * Tests configuration page.
   */
  public function testSettingsPage() {

    $assert = $this->assertSession();

    // Verifies that permissions are applied to the various defined paths.
    $forbidden_paths = [
      '/admin/config/social-api/social-auth/twitter',
    ];

    // Checks each of the paths to make sure we don't have access. At this point
    // we haven't logged in any users, so the client is anonymous.
    foreach ($forbidden_paths as $path) {
      $this->drupalGet($path);
      $assert->statusCodeEquals(403);
    }

    // Logs in user with no permissions.
    $this->drupalLogin($this->noPermsUser);

    // Should be the same result for forbidden paths, since the user needs
    // special permissions for these paths.
    foreach ($forbidden_paths as $path) {
      $this->drupalGet($path);
      $assert->statusCodeEquals(403);
    }

    // Logs in user with permissions.
    $this->drupalLogin($this->adminUser);

    // Forbidden paths aren't forbidden any more.
    foreach ($forbidden_paths as $unforbidden) {
      $this->drupalGet($unforbidden);
      $assert->statusCodeEquals(200);
    }

    // Now that we have the admin user logged in, check the menu links.
    $this->drupalGet('/admin/config/social-api/social-auth/twitter');
    $assert->pageTextContains('Settings');
    $assert->fieldExists('consumer_key');

  }

  /**
   * Test module settings form.
   */
  public function testSubmitSettingsForm() {
    $this->drupalLogin($this->adminUser);
    $this->drupalGet('/admin/config/social-api/social-auth/twitter');
    $edit = [
      'consumer_key' => 'consumer_key',
      'consumer_secret' => 'consumer_secret',
    ];
    $this->drupalPostForm('/admin/config/social-api/social-auth/twitter', $edit, t('Save configuration'));
    $this->assertSession()->pageTextContains('The configuration options have been saved.');
  }

}
