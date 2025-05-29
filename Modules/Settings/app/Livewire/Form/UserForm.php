<?php

namespace Modules\Settings\Livewire\Form;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Modules\App\Livewire\Components\Form\Button\ActionBarButton;
use Modules\App\Livewire\Components\Form\Button\StatusBarButton;
use Modules\App\Livewire\Components\Form\Template\SimpleAvatarForm;
use Modules\App\Livewire\Components\Form\Input;
use Modules\App\Livewire\Components\Form\Tabs;
use Modules\App\Livewire\Components\Form\Group;
use Modules\App\Traits\Form\Button\ActionBarButton as ActionBarButtonTrait;
use Modules\Settings\Models\Language\Language;

class UserForm extends SimpleAvatarForm
{
    use ActionBarButtonTrait;
    public $user;
    public $name, $email, $phone, $role, $language, $timezone;
    public array $rolesOptions = [], $languageOptions = [], $timezoneOptions = [];

    // Define validation rules
    protected $rules = [
        'name' => 'required|string|max:30',
        'phone' => 'nullable|string',
        'email' => 'required|email',
        'role' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'language' => 'nullable|integer|exists:languages,id',
        'timezone' => 'nullable|string',
    ];

    public function mount($user = null){
        $this->status = 'never-connected';
        if($user){
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->role = $user->role;
            $this->image_path = $user->avatar;
            $this->language = $user->language_id;
            $this->timezone = $user->timezone;
            $this->status = $user->last_login_at ? 'confirmed' : 'never-connected';
        }

        $roles = [
            ['id' => 'owner', 'label' => __('Owner')],
            ['id' => 'manager', 'label' => __('Hotel/General Manager')],
            ['id' => 'front-desk', 'label' => __('Front Desk / Receptionist')],
            ['id' => 'maintenance-staff', 'label' => __('Maintenance Staff')],
            ['id' => 'accountant', 'label' => __('Accountant')],
        ];
        $this->rolesOptions = toSelectOptions($roles, 'id', 'label');

        $admin = [
            ['id' => 'settings', 'label' => 'Settings'],
            ['id' => 'access-right', 'label' => 'Access Rights'],
        ];

        $this->languageOptions = toSelectOptions(Language::all(), 'id', 'name');
        $timezones = [
            ['id' => 'utc', 'label' => 'UTC (Coordinated Universal Time)'],
            ['id' => 'gst', 'label' => 'Greenwich Standard Time (GST) - United Kingdom'],
            ['id' => 'wet', 'label' => 'Western European Time (WET) - Ireland, Portugal'],
            ['id' => 'cet', 'label' => 'Central European Time (CET) - Austria, Belgium, France, Germany, Italy, Luxembourg, Netherlands, Spain, Switzerland'],
            ['id' => 'eet', 'label' => 'Eastern European Time (EET) - Bulgaria, Cyprus, Estonia, Finland, Greece, Hungary, Latvia, Lithuania, Malta, Romania'],
            ['id' => 'fnt', 'label' => 'Fernando de Noronha Time (FNT) - Brazil (Fernando de Noronha)'],
            ['id' => 'brt', 'label' => 'Brasília Time (BRT) - Brazil'],
            ['id' => 'uat', 'label' => 'Uruguay Time (UYT) - Uruguay'],
            ['id' => 'art', 'label' => 'Argentina Time (ART) - Argentina'],
            ['id' => 'clt', 'label' => 'Chile Time (CLT) - Chile'],
            ['id' => 'pyt', 'label' => 'Paraguay Time (PYT) - Paraguay'],
            ['id' => 'bost', 'label' => 'Bolivia Time (BOST) - Bolivia'],
            ['id' => 'pht', 'label' => 'Philippine Time (PHT) - Philippines'],
            ['id' => 'aest', 'label' => 'Australian Eastern Standard Time (AEST) - Queensland, New South Wales, Victoria, ACT, Tasmania'],
            ['id' => 'acst', 'label' => 'Australian Central Standard Time (ACST) - South Australia, Northern Territory'],
            ['id' => 'awst', 'label' => 'Australian Western Standard Time (AWST) - Western Australia'],
            ['id' => 'nzt', 'label' => 'New Zealand Time (NZT) - New Zealand'],
            ['id' => 'chast', 'label' => 'Chatham Standard Time (CHAST) - Chatham Islands, New Zealand'],
            ['id' => 'sst', 'label' => 'Samoa Standard Time (SST) - Samoa, American Samoa'],
            ['id' => 'cst', 'label' => 'China Standard Time (CST) - China'],
            ['id' => 'jst', 'label' => 'Japan Standard Time (JST) - Japan'],
            ['id' => 'kst', 'label' => 'Korea Standard Time (KST) - South Korea, North Korea'],
            ['id' => 'ist', 'label' => 'Indian Standard Time (IST) - India'],
            ['id' => 'slt', 'label' => 'Sri Lanka Time (SLT) - Sri Lanka'],
            ['id' => 'myt', 'label' => 'Malaysia Time (MYT) - Malaysia'],
            ['id' => 'sgt', 'label' => 'Singapore Time (SGT) - Singapore'],
            ['id' => 'ict', 'label' => 'Indochina Time (ICT) - Thailand, Vietnam, Laos, Cambodia'],
            ['id' => 'wib', 'label' => 'Western Indonesian Time (WIB) - Indonesia (Sumatra, Java, West Kalimantan)'],
            ['id' => 'wit', 'label' => 'Central Indonesian Time (WIT) - Indonesia (Sulawesi, Bali, Nusa Tenggara)'],
            ['id' => 'wita', 'label' => 'Eastern Indonesian Time (WITA) - Indonesia (Maluku, Papua)'],
            ['id' => 'aft', 'label' => 'Afghanistan Time (AFT) - Afghanistan'],
            ['id' => 'irt', 'label' => 'Iran Time (IRT) - Iran'],
            ['id' => 'pst', 'label' => 'Pakistan Standard Time (PKT) - Pakistan'],
            ['id' => 'ast', 'label' => 'Arabia Standard Time (AST) - Saudi Arabia, UAE, Oman, Qatar, Bahrain, Kuwait'],
            ['id' => 'mst', 'label' => 'Moscow Standard Time (MSK) - Russia (Moscow)'],
            ['id' => 'azt', 'label' => 'Azerbaijan Time (AZT) - Azerbaijan'],
            ['id' => 'gst', 'label' => 'Georgia Standard Time (GET) - Georgia'],
            ['id' => 'amt', 'label' => 'Armenia Time (AMT) - Armenia'],
            ['id' => 'trt', 'label' => 'Turkey Time (TRT) - Turkey'],
            ['id' => 'eet', 'label' => 'Israel Standard Time (IST) - Israel'],
            ['id' => 'eet', 'label' => 'Lebanon Standard Time (EET) - Lebanon'],
            ['id' => 'eet', 'label' => 'Syria Standard Time (EET) - Syria'],
            ['id' => 'eet', 'label' => 'Jordan Standard Time (EET) - Jordan'],
            ['id' => 'eet', 'label' => 'Palestine Standard Time (EET) - Palestine'],
            ['id' => 'eet', 'label' => 'Iraq Standard Time (AST) - Iraq'],
            ['id' => 'eet', 'label' => 'Gaza Standard Time (EET) - Gaza Strip'],
            ['id' => 'eat', 'label' => 'East Africa Time (EAT) - Kenya, Tanzania, Uganda, Ethiopia'],
            ['id' => 'cat', 'label' => 'Central Africa Time (CAT) - Cameroon, Chad, Congo, Rwanda, Burundi'],
            ['id' => 'wat', 'label' => 'West Africa Time (WAT) - Nigeria, Niger, Ghana, Senegal'],
            ['id' => 'gmt', 'label' => 'Greenwich Mean Time (GMT) - Senegal, Gambia, Guinea-Bissau, Guinea, Sierra Leone, Liberia, Mali, Côte d\'Ivoire, Burkina Faso, Ghana, Togo'],
            ['id' => 'cvst', 'label' => 'Cape Verde Standard Time (CVT) - Cape Verde'],
            ['id' => 'sast', 'label' => 'South Africa Standard Time (SAST) - South Africa, Lesotho, Eswatini'],
            ['id' => 'mut', 'label' => 'Mauritius Time (MUT) - Mauritius'],
            ['id' => 'sct', 'label' => 'Seychelles Time (SCT) - Seychelles'],
            ['id' => 'pst', 'label' => 'Pacific Standard Time (PST) - USA (California, Washington, Oregon)'],
            ['id' => 'mst', 'label' => 'Mountain Standard Time (MST) - USA (Colorado, Idaho, Montana, New Mexico, Utah, Wyoming)'],
            ['id' => 'cst', 'label' => 'Central Standard Time (CST) - USA (Illinois, Indiana, Michigan, Minnesota, Missouri, Texas, Wisconsin)'],
            ['id' => 'est', 'label' => 'Eastern Standard Time (EST) - USA (New York, Pennsylvania, Georgia, Florida, Ohio)'],
            ['id' => 'ast', 'label' => 'Atlantic Standard Time (AST) - Canada (Nova Scotia, New Brunswick, Prince Edward Island, Newfoundland and Labrador)'],
            ['id' => 'hst', 'label' => 'Hawaii-Aleutian Standard Time (HST) - USA (Hawaii)'],
            ['id' => 'akst', 'label' => 'Alaska Standard Time (AKST) - USA (Alaska)'],
            ['id' => 'chut', 'label' => 'Chuuk Time (CHUT) - Federated States of Micronesia (Chuuk)'],
            ['id' => 'kst', 'label' => 'Kosrae Time (KST) - Federated States of Micronesia (Kosrae)'],
            ['id' => 'pgt', 'label' => 'Papua New Guinea Time (PGT) - Papua New Guinea'],
            ['id' => 'sbt', 'label' => 'Solomon Islands Time (SBT) - Solomon Islands'],
            ['id' => 'vut', 'label' => 'Vanuatu Time (VUT) - Vanuatu'],
            ['id' => 'nct', 'label' => 'New Caledonia Time (NCT) - New Caledonia'],
            ['id' => 'fjt', 'label' => 'Fiji Time (FJT) - Fiji'],
            ['id' => 'tvt', 'label' => 'Tuvalu Time (TVT) - Tuvalu'],
            ['id' => 'wft', 'label' => 'Wallis and Futuna Time (WFT) - Wallis and Futuna'],
            ['id' => 'nft', 'label' => 'Norfolk Time (NFT) - Norfolk Island'],
            ['id' => 'aft', 'label' => 'Afghanistan Time (AFT) - Afghanistan'],
            ['id' => 'cct', 'label' => 'Cocos Islands Time (CCT) - Cocos (Keeling) Islands'],
            ['id' => 'mht', 'label' => 'Marshall Islands Time (MHT) - Marshall Islands'],
            ['id' => 'krat', 'label' => 'Krasnoyarsk Time (KRAT) - Russia (Krasnoyarsk)'],
            ['id' => 'yakt', 'label' => 'Yakutsk Time (YAKT) - Russia (Yakutsk)'],
            ['id' => 'vlat', 'label' => 'Vladivostok Time (VLAT) - Russia (Vladivostok)'],
            ['id' => 'magt', 'label' => 'Magadan Time (MAGT) - Russia (Magadan)'],
            ['id' => 'anat', 'label' => 'Anadyr Time (ANAT) - Russia (Anadyr)'],
            ['id' => 'pet', 'label' => 'Peru Time (PET) - Peru'],
            ['id' => 'clt', 'label' => 'Chile Time (CLT) - Chile'],
            ['id' => 'cct', 'label' => 'Cuba Time (CST) - Cuba'],
            ['id' => 'ect', 'label' => 'Ecuador Time (ECT) - Ecuador'],
            ['id' => 'gst', 'label' => 'Guyana Time (GYT) - Guyana'],
            ['id' => 'srt', 'label' => 'Suriname Time (SRT) - Suriname'],
            ['id' => 'vst', 'label' => 'Venezuela Time (VET) - Venezuela'],
        ];
        $this->timezoneOptions = toSelectOptions($timezones, 'id', 'label');
    }


