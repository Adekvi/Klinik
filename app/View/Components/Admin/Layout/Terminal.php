<?php

namespace App\View\Components\Admin\Layout;

use Illuminate\View\Component;

class Terminal extends Component
{
    public string $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title = 'Dashboard')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.layout.terminal');
    }
}
