<?php namespace Pyro\Support;

use McCool\LaravelAutoPresenter\PresenterDecorator as BasePresenterDecorator;
use McCool\LaravelAutoPresenter\PresenterNotFoundException;

class PresenterDecorator extends BasePresenterDecorator
{
    /**
     * decorate an individual class
     *
     * @param mixed $atom
     * @return mixed
     */
    protected function decorateAtom($atom)
    {
        if ( ! isset($atom->presenterClass)) {
            return $atom;
        }

        if ($atom instanceOf Presenter) {
            return $atom;
        }

        $presenterClass = $atom->presenterClass;

        if ( ! class_exists($presenterClass)) {
            throw new PresenterNotFoundException($presenterClass);
        }

        if ($atom instanceOf Model) {
            $atom = $this->decorateRelations($atom);
        }

        return new $presenterClass($atom);
    }
}