    public function tabs() : array
    {
        return [
            Tabs::make('general',__('Access Rights')),
            Tabs::make('preferences',__('Preferences'), null, true),
        ];
    }

    public function groups() : array
    {
        return [
            Group::make('roles',__("Role & Access"), 'general'),
            Group::make('localization',__("Localization"), 'preferences'),
        ];
    }

    public function inputs(): array
    {
        return [
            Input::make('name', "Name", 'text', 'name', 'top-title', 'none', 'none', __('e.g. Arden BOUET'))->component('app::form.input.ke-title'),
            Input::make('email', "Email", 'email', 'email', 'top-title', 'none', 'none', __('e.g. email@yourcompany.com'))->component('app::form.input.ke-title-2'),
            Input::make('phone', "Phone", 'tel', 'phone', 'top-title', 'none', 'none', __('e.g. +254745908026'))->component('app::form.input.ke-title-2'),

            Input::make('role', 'Role', 'select', 'role', 'top-title', 'general', 'roles', "", "", $this->rolesOptions),
            // Preferences
            Input::make('language', 'Language', 'select', 'language', 'none', 'preferences', 'localization', "", "", $this->languageOptions),
            Input::make('timezone', 'Timezone', 'select', 'timezone', 'nope', 'preferences', 'localization', "", "", $this->timezoneOptions),

        ];
    }
    // Action Bar Button
    public function actionBarButtons() : array
    {
        $type = $this->status;

        $buttons =  [
            // ActionBarButton::make('invoice', 'Créer une facture', 'storeQT()', 'sale_order'),
            ActionBarButton::make('send-email', __('Send by Email'), "", 'storable', true),
            // Add more buttons as needed
        ];

        // Define the custom order of button keys
        $customOrder = ['send-email', 'confirm', 'send', 'preview']; // Adjust as needed

        // Change dynamicaly the display order depends on status
        return $this->sortActionButtons($buttons, $customOrder, $type);
    }


