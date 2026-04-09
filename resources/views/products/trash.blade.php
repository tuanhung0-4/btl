@extends('layouts.master')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 700;">Thùng rác</h2>
        <p style="color: #64748b; font-size: 0.875rem;">Các món đã xóa tạm thời.</p>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-secondary" style="background: #64748b; color: white;">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="card">
    @if($products->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Món ăn</th>
                <th style="text-align: right;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span style="font-weight: 600;">{{ $product->name }}</span>
                        <span style="font-size: 0.8rem; color: #94a3b8;">{{ $product->category->name }}</span>
                    </div>
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <form action="{{ route('products.restore', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="padding: 0.4rem 0.8rem;">
                                <i class="fas fa-undo"></i> Khôi phục
                            </button>
                        </form>
                        <form action="{{ route('products.forceDelete', $product->id) }}" method="POST" onsubmit="return confirm('Xóa vĩnh viễn không thể khôi phục?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem;">
                                <i class="fas fa-trash"></i> Xóa vĩnh viễn
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div style="text-align: center; padding: 2rem;">
            <p style="color: #94a3b8;">Thùng rác trống</p>
        </div>
    @endif
</div>
@endsection
