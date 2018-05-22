<?php

namespace Drupal\archivesspace;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of ArchivesSpace entities.
 *
 * @ingroup archivesspace
 */
class ArchivesSpaceListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ArchivesSpace ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\archivesspace\Entity\ArchivesSpace */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.archivesspace.edit_form',
      ['archivesspace' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
