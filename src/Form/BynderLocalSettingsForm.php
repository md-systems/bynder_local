<?php

namespace Drupal\bynder_local\Form;

use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form for Bynder Local settings.
 */
class BynderLocalSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'bynder_local.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'bynder_local_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $config = $this->config(static::SETTINGS);

    // Update options list with image fields associated with media bundles. This
    // is used with the form element below.
    $options = $this->getMediaBundleImageField();

    // Local image field - used to allow admin users to select the machine name
    // of an image field attached to a media bundle.
    $form['local_image_field'] = [
      '#type' => 'select',
      '#title' => $this->t('Machine name for image field:'),
      '#options' => $options,
      '#default_value' => $config->get('local_image_field'),
      '#description' => $this->t('Add the machine name of  field that needs populating with the Bynder image derivative.'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    // Provide the service we require via dependency injection. We don't want to
    // mess with the parent constructor, so we'll use setter injection for the
    // new dependency.
    $instance = parent::create($container);
    $instance->setEntityFieldManager($container->get('entity_field.manager'));

    return $instance;
  }

  /**
   * Sets entityFieldManager.
   */
  public function setEntityFieldManager(EntityFieldManagerInterface $entityFieldManager) {
    $this->entityFieldManager = $entityFieldManager;
  }

  /**
   * Returns a list of media bundle image fields.
   *
   * @return array
   *   An associative array of media bundle image fields, suitable to use as
   *   form options.
   */
  protected function getMediaBundleImageField() {
    $fields = $this->entityFieldManager->getFieldMapByFieldType('image');
    $fields = array_keys($fields['media']);

    // We end up with a list of field machine names (for both the key and the
    // value).
    return array_combine($fields, $fields);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    $config->set('local_image_field', $form_state->getValue('local_image_field'));
    $config->save();

    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

}
