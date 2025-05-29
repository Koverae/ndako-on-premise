<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'value',

]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'value',

]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<!-- Box -->

<div class="k_settings_box col-12 col-lg-6 k_searchable_setting" id="users">
    <!-- Right pane -->
    <div class="k_setting_right_pane">
        <form wire:submit.prevent="sendInvitation">
            <?php echo csrf_field(); ?>
            <div>
                <p class="k_form_label">
                    <!--[if BLOCK]><![endif]--><?php if($value->icon): ?>
                        <i class="inline-block bi <?php echo e($value->icon); ?>"></i>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <span class="ml-2"><?php echo e($value->label); ?></span>
                    <!--[if BLOCK]><![endif]--><?php if($value->help): ?>
                    <a href="<?php echo e($value->help); ?>" target="__blank" title="documentation" class="k_doc_link">
                        <i class="bi bi-question-circle-fill"></i>
                    </a>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </p>
                <div class="flex-wrap gap-2 d-flex">
                    <div class="gap-1 mb-2 row">
                        <input type="email" wire:model="friend_email" class="k-input col-lg-3 k_user_emails text-truncate" style="width: auto;" placeholder="Enter e-mail address">

                        <select class="k-input k_user_emails col-lg-3" wire:model="friend_role">
                            <option value="">----- Choose ------</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = current_company()->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role->id); ?>"><?php echo e(inverseSlug($role->name)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>

                        <select class="k-input k_user_emails w-100 col-lg-12" wire:model="friend_property">
                            <?php $__currentLoopData = current_company()->properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($property->id); ?>"><?php echo e($property->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>

                    </div>

                    <!-- Second select moved below while still being part of the Invite -->
                    <div class="w-100">
                        <span wire:click="sendInvitation" class="flex-shrink-0 btn btn-primary k_web_settings_invite w-75">
                            <strong wire:loading.remove>Invite</strong>
                            <span wire:loading wire:target="sendInvitation">...</span>
                        </span>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['friend_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

            </div>
            <div class="mt-4">
                <p class="k_form_label">
                    Pending Invites :
                </p>
                <div class="d-block">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $this->pending_invitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invitation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a class="cursor-pointer badge rounded-pill k_web_settings_users">
                        <?php echo e($invitation->email); ?>

                        <i wire:click.prevent="deleteInvitation(<?php echo e($invitation->id); ?>)" wire:confirm="Are you sure you want to cancel the invitation?" class="bi bi-x cancelled_icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Cancel the invitation."></i>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <span>No pending invitations.</span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div wire:loading>
                        ......
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH D:\My Laravel Startup\ndako-premise\Modules/App\resources/views/components/blocks/boxes/user/invite-user.blade.php ENDPATH**/ ?>