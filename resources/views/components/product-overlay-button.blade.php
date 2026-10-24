@props([
    'href' => '#',
    'label' => 'Lihat Semua Produk',
    'mobileLabel' => null,
    'icon' => null,
    'ariaLabel' => null,
])

@php
    $resolvedMobileLabel = $mobileLabel ?? (str_contains($label, 'Produk') ? trim(str_replace('Produk', '', $label)) : $label);
@endphp

<a href="{{ $href }}" 
   {{ $attributes->merge(['class' => 'btn btn-product-action rounded-pill']) }}
   aria-label="{{ $ariaLabel ?? $label }}">
    @if($icon)
        <i class="{{ $icon }} action-icon"></i>
    @endif
    <span class="d-none d-sm-inline">{{ $label }}</span>
    <span class="d-inline d-sm-none">{{ $resolvedMobileLabel }}</span>
</a>

@once
<style>
    /* === Reusable Product Action / Overlay Button === */
    .btn-product-action {
        background: linear-gradient(135deg, #e8b535 0%, #f4c842 100%);
        color: #1a1a1a !important;
        border: none;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 0.52rem 1.35rem;
        border-radius: 50px;
        box-shadow: 0 4px 14px rgba(232, 181, 53, 0.32);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        white-space: nowrap !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        text-decoration: none;
        max-width: 90%;
    }

    .btn-product-action:hover {
        background: linear-gradient(135deg, #f4c842 0%, #e8b535 100%);
        color: #000 !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(232, 181, 53, 0.45);
    }

    .btn-product-action:active {
        transform: translateY(0);
    }

    .btn-product-action .action-icon {
        font-size: 0.92rem;
        transition: transform 0.2s ease;
        flex-shrink: 0;
    }

    .btn-product-action:hover .action-icon {
        transform: scale(1.12);
    }

    @media (max-width: 767.98px) {
        .btn-product-action {
            font-size: 0.76rem;
            padding: 0.35rem 0.85rem;
            gap: 0.35rem;
        }
        .btn-product-action .action-icon {
            font-size: 0.82rem;
        }
    }

    @media (max-width: 575.98px) {
        .btn-product-action {
            font-size: 0.72rem;
            padding: 0.3rem 0.75rem;
            gap: 0.3rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        }
        .btn-product-action .action-icon {
            font-size: 0.78rem;
        }
    }
</style>
@endonce
