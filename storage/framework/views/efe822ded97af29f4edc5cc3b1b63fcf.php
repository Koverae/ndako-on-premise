<?php $__env->startSection('title', "Settings"); ?>

<!-- Control Panel -->
<?php $__env->startSection('control-panel'); ?>
<?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings::navbar.setting-panel', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1182459814-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
<?php $__env->stopSection(); ?>

<!-- Page Content -->
<section class="page-body">
    <!-- Settings -->
    <div class="k-row">
        <!-- Left Sidebar -->
        <div class="settings_tab border-end">

            <!-- General Settings -->
            <div class="cursor-pointer tab  <?php echo e($this->view == 'general' ? 'selected' : ''); ?>" wire:click="changePanel('general')">
                <!-- App Icon -->
                <div class="icon d-none d-md-block">
                    <img src="<?php echo e(asset('assets/images/apps/settings.png')); ?>" alt="">
                </div>
                <!-- App Name -->
                <span class="app_name">
                    General Setting
                </span>
            </div>

            <!-- Properties -->
            <div class="tab cursor-pointer <?php echo e($this->view == 'properties' ? 'selected' : ''); ?>" wire:click="changePanel('properties')">
                <!-- App Icon -->
                <div class="icon d-none d-md-block" >
                    <img src="<?php echo e(asset('assets/images/apps/reservation.png')); ?>" alt="">
                </div>
                <!-- App Name -->
                <span class="app_name">
                    Properties
                </span>
            </div>
            <!-- Properties End -->

            <!-- Channel Manager -->
            <div class="cursor-pointer tab <?php echo e($this->view == 'channel-manager' ? 'selected' : ''); ?>" wire:click="changePanel('channel-manager')">
                <!-- App Icon -->
                <div class="icon d-none d-md-block">
                    <img src="<?php echo e(asset('assets/images/apps/channel-manager.png')); ?>" alt="">
                </div>
                <!-- App Name -->
                <span class="app_name">
                    Channel Manager
                </span>
            </div>
            <!-- Channel Manager End -->

        </div>

        <!-- Right Sidebar -->
        <div class="settings">
            <!--[if BLOCK]><![endif]--><?php if($view == 'general'): ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings::settings.general', ['setting' => settings()]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1182459814-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php elseif($view == 'properties'): ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('properties::settings.property-setting', ['setting' => settings()]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1182459814-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php elseif($view == 'channel-manager'): ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('channelmanager::settings.channel-manager-setting', ['setting' => settings()]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1182459814-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</section>
<!-- Page Content End -->
<?php /**PATH D:\My Laravel Startup\ndako-premise\Modules/Settings\resources/views/livewire/general-setting.blade.php ENDPATH**/ ?>