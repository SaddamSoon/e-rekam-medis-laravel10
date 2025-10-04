@if($jt->status == 'pending')
        <button class="btn" id="approve" data-idj="{{ $jt->id }}" data-nama-pasien="{{ $jt->nama_pasien }}"><i class="fa-solid fa-check-to-slot text-primary"></i></button>
@elseif($jt->status == 'dikonfirmasi')
        <button class="btn" id="clear" data-idj="{{ $jt->id }}" data-nama-pasien="{{ $jt->nama_pasien }}"><i class="fa-solid fa-person-circle-check text-success"></i></button>
@elseif($jt->status == 'batal')

@elseif($jt->status == 'selesai')
        
@endif
