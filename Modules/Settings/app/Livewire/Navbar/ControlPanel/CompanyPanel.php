<?php

namespace Modules\Settings\Livewire\Navbar\ControlPanel;

use Illuminate\Support\Facades\Route;
use Modules\App\Livewire\Components\Navbar\Button\ActionButton;
use Modules\App\Livewire\Components\Navbar\ControlPanel;
use Modules\App\Livewire\Components\Navbar\SwitchButton;


class CompanyPanel extends ControlPanel
{
    public $company;

    public function mount($company = null, $isForm = false)
    {
        $this->showBreadcrumbs = true;
        $this->generateBreadcrumbs();
        $this->filterTypes = [
            'status' => [
                'active' => 'active',    // string filter
                'suspended' => 'suspended',
                'banished' => 'banished',
            ],
        ];

        $this->new = route('settings.companies.create');
        if($company){
            $this->showIndicators = true;
            $this->company = $company;
            $this->isForm = true;
            $this->currentPage = $company->name;
        }else{
            $this->currentPage = "Enterprises";
        }

    }

    public function switchButtons() : array
    {
        return  [
            // make($key, $label)
            SwitchButton::make('lists',"switchView('lists')", "bi-list-task"),
            // SwitchButton::make('kanban',"switchView('kanban')", "bi-kanban"),
        ];
    }

}