    public function statusBarButtons() : array
    {
        return [
            StatusBarButton::make('never-connected', 'Never Connected', 'never-connected'),
            StatusBarButton::make('confirmed', 'Confirmed', 'confirmed'),
            // Add more buttons as needed
        ];
    }

    public function updatedPhoto(){
        // Validate the uploaded file
        $this->validate();
        if($this->user){
            $user = User::find($this->user->id);

            if(!$this->image_path){
                $this->image_path = $user->id . '_avatar.png';

                // $this->photo->storeAs('avatars', $this->image_path, 'public');
                $user->update([
                    'avatar' => $this->image_path,
                ]);
            }

            $this->photo->storeAs('avatars', $this->image_path, 'public');


            // Send success message
            session()->flash('message', 'Avatar updated successfully!');
        }
    }

    #[On('create-user')]
    public function createUser(){

        $this->validate();

        $user = User::create([
            'company_id' => current_company()->id,
            'current_company_id' => current_company()->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make("ndako"),
            'language_id' => $this->language,
            'timezone' => $this->timezone,
            'status' => $this->status ?? 'never-connected',
        ]);
        $user->save();

        $avatar = $user->id.'_avatar.png';
        if($this->photo){
            $this->photo->storeAs('avatars', $avatar, 'public');
        }
        $user->update([
            'avatar' => $avatar,
        ]);

        $user->assignRole($this->role);

        return $this->redirect(route('settings.users.show', ['user' => $user->id]), navigate: true);
    }

    #[On('update-user')]
    public function updateUser(){
        $user = User::find($this->user->id);

        $this->validate();
        if(!$this->image_path){
            $this->image_path = $user->id . '_avatar.png';
        }
        if($this->photo){
            $this->photo->storeAs('avatars', $this->image_path, 'public');
        }

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            // 'ava' => $this->avatar,
            'language_id' => $this->language,
            'timezone' => $this->timezone,
            'status' => $this->status,
        ]);
        $user->save();
        return $this->redirect(route('settings.users.show', ['user' => $user->id]), navigate: true);
    }

    public function updated(){
        $this->dispatch('change');
    }
}
