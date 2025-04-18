<?php

namespace Drupal\cffa_app_dash\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the Trustee Dashboard page.
 */
class ApplicantDash extends ControllerBase {

  /**
   * @var \Drupal\Core\Session\AccountInterface
   *   The user service.
   */
  protected $userService;

  /**
   * Constructs a TrusteeDash object.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The .
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
      '#theme' => 'applicant_dashboard',
      '#cache' => [
        'context' => [
          'user'
        ],
      ],
    ];

    $user = User::load($this->userService->id());
    $build['#user_first_name'] = $user->get('field_first_name')->value;
    // @todo: Check account access to create grant_application
    //$build['#create_access'] = FALSE;
    $build['#cache']['tags'] = [
      'user:' . $this->userService->id(),
    ];
    return $build;
  }

}
