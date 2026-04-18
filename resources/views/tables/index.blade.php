@extends('layouts.master')

@section('content')
<!-- Header Section -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <p style="color: var(--color-gray-500); font-size: 0.95rem; margin: 0;">Theo dõi trạng thái các bàn trong quán.</p>
    </div>
    <a href="{{ route('tables.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm bàn
    </a>
</div>

<!-- Tables Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
    @forelse($tables as $table)
    <div class="card" style="text-align: center; border-top: 4px solid {{ $table->status === 'empty' ? 'var(--color-success)' : 'var(--color-warning)' }}; position: relative;">
        <!-- Status Badge -->
        <div style="position: absolute; top: 1rem; right: 1rem;">
            @if($table->status === 'empty')
                <span class="badge badge-success"><i class="fas fa-check-circle"></i> Trống</span>
            @else
                <span class="badge badge-warning"><i class="fas fa-users"></i> Có khách</span>
            @endif
        </div>

        <!-- Icon -->
        <div style="font-size: 3rem; margin: 1rem 0; {{ $table->status === 'empty' ? 'color: var(--color-success)' : 'color: var(--color-warning)' }};">
            <i class="fas fa-chair"></i>
        </div>

        <!-- Table Info -->
        <h3 style="margin-bottom: 0.5rem; font-weight: 700; font-size: 1.2rem;">{{ $table->name }}</h3>
        <p style="font-size: 0.8rem; color: var(--color-gray-500); margin-bottom: 1.5rem;">{{ $table->description ?? 'Bàn trong quán' }}</p>

        <!-- Actions -->
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            @if($table->status === 'occupied' && $table->currentOrder)
                <a href="{{ route('orders.show', $table->currentOrder->id) }}" class="btn btn-primary" style="justify-content: center;">
                    <i class="fas fa-receipt"></i> Xem đơn hàng
                </a>
            @endif
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('tables.edit', $table->id) }}" class="btn btn-outline" style="flex: 1; justify-content: center;">
                    <i class="fas fa-edit"></i> Sửa
                </a>
                @if($table->status === 'empty')
                    <form action="{{ route('tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('Xóa bàn này? Không thể phục hồi.')" style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center;">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: var(--color-white); border-radius: var(--radius); border: 2px dashed var(--color-gray-300);">
        <i class="fas fa-chair" style="font-size: 3rem; color: var(--color-gray-300); margin-bottom: 1rem;"></i>
        <h3 style="color: var(--color-gray-500); margin-bottom: 0.5rem;">Chưa có bàn nào</h3>
        <p style="color: var(--color-gray-400); margin-bottom: 1.5rem;">Hãy thêm bàn mới để bắt đầu</p>
        <a href="{{ route('tables.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tạo bàn mới
        </a>
    </div>
    @endforelse
</div>
@endsection
