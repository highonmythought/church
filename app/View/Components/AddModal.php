<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddModal extends Component
{
    public $id;
    public $title;
    public $action;
    public $fields;

    /**
     * Create a new component instance.
     */
    public function __construct($id, $title, $action, $fields)
    {
        $this->id = $id;
        $this->title = $title;
        $this->action = $action;
        $this->fields = $fields;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.add-modal');
    }
}
