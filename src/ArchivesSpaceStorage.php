<?php

namespace Drupal\archivesspace;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\archivesspace\Entity\ArchivesSpaceInterface;

/**
 * Defines the storage handler class for ArchivesSpace entities.
 *
 * This extends the base storage class, adding required special handling for
 * ArchivesSpace entities.
 *
 * @ingroup archivesspace
 */
class ArchivesSpaceStorage extends SqlContentEntityStorage implements ArchivesSpaceStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ArchivesSpaceInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {archivesspace_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {archivesspace_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ArchivesSpaceInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {archivesspace_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('archivesspace_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
