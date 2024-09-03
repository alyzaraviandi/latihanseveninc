<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        Request Details
     <?php $__env->endSlot(); ?>

    <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">Request Details</h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Here you can view the details of the request. Please
            review the information below.</p>
    </div>

    <div class="mt-6 border-t border-gray-100">
        <dl>
            <!-- Class Information -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Class</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    <?php echo e($request->class->name ?? 'N/A'); ?> - Professor:
                    <?php echo e($request->class->professor->name ?? 'N/A'); ?>

                </dd>
            </div>

            <!-- Status Information -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Status</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    <?php echo e(ucfirst($request->status)); ?>

                </dd>
            </div>

            <!-- Created At -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Created At</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    <?php echo e($request->created_at->format('Y-m-d H:i:s')); ?>

                </dd>
            </div>

            <!-- Requested Changes -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Requested Changes</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    <?php echo e($request->info); ?>

                </dd>
            </div>
        </dl>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="<?php echo e(route('professors.requestList')); ?>" class="text-sm font-semibold leading-6 text-gray-900">
            Back to Request List
        </a>

        <form action="<?php echo e(route('professors.denyRequest', $request->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit"
                class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                Deny
            </button>
        </form>

        <form action="<?php echo e(route('professors.grantRequest', $request->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit"
                class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Grant
            </button>
        </form>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php /**PATH D:\Alyzar\Laravel\Herd\project1\resources\views/professors/requestDetails.blade.php ENDPATH**/ ?>