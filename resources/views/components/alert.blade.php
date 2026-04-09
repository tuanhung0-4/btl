@props(['type' => 'success', 'message'])

<div {{ $attributes->merge(['class' => "alert alert-$type"]) }} style="padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; background: {{ $type === 'success' ? '#dcfce7' : '#fee2e2' }}; color: {{ $type === 'success' ? '#166534' : '#991b1b' }}; border: 1px solid {{ $type === 'success' ? '#bbf7d0' : '#fecaca' }}; animate: fade-in 0.3s ease;">
    <i class="fas {{ $type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
    <span>{{ $message }}</span>
</div>
