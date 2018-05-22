<?php

namespace Drupal\archivesspace;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the ArchivesSpace entity.
 *
 * @see \Drupal\archivesspace\Entity\ArchivesSpace.
 */
class ArchivesSpaceAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\archivesspace\Entity\ArchivesSpaceInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished archivesspace entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published archivesspace entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit archivesspace entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete archivesspace entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add archivesspace entities');
  }

}
