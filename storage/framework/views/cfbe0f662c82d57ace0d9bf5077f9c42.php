<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['value','status']));

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

foreach (array_filter((['value','status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php if (isset($component)) { $__componentOriginal796a7984edf44f570e493f91e29cf94b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal796a7984edf44f570e493f91e29cf94b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'app::components.form.button.action-bar.simple','data' => ['value' => $value,'status' => $status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app::form.button.action-bar.simple'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value),'status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($status)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal796a7984edf44f570e493f91e29cf94b)): ?>
<?php $attributes = $__attributesOriginal796a7984edf44f570e493f91e29cf94b; ?>
<?php unset($__attributesOriginal796a7984edf44f570e493f91e29cf94b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal796a7984edf44f570e493f91e29cf94b)): ?>
<?php $component = $__componentOriginal796a7984edf44f570e493f91e29cf94b; ?>
<?php unset($__componentOriginal796a7984edf44f570e493f91e29cf94b); ?>
<?php endif; ?><?php /**PATH D:\My Laravel Startup\ndako-premise\storage\framework\views/50ed2a633ce274903866cdfe72aadec8.blade.php ENDPATH**/ ?>