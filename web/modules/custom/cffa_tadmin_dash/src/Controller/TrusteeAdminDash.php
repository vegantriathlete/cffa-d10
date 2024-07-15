<?php

namespace Drupal\cffa_tadmin_dash\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the Trustee Dashboard page.
 */
class TrusteeAdminDash extends ControllerBase {

  /**
   * @var \Drupal\Core\Session\AccountInterface
   *   The current user service.
   */
  protected $userService;

  /**
   * Constructs a TrusteeAdminDash object.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user service.
   */
  public function __construct(AccountInterface $user_service) {
    $this->userService = $user_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
    );
  }

  /**
   * Generates the Trustee Dashboard
   *
   * @return array
   *   An array as expected by \Drupal\Core\Render\RendererInterface::render().
   */
  public function build() {
    $build = [
      '#theme' => 'trustee_admin_dashboard',
      '#cache' => [
        'context' => [
          'user'
        ],
      ],
    ];

    $user = User::load($this->userService->id());
    $build['#user_first_name'] = $user->get('field_first_name')->value;
    $build['#cache']['tags'] = [
      'user:' . $this->userService->id(),
    ];
    return $build;
  }

}
