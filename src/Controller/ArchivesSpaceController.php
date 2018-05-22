<?php

namespace Drupal\archivesspace\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\archivesspace\Entity\ArchivesSpaceInterface;

/**
 * Class ArchivesSpaceController.
 *
 *  Returns responses for ArchivesSpace routes.
 */
class ArchivesSpaceController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a ArchivesSpace  revision.
   *
   * @param int $archivesspace_revision
   *   The ArchivesSpace  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($archivesspace_revision) {
    $archivesspace = $this->entityManager()->getStorage('archivesspace')->loadRevision($archivesspace_revision);
    $view_builder = $this->entityManager()->getViewBuilder('archivesspace');

    return $view_builder->view($archivesspace);
  }

  /**
   * Page title callback for a ArchivesSpace  revision.
   *
   * @param int $archivesspace_revision
   *   The ArchivesSpace  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($archivesspace_revision) {
    $archivesspace = $this->entityManager()->getStorage('archivesspace')->loadRevision($archivesspace_revision);
    return $this->t('Revision of %title from %date', ['%title' => $archivesspace->label(), '%date' => format_date($archivesspace->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a ArchivesSpace .
   *
   * @param \Drupal\archivesspace\Entity\ArchivesSpaceInterface $archivesspace
   *   A ArchivesSpace  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ArchivesSpaceInterface $archivesspace) {
    $account = $this->currentUser();
    $langcode = $archivesspace->language()->getId();
    $langname = $archivesspace->language()->getName();
    $languages = $archivesspace->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $archivesspace_storage = $this->entityManager()->getStorage('archivesspace');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $archivesspace->label()]) : $this->t('Revisions for %title', ['%title' => $archivesspace->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all archivesspace revisions") || $account->hasPermission('administer archivesspace entities')));
    $delete_permission = (($account->hasPermission("delete all archivesspace revisions") || $account->hasPermission('administer archivesspace entities')));

    $rows = [];

    $vids = $archivesspace_storage->revisionIds($archivesspace);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\archivesspace\ArchivesSpaceInterface $revision */
      $revision = $archivesspace_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $archivesspace->getRevisionId()) {
          $link = $this->l($date, new Url('entity.archivesspace.revision', ['archivesspace' => $archivesspace->id(), 'archivesspace_revision' => $vid]));
        }
        else {
          $link = $archivesspace->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.archivesspace.translation_revert', ['archivesspace' => $archivesspace->id(), 'archivesspace_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.archivesspace.revision_revert', ['archivesspace' => $archivesspace->id(), 'archivesspace_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.archivesspace.revision_delete', ['archivesspace' => $archivesspace->id(), 'archivesspace_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['archivesspace_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
