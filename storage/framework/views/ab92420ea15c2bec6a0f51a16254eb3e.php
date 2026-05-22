<div class="relative">
    <button wire:click="toggleAberto" class="relative p-1 text-gray-500 hover:text-indigo-600 transition-colors">
        🔔
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($naoLidas > 0): ?>
            <span
                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                <?php echo e($naoLidas); ?>

            </span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </button>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aberto): ?>
        <div class="absolute right-0 top-8 w-80 bg-white rounded-xl shadow-lg border border-gray-100 z-50">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <span class="font-semibold text-sm text-gray-700">Notificações</span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($naoLidas > 0): ?>
                    <button wire:click="marcarTodasLidas" class="text-xs text-indigo-500 hover:text-indigo-700">
                        Marcar todas como lidas
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $notificacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $data = is_array($notificacao->data) ? $notificacao->data : json_decode($notificacao->data, true) ?>
                    <div class="px-4 py-3 <?php echo e($notificacao->read_at ? 'opacity-50' : 'bg-indigo-50'); ?>">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold"><?php echo e($data['autor']); ?></span>
                            comentou no atendimento de
                            <span class="font-semibold"><?php echo e($data['pessoa']); ?></span>
                        </p>
                        <p class="text-xs text-gray-400 mt-1 truncate"><?php echo e($data['comentario']); ?></p>
                        <p class="text-xs text-gray-300 mt-1"><?php echo e($notificacao->created_at->diffForHumans()); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-4 py-6 text-center text-gray-400 text-sm">
                        Nenhuma notificação.
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /var/www/html/resources/views/livewire/notificacao-sininho.blade.php ENDPATH**/ ?>