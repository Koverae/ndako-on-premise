<?php $__env->startSection('title', "Bookings"); ?>

<!-- Control Panel -->
<?php $__env->startSection('control-panel'); ?>
<?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('channelmanager::navbar.control-panel.booking-panel', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3267275571-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
<?php $__env->stopSection(); ?>
<!-- Page Content -->
<section class="w-100">
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('channelmanager::table.booking-table', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3267275571-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</section>
<!-- Page Content --><?php /**PATH D:\My Laravel Startup\ndako-premise\Modules/ChannelManager\resources/views/livewire/bookings/lists.blade.php ENDPATH**/ ?>