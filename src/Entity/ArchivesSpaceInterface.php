<?php

namespace Drupal\archivesspace\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining ArchivesSpace entities.
 *
 * @ingroup archivesspace
 */
interface ArchivesSpaceInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the ArchivesSpace name.
   *
   * @return string
   *   Name of the ArchivesSpace.
   */
  public function getName();

  /**
   * Sets the ArchivesSpace name.
   *
   * @param string $name
   *   The ArchivesSpace name.
   *
   * @return \Drupal\archivesspace\Entity\ArchivesSpaceInterface
   *   The called ArchivesSpace entity.
   */
  public function setName($name);

  /**
   * Gets the ArchivesSpace creation timestamp.
   *
   * @return int
   *   Creation timestamp of the ArchivesSpace.
   */
  public function getCreatedTime();

  /**
   * Sets the ArchivesSpace creation timestamp.
   *
   * @param int $timestamp
   *   The ArchivesSpace creation timestamp.
   *
   * @return \Drupal\archivesspace\Entity\ArchivesSpaceInterface
   *   The called ArchivesSpace entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the ArchivesSpace published status indicator.
   *
   * Unpublished ArchivesSpace are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the ArchivesSpace is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a ArchivesSpace.
   *
   * @param bool $published
   *   TRUE to set this ArchivesSpace to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\archivesspace\Entity\ArchivesSpaceInterface
   *   The called ArchivesSpace entity.
   */
  public function setPublished($published);

  /**
   * Gets the ArchivesSpace revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the ArchivesSpace revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\archivesspace\Entity\ArchivesSpaceInterface
   *   The called ArchivesSpace entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the ArchivesSpace revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the ArchivesSpace revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\archivesspace\Entity\ArchivesSpaceInterface
   *   The called ArchivesSpace entity.
   */
  public function setRevisionUserId($uid);

}
