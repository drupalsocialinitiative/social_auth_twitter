<?php

namespace Drupal\social_auth_twitter\Settings;

/**
 * Defines an interface for Social Auth Twitter settings.
 */
interface TwitterAuthSettingsInterface {

  /**
   * Gets the consumer key.
   *
   * @return string
   *   The consumer key.
   */
  public function getConsumerKey();

  /**
   * Gets the consumer secret.
   *
   * @return string
   *   The consumer secret.
   */
  public function getConsumerSecret();

  /**
   * Gets a TwitterOAuth instance with oauth_token and oauth_token_secret.
   *
   * This method creates the SDK object by also passing the oauth_token and
   * oauth_token_secret. It is used for getting permanent tokens from
   * Twitter and authenticating users that has already granted permission.
   *
   * @param string $oauth_token
   *   The oauth token.
   * @param string $oauth_token_secret
   *   The oauth token secret.
   *
   * @return \Abraham\TwitterOAuth\TwitterOAuth
   *   The instance of the connection to Twitter.
   */
   public function getSdk2($oauth_token, $oauth_token_secret);
}
