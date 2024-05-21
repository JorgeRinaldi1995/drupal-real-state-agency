<?php

namespace Drupal\realty\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Url;
use Drupal\realty\Entity\Realty;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class RealtyPublishController
 */
class RealtyPublishController extends ControllerBase {
  public function Render(Realty $realty) {
    // we set the moderation status to published
    $new_state = 'published';
    $realty->set('moderation_state', $new_state);
    if ($realty instanceof RevisionLogInterface) {
      $realty->setRevisionLogMessage('Changed moderation state to published');
      $realty->setRevisionUserId($this->currentUser()->id());
    }
    $realty->save();

    $publishedRealty = Url::fromRoute('entity.realty.canonical' , ['realty' => $realty->id()])->toString();

    \Drupal::messenger()->addMessage($realty->label() . ' is published.');

    return new RedirectResponse($publishedRealty);

  }

  public function Access(Realty $realty) {
    // securing no none is trying to publish realtys
    // that aren't theirs
    $access = AccessResult::allowedIf($realty->access('view'));
    // make sure state is draft
    if($realty->get('moderation_state')->getString() != 'draft') {
      $access = AccessResult::forbidden();
    }
    return $access;
  }
}