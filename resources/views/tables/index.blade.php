@extends('layouts.master')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 700;">Quản lý bàn</h2>
        <p style="color: #64748b; font-size: 0.875rem;">Theo dõi trạng thái các bàn trong quán.</p>
    </div>
    <a href="{{ route('tables.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm bàn mới
    </a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
    @foreach($tables as $table)
    <div class="card" style="text-align: center; border-top: 5px solid {{ $table->status === 'empty' ? 'var(--success)' : 'var(--danger)' }};">
        <div style="font-size: 2.5rem; color: {{ $table->status === 'empty' ? 'var(--success)' : 'var(--danger)' }}; margin-bottom: 1rem;">
            <i class="fas fa-couch"></i>
        </div>
        <h3 style="margin-bottom: 0.5rem;">{{ $table->name }}</h3>
        <x-badge :type="$table->status === 'empty' ? 'success' : 'danger'" style="margin-bottom: 1rem;">
            {{ $table->status === 'empty' ? 'Trống' : 'Có khách' }}
        </x-badge>
        <p style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 1rem;">{{ $table->description }}</p>
        <div style="display: flex; flex-direction: column; gap: 0.5rem; justify-content: center;">
            @if($table->status === 'occupied' && $table->currentOrder)
                <a href="{{ route('orders.show', $table->currentOrder->id) }}" class="btn btn-primary" style="padding: 0.4rem; justify-content: center;">
                    <i class="fas fa-file-invoice"></i> Xem đơn hiện tại
                </a>
            @endif
            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                <a href="{{ route('tables.edit', $table->id) }}" class="btn" style="background: #f1f5f9; padding: 0.4rem 0.8rem; flex: 1;">
                    <i class="fas fa-edit"></i> Sửa
                </a>
                @if($table->status === 'empty')
                    <form action="{{ route('tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('Xóa bàn này?')" style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: #fee2e2; padding: 0.4rem 0.8rem; color: #b91c1c; width: 100%;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
