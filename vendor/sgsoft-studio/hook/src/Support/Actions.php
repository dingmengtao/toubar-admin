<?php namespace WebEd\Base\Hook\Support;

class Actions extends AbstractHookEvent
{
    /**
     * @param string $action
     * @param array $args
     */
    public function fire($action, array $args)
    {
        if ($this->getListeners()) {
            foreach ($this->getListeners() as $hook => $listeners) {
                foreach ($listeners as $arguments) {
                    if ($hook === $action) {
                        call_user_func_array($this->getFunction($arguments['callback']), $args);
                    }
                }
            }
        }
    }
}
