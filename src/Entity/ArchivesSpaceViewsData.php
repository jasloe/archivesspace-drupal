<?php

namespace Drupal\archivesspace\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for ArchivesSpace entities.
 */
class ArchivesSpaceViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
