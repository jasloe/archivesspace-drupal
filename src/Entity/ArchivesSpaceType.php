<?php

namespace Drupal\archivesspace\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the ArchivesSpace type entity.
 *
 * @ConfigEntityType(
 *   id = "archivesspace_type",
 *   label = @Translation("ArchivesSpace type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\archivesspace\ArchivesSpaceTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\archivesspace\Form\ArchivesSpaceTypeForm",
 *       "edit" = "Drupal\archivesspace\Form\ArchivesSpaceTypeForm",
 *       "delete" = "Drupal\archivesspace\Form\ArchivesSpaceTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\archivesspace\ArchivesSpaceTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "archivesspace_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "archivesspace",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/archivesspace_type/{archivesspace_type}",
 *     "add-form" = "/admin/structure/archivesspace_type/add",
 *     "edit-form" = "/admin/structure/archivesspace_type/{archivesspace_type}/edit",
 *     "delete-form" = "/admin/structure/archivesspace_type/{archivesspace_type}/delete",
 *     "collection" = "/admin/structure/archivesspace_type"
 *   }
 * )
 */
class ArchivesSpaceType extends ConfigEntityBundleBase implements ArchivesSpaceTypeInterface {

  /**
   * The ArchivesSpace type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The ArchivesSpace type label.
   *
   * @var string
   */
  protected $label;

}
