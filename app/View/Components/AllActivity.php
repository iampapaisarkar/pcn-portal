<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Activity;

class AllActivity extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $application_id, $vendor_id;
    public function __construct($applicationID)
    {
        $this->application_id = $applicationID;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $activities = Activity::where('type', 'meptp')->where('application_id', $this->application_id)->get();
        // dd(0);
        return view('components.all-activity', compact('activities'));
    }
}
