<?php
/**
 * Hook Loader - Registers all actions and filters
 */

if (!defined('ABSPATH')) {
    exit;
}

class AB2B_Loader {

    protected $actions = [];
    protected $filters = [];

    /**
     * Add action
     */
    public function add_action($hook, $component, $callback, $priority = 10, $args = 1) {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $args);
    }

    /**
     * Add filter
     */
    public function add_filter($hook, $component, $callback, $priority = 10, $args = 1) {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $args);
    }

    /**
     * Add hook to collection
     */
    private function add($hooks, $hook, $component, $callback, $priority, $args) {
        $hooks[] = [
            'hook'      => $hook,
            'component' => $component,
            'callback'  => $callback,
            'priority'  => $priority,
            'args'      => $args,
        ];
        return $hooks;
    }

    /**
     * Register all hooks
     */
    public function run() {
        foreach ($this->filters as $hook) {
            add_filter(
                $hook['hook'],
                [$hook['component'], $hook['callback']],
                $hook['priority'],
                $hook['args']
            );
        }

        foreach ($this->actions as $hook) {
            add_action(
                $hook['hook'],
                [$hook['component'], $hook['callback']],
                $hook['priority'],
                $hook['args']
            );
        }
    }
}
