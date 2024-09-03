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
        Classes List
     <?php $__env->endSlot(); ?>

    <div class="mb-4 flex space-x-4">
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('classes.create')).'','class' => 'bg-blue-600 hover:bg-blue-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('classes.create')).'','class' => 'bg-blue-600 hover:bg-blue-700']); ?>Create Classes <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Class Name</th>
                    <th scope="col" class="px-6 py-3">Class ID</th>
                    <th scope="col" class="px-6 py-3">Students</th>
                    <th scope="col" class="px-6 py-3">Professor</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-6 py-4"><?php echo e($class->id); ?></td>
                        <td class="px-6 py-4"><?php echo e($class->name); ?></td>
                        <td class="px-6 py-4"><?php echo e($class->class_id); ?></td>
                        <td class="px-6 py-4">
                            <?php echo e($class->currentStudentCount()); ?> / <?php echo e($class->sum); ?>

                        </td>
                        <td class="px-6 py-4">
                            <?php echo e($class->professor->name ?? 'None'); ?>

                        </td>
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('classes.show', $class->id)); ?>"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4 bg-white shadow-md rounded-lg p-4 border border-gray-200"
            aria-label="Table navigation">
            <span
                class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto mr-4">
                Showing <?php echo e($classes->firstItem()); ?> to <?php echo e($classes->lastItem()); ?> of <?php echo e($classes->total()); ?> results
            </span>
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                <!-- Pagination links -->
                <?php if($classes->hasPages()): ?>
                    <li>
                        <a href="<?php echo e($classes->previousPageUrl()); ?>"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-gray-500 bg-white hover:bg-gray-100">Previous</a>
                    </li>
                    <?php for($i = 1; $i <= $classes->lastPage(); $i++): ?>
                        <li>
                            <a href="<?php echo e($classes->url($i)); ?>"
                                class="px-3 py-2 border border-gray-300 rounded-lg <?php echo e($i == $classes->currentPage() ? 'bg-blue-500 text-white' : 'bg-white text-gray-500 hover:bg-gray-100'); ?>">
                                <?php echo e($i); ?>

                            </a>
                        </li>
                    <?php endfor; ?>
                    <li>
                        <a href="<?php echo e($classes->nextPageUrl()); ?>"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-gray-500 bg-white hover:bg-gray-100">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
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
<?php /**PATH D:\Alyzar\Laravel\Herd\project1\resources\views\classes\index.blade.php ENDPATH**/ ?>