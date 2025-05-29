<?php

namespace Modules\Settings\Livewire\Navbar\ControlPanel;

use Illuminate\Support\Facades\Route;
use Modules\App\Livewire\Components\Navbar\Button\ActionButton;
use Modules\App\Livewire\Components\Navbar\Button\ActionDropdown;
use Modules\App\Livewire\Components\Navbar\ControlPanel;
use Modules\App\Livewire\Components\Navbar\SwitchButton;

class UserPanel extends ControlPanel
{
    public $user;

    public function mount($user = null, $isForm = false)
    {
        $this->showBreadcrumbs = true;
        $this->generateBreadcrumbs();
        $this->filterTypes = [
            'status' => [
                'confirmed' => 'Active',    // string filter
                'never-connected' => 'Inactive',
            ],
        ];

        $this->new = route('settings.users.create');
        if($user){
            $this->showIndicators = true;
            $this->user = $user;
            $this->isForm = true;
            $this->currentPage = $user->name;
        }else{
            $this->currentPage = "Users";
        }
    }

    public function switchButtons() : array
    {
        return  [
            // make($key, $label)
            SwitchButton::make('lists',"switchView('lists')", "bi-list-task"),
            SwitchButton::make('kanban',"switchView('kanban')", "bi-kanban"),
        ];
    }


    public function actionButtons(): array
    {
        return [
            ActionButton::make('export', 'Export All', 'exportAll', false, "fas fa-download"),
            ActionButton::make('import', 'Import Records', 'importRecords', false, "fas fa-upload"),
        ];
    }

    public function actionDropdowns(): array
    {
        return [
            ActionDropdown::make('export', 'Export', 'exportSelected', false, "fas fa-download"),
            ActionDropdown::make('delete', 'Delete', 'deleteSelectedItems', false, "fas fa-trash", true, "Do you really want to delete the selected items?"),
        ];
    }

    public function archiveUser(){
        $this->dispatch('archive-user');
    }

    public function duplicateUser(){
        $this->dispatch('duplicate-user');
    }

    public function deleteUser(){
        $this->dispatch('delete-user');
    }

    public function changePasswordUser(){
        $this->dispatch('change-pwd-user');
    }

    public function disable2Fa(){
        $this->dispatch('disable-2fa');
    }
}
