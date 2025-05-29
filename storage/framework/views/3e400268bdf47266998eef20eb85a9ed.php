
<nav class="navbar navbar-expand-md w-100 navbar-light d-block d-print-none k-sticky">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo -->
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="">
                <img src="<?php echo e(asset('assets/images/logo/logo-black.png')); ?>" alt="Ndako Logo" class="navbar-brand-image">
            </a>
        </h1>
        <!-- Logo End -->

        <!-- Navbar Buttons -->
        <div class="flex-row navbar-nav order-md-last">
            <div class="d-md-flex d-flex">
                <!-- Translate -->
                <div class="nav-item dropdown d-md-flex me-3">
                    <a href="#" class="px-0 nav-link" data-bs-toggle="dropdown" id="dropdownMenuButton" title="Translate" data-bs-toggle="tooltip" data-bs-placement="bottom">
                        <i class="bi bi-translate" style="font-size: 16px;"></i>
                    </a>
                </div>
                <!-- Translate End -->

                <!-- Chat & Notifications -->
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('app::components.notification-trigger', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1488412981-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <!-- Chat & Notifications End -->

                <!-- User's Avatar -->
                <div class="nav-item dropdown">
                    <a href="#" class="p-0 nav-link d-flex lh-1 text-reset" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url(<?php echo e(Storage::url('avatars/' . auth()->user()->avatar)); ?>)"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="https://docs.ndako.tech/v1/user-docs/introduction/" target="__blank" class="dropdown-item kover-navlink">Documentation</a>
                        <a href="https://docs.ndako.tech/v1/user-docs/faqs/contact-support.html" target="_blank" class="dropdown-item kover-navlink divider">Support</a>
                        <a href="<?php echo e(route('settings.users.show', ['user' => auth()->user()->id])); ?>" class="dropdown-item kover-navlink">My Profile</a>
                        <!-- Authentication -->
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <span  onclick="event.preventDefault(); this.closest('form').submit();" class="cursor-pointer kover-navlink dropdown-item">
                                Log Out
                            </span>
                        </form>
                        <!-- Authentication End -->
                    </div>
                </div>
                <!-- User's Avatar End -->
            </div>
        </div>
        <!-- Navbar Buttons End -->

        <!-- Navbar Menu -->
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                <ul class="navbar-nav">
                    <!-- Navbar Menu -->
                    <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">

                        <li class="nav-item" data-turbolinks>
                            <a class="nav-link kover-navlink" href="<?php echo e(route('dashboard')); ?>" style="margin-right: 5px;">
                              <span class="nav-link-title">
                                  <?php echo e(__('Dashboard')); ?>

                              </span>
                            </a>
                        </li>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_properties')): ?> <!-- manage_expenses -->
                        <li class="nav-item dropdown" data-turbolinks>
                            <a class="nav-link kover-navlink" href="#navbar-base" style="margin-right: 5px;" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                              <span class="nav-link-title">
                                  <?php echo e(__('Expenses')); ?>

                              </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <!-- Left Side -->
                                    <div class="dropdown-menu-column">
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('expenses.categories.lists')); ?>">
                                            <?php echo e(__('Expense Categories')); ?>

                                        </a>
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('expenses.lists')); ?>">
                                            <?php echo e(__('Expenses')); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_properties')): ?>
                        <li class="nav-item dropdown" data-turbolinks>
                            <a class="nav-link kover-navlink" href="#navbar-base" style="margin-right: 5px;" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                              <span class="nav-link-title">
                                  <?php echo e(__('Properties')); ?>

                              </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <!-- Left Side -->
                                    <div class="dropdown-menu-column">
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('properties.lists')); ?>">
                                            <?php echo e(__('Properties')); ?>

                                        </a>
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('properties.units.lists')); ?>">
                                            <?php echo e(__('Units')); ?>

                                        </a>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_maintenance_tasks')): ?>
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('tasks.lists')); ?>">
                                            <?php echo e(__('Maintenance Requests')); ?>

                                        </a>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_rooms')): ?>
                        <li class="nav-item dropdown" data-turbolinks>
                            <a class="nav-link kover-navlink" href="#navbar-base" style="margin-right: 5px;" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                              <span class="nav-link-title">
                                  <?php echo e(__('Rooms')); ?>

                              </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <!-- Left Side -->
                                    <div class="dropdown-menu-column">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_rooms')): ?>
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('properties.units.lists')); ?>">
                                            <?php echo e(__('Rooms')); ?>

                                        </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_maintenance_tasks')): ?>
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('tasks.lists')); ?>">
                                            <?php echo e(__('Maintenance Requests')); ?>

                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_reservations')): ?>
                        <li class="nav-item dropdown" data-turbolinks>
                            <a class="nav-link kover-navlink" href="#navbar-base" style="margin-right: 5px;" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                              <span class="nav-link-title">
                                  <?php echo e(__('Reservations')); ?>

                              </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <!-- Left Side -->
                                    <div class="dropdown-menu-column">
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('bookings.lists')); ?>">
                                            <?php echo e(__('Reservations')); ?>

                                        </a>
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('bookings.payments.lists')); ?>">
                                            <?php echo e(__('Payments')); ?>

                                        </a>
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('guests.lists')); ?>">
                                            <?php echo e(__('Guests')); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>


                        

                        

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access_settings')): ?>
                        <li class="nav-item dropdown" data-turbolinks>
                            <a class="nav-link kover-navlink" href="#navbar-base" style="margin-right: 5px;" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                              <span class="nav-link-title">
                                  <?php echo e(__('Configuration')); ?>

                              </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <!-- Left Side -->
                                    <div class="dropdown-menu-column">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access_settings')): ?>
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('settings.general', ['view' => 'general'])); ?>">
                                            <?php echo e(__('Settings')); ?>

                                        </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_staff')): ?>
                                        <a class=" kover-navlink dropdown-item" wire:navigate href="<?php echo e(route('settings.users')); ?>">
                                            <?php echo e(__('Users')); ?>

                                        </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_roles')): ?>
                                        <a class=" kover-navlink dropdown-item" href="<?php echo e(route('roles.lists')); ?>" wire:navigate>
                                            <?php echo e(__('Roles & Permissions')); ?>

                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>

                    </div>
                    <!-- Navbar Menu -->
                </ul>
            </div>
        </div>
        <!-- Navbar Menu End -->

    </div>

    <?php if(!current_company()->is_onboarded && auth()->user()->hasRole(['owner', 'manager'])): ?>
    <div class="alert alert-warning <?php echo e(Route::currentRouteName() == 'onboarding' ? 'd-none' : ''); ?> d-flex align-items-center justify-content-between p-3 fs-5 sticky-top shadow-sm alert-dismissible fade show" role="alert">
        <span class="fs-3"><i class="bi bi-exclamation-circle me-2"></i> Get the most out of Ndako! Let's complete your setup</span>
        <div>
            <a href="<?php echo e(route('onboarding')); ?>" class="rounded btn btn-sm btn-primary me-2 fs-3">Start Now</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php endif; ?>

    <?php if(current_company()->team->subscription('main')->isOnTrial()): ?>
    <div class="setting_block">
        <div class="mt-2 alert alert-warning">
            <p>⏳ Your trial will expire in <b><?php echo e(getRemainingTrialDays()); ?></b>! <a href="<?php echo e(route('subscribe')); ?>" class=""><strong>Upgrade now</strong></a> to continue managing your properties effortlessly with Ndako’s full suite of tools</p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Controls Panel -->
    <?php echo $__env->yieldContent('control-panel'); ?>
    <!-- Controls Panel -->

</nav>
<?php /**PATH D:\My Laravel Startup\ndako-premise\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>