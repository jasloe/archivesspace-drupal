<?php

namespace Drupal\archivesspace;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface ArchivesSpaceStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of ArchivesSpace revision IDs for a specific ArchivesSpace.
   *
   * @param \Drupal\archivesspace\Entity\ArchivesSpaceInterface $entity
   *   The ArchivesSpace entity.
   *
   * @return int[]
   *   ArchivesSpace revision IDs (in ascending order).
   */
  public function revisionIds(ArchivesSpaceInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as ArchivesSpace author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   ArchivesSpace revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\archivesspace\Entity\ArchivesSpaceInterface $entity
   *   The ArchivesSpace entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ArchivesSpaceInterface $entity);

  /**
   * Unsets the language for all ArchivesSpace with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
