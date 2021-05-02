<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectComponent extends Component
{
    public $nameModel;
    public $field;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($nameModel, $field)
    {
        $this->nameModel = $nameModel;
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.select');
    }
}
