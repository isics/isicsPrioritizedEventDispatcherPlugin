<?php

class isicsPrioritizedEventDispatcherProjectConfiguration extends sfProjectConfiguration
{
  /**
   * @{inheritDoc}
   */
  public function __construct($rootDir = null, sfEventDispatcher $dispatcher = null)
  {
    if (null === $dispatcher)
    {
      require_once __DIR__.'/EventDispatcher.class.php';

      $dispatcher = new EventDispatcher();
    }

    parent::__construct($rootDir, $dispatcher);
  }
}