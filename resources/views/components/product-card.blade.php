@props(['product', 'bestSellerRank' => null])

<div class="card" style="padding: 0; overflow: hidden; height: 100%; transition: transform 0.2s; border: 1px solid #e2e8f0; position: relative;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
    @if($bestSellerRank)
        @php
            $colors = [1 => '#f59e0b', 2 => '#f97316', 3 => '#fbbf24']; // Gold, Orange, Yellow
            $badgeColor = $colors[$bestSellerRank] ?? '#ef4444';
            $fireCount = 4 - $bestSellerRank;
        @endphp
        <div style="position: absolute; top: 10px; left: 10px; z-index: 10; background: {{ $badgeColor }}; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; display: flex; align-items: center; gap: 4px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
            @for($i = 0; $i < $fireCount; $i++)
                <i class="fas fa-fire" style="color: #fff;"></i>
            @endfor
            TOP {{ $bestSellerRank }}
        </div>
    @endif

    <div style="height: 180px; background: #f1f5f9; position: relative;">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                <i class="fas fa-image fa-3x"></i>
            </div>
        @endif
        <div style="position: absolute; top: 0.5rem; right: 0.5rem;">
            <x-badge :type="$product->status === 'available' ? 'success' : 'danger'">
                {{ $product->status === 'available' ? 'Còn món' : 'Hết món' }}
            </x-badge>
        </div>
    </div>
    <div style="padding: 1rem;">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
            <h4 style="font-weight: 600; font-size: 1.1rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                {{ $product->name }}
                @if($bestSellerRank)
                    <i class="fas fa-fire" style="color: #ef4444; font-size: 0.9rem;" title="Best Seller #{{ $bestSellerRank }}"></i>
                @endif
            </h4>
            <span style="font-weight: 700; color: #6366f1;">{{ number_format($product->price, 0, ',', '.') }}đ</span>
        </div>
        <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
            {{ $product->description ?? 'Không có mô tả cho món này.' }}
        </p>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning" style="flex: 1; padding: 0.4rem; justify-content: center;">
                <i class="fas fa-edit"></i> Sửa
            </a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Xóa vào thùng rác?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width: 100%; padding: 0.4rem; justify-content: center;">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
        </div>
    </div>
</div>
