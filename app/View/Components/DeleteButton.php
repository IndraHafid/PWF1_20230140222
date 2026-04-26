<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteButton extends Component
{
    public $url;
    public $title;
    public $confirmMessage;

    /**
     * Create a new component instance.
     */
    public function __construct($url, $title = 'Delete', $confirmMessage = 'Delete this item?')
    {
        $this->url = $url;
        $this->title = $title;
        $this->confirmMessage = $confirmMessage;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-button');
    }
}
