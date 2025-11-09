<?php

namespace App\View\Components\User\Layout;

use Illuminate\View\Component;

class Home extends Component
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
        return view('components.user.layout.home');
    }
}
