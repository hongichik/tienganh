<div class="ai-hint-container" style="background: #f0f9ff; border-left: 4px solid #0284c7; border-radius: 8px; padding: 14px; margin: 10px 0; font-size: 14px; line-height: 1.6;">
    
    @if(!empty($dich_nghia))
    <div style="margin-bottom: 12px;">
        <strong style="color: #0369a1;">📖 Dịch nghĩa:</strong><br>
        {{ $dich_nghia }}
    </div>
    @endif

    @if(!empty($tense))
    <div style="margin-bottom: 12px;">
        <strong style="color: #0369a1;">⏰ Thì:</strong><br>
        {{ $tense }}
    </div>
    @endif

    @if(!empty($tu_khoa))
    <div style="margin-bottom: 12px;">
        <strong style="color: #0369a1;">🔑 Từ khóa:</strong><br>
        {{ $tu_khoa }}
    </div>
    @endif

    @if(!empty($ngữ_cảnh))
    <div style="margin-bottom: 12px;">
        <strong style="color: #0369a1;">🎯 Ngữ cảnh:</strong><br>
        {{ $ngữ_cảnh }}
    </div>
    @endif

    @if(!empty($cong_thuc))
    <div style="margin-bottom: 12px;">
        <strong style="color: #0369a1;">🔧 Công thức trả lời:</strong><br>
        <code style="background: #e0f2fe; padding: 4px 8px; border-radius: 4px;">{{ $cong_thuc }}</code>
    </div>
    @endif

    @if(!empty($tro_loi_ngan_gon))
    <div style="margin-bottom: 12px;">
        <strong style="color: #0369a1;">💬 Trả lời (ngắn gọn):</strong><br>
        <em>{{ $tro_loi_ngan_gon }}</em>
    </div>
    @endif

    @if(!empty($tro_loi_mo_rong))
    <div style="margin-bottom: 12px;">
        <strong style="color: #0369a1;">📝 Trả lời (mở rộng):</strong><br>
        {{ $tro_loi_mo_rong }}
    </div>
    @endif

    @if(!empty($ly_do_thì))
    <div>
        <strong style="color: #0369a1;">💡 Lý do dùng thì:</strong><br>
        <small>{{ $ly_do_thì }}</small>
    </div>
    @endif
    
</div>
