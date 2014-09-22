<?php

/**
 * EventDispatcher personnalisé pour gérer les priorités
 *
 * @author Julien Pottier <julien.pottier@isics.fr>
 */
class EventDispatcher extends sfEventDispatcher
{
  /**
   * Connects a listener to a given event name.
   *
   * @param string  $name      An event name
   * @param mixed   $listener  A PHP callable
   * @param int     $priority
   */
  public function connect($name, $listener, $priority = 0)
  {
    if (!isset($this->listeners[$name]))
    {
      $this->listeners[$name] = array();
    }
    if (!isset($this->listeners[$name][$priority]))
    {
      $this->listeners[$name][$priority] = array();
    }

    $this->listeners[$name][$priority][] = $listener;

    krsort($this->listeners[$name]);
  }

  /**
   * Disconnects a listener for a given event name.
   *
   * @param string   $name      An event name
   * @param mixed    $listener  A PHP callable
   *
   * @return mixed false if listener does not exist, null otherwise
   */
  public function disconnect($name, $listener)
  {
    if (!isset($this->listeners[$name]))
    {
      return false;
    }

    foreach ($this->listeners[$name] as $priority => $callables)
    {
      foreach ($callables as $i => $callable)
      {
        if ($listener === $callable)
        {
          unset($this->listeners[$name][$priority][$i]);
        }
      }

      if (0 === count($this->listeners[$name][$priority])) {
        unset($this->listeners[$name][$priority]);
      }
    }

    if (0 === count($this->listeners[$name])) {
      unset($this->listeners[$name]);
    }
  }

  /**
   * Returns all listeners associated with a given event name.
   *
   * @param  string   $name    The event name
   *
   * @return array  An array of listeners
   */
  public function getListeners($name)
  {
    if (!isset($this->listeners[$name]))
    {
      return array();
    }

    return array_reduce(
      $this->listeners[$name],
      function(array $memo, array $value)
      {
        return array_merge($memo, $value);
      },
      array()
    );
  }
}
