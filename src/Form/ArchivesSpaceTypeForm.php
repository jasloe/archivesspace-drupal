<?php

namespace Drupal\archivesspace\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ArchivesSpaceTypeForm.
 */
class ArchivesSpaceTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $archivesspace_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $archivesspace_type->label(),
      '#description' => $this->t("Label for the ArchivesSpace type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $archivesspace_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\archivesspace\Entity\ArchivesSpaceType::load',
      ],
      '#disabled' => !$archivesspace_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $archivesspace_type = $this->entity;
    $status = $archivesspace_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label ArchivesSpace type.', [
          '%label' => $archivesspace_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label ArchivesSpace type.', [
          '%label' => $archivesspace_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($archivesspace_type->toUrl('collection'));
  }

}
