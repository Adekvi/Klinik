@extends('layout.home')
@section('title', 'Soap')
@section('content')

{{-- <div class="tb-pasien">
    <table>
        
    </table>
</div> --}}
<div class="card table table-striped table-bordered" style="margin-top">
    <div class="card-header">
        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalSoap"><i class="bi bi-plus-lg"></i> Tambah Data</button>
    </div>
    <div class="card">
        <div class="card-body">
          <table class="table" style="border-bottom: 1px solid white;
          width: 50%;">
            <tbody>
                <tr>
                    <th scope="row">No RM</th>
                    <td>:</td>
                    <td>{{ $pasienid[0]['pasien']['no_rm'] }}</td>
                </tr>
                <tr>
                    <th scope="row">Nama Pasien</th>
                    <td>:</td>
                    <td>{{ $pasienid[0]['pasien']['nama_pasien'] }}</td>
                </tr>
                <tr>
                    <th scope="row">Alamat</th>
                    <td>:</td>
                    <td>{{ $pasienid[0]['pasien']['alamat'] }}</td>
                </tr>
            </tbody>
          </table>

            {{-- <div class="rm" style="display: flex">
              <p class="card-text">No RM</p> :
              <p>{{ $pasienid[0]['pasien']['no_rm'] }}</p>
            </div>
            <div class="nama" style="display: flex">
              <p class="card-title">Nama Pasien</p> :
              <p>{{ $pasienid[0]['pasien']['nama_pasien'] }}</p>
            </div>
            <div class="alamat" style="display: flex">
              <p class="card-text">Alamat</p>
              <p>{{ $pasienid[0]['pasien']['alamat'] }}</p>
            </div> --}}
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="table1">
                <thead class="table-primary" style="text-align: center;">
                    <tr>
                        {{-- <th>No</th> --}}
                        <th>TGL DAN JAM</th>
                        <th>PROFESI</th>
                        <th>SOAP</th>
                        <th>EDUKASI</th>
                        {{-- <th>Paraf</th> --}}
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    @foreach ($soap as $item)
                        <tr>
                          <td>{{date_format(date_create($item['created_at']), 'Y-m-d/H:i:s')
                          }}</td>
                          <td>{{ $item['profesi'] }}</td>
                          <td style="text-align: left">
                            S : {{ $item['rm_da']['a_riwayat_penyakit_skrg'] }} <br>
                            O : @if (empty($item['pasien']['isian']['p_tensi'])) - @else {{ $item['pasien']['isian']['p_tensi'] }} @endif <br>
                            A : {{ $item['diagnosa']['nm_diagno'] }} <br>
                            P : - {{ $item['resep'] }} <br> 
                            &nbsp;&nbsp;&nbsp;&nbsp; <strong>Keterangan : </strong>{{ $item['keterangan'] }} 
                        </td>
                          <td>{{ $item['edukasi'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- modal soap --}}
<div class="modal fade" id="modalSoap" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white;">Tindakan Dokter</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('dokter/store/'. $id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="profesi">Profesi</label>
              <input type="text" class="form-control mt-2 mb-2" name="profesi" id="profesi" value="Dokter" disabled placeholder="Dokter">
            </div>
            <div class="form-group">
              <label for="soap">SOAP</label>
              <select name="soap_a" id="soap_a" class="soap_a form-control">
                <option value="" disabled selected>Pilih Diagnosa</option>
                @foreach ($diagno as $item)
                <option value="{{ $item->id }}">{{ $item->nm_diagno }}</option>
                  @endforeach
                </select>
              {{-- <input type="text" name="soap_a" id="soap_a" class="form-control mt-2 mb-2 " placeholder="A"> --}}
              {{-- <input type="text" name="soap_p" id="soap_p" class="form-control mt-2 mb-2 " placeholder="Resep"> --}}
                <select name="soap_p" id="soap_p" class="soap_p form-control">
                  <option value="" disabled selected>Pilih Resep</option>
                    <option value="Antibiotik	Oral Tablet/ Kapsul	Amoxicillin	Amoxicillin 500mg
                    ">Antibiotik	Oral Tablet/ Kapsul	Amoxicillin	Amoxicillin 500mg
                    </option>
                    <option value="Antibiotik	Oral Tablet/ Kapsul	Cefadroxil	Cefadroxil 500mg	
                    ">Antibiotik	Oral Tablet/ Kapsul	Cefadroxil	Cefadroxil 500mg	
                    </option>
                    <option value="Analgesik, Antipiretik	Oral Cair	Fasidol Syr	Paracetamol 125mg/5mL	
                    ">Analgesik, Antipiretik	Oral Cair	Fasidol Syr	Paracetamol 125mg/5mL	
                    </option>
                    <option value="Antihistamin	Oral Tablet	Alleron	CTM 4mg	Rp300
                    ">Antihistamin	Oral Tablet	Alleron	CTM 4mg	Rp300
                    </option>
                    <option value="Flu dan Batuk	Oral Tablet	Bromifar Plus	Bromhexine hcl 8mg, GG 100mg	
                    ">Flu dan Batuk	Oral Tablet	Bromifar Plus	Bromhexine hcl 8mg, GG 100mg	
                    </option>
                    <option value="Antibiotik	Oral Cair	Fasiprim Syr	Trimethoprim 40mg, Sulfamethoxazole 200mg	
                    ">Antibiotik	Oral Cair	Fasiprim Syr	Trimethoprim 40mg, Sulfamethoxazole 200mg	
                    </option>
                    <option value="Multivitamin	Oral	Asam folat	Asam Folat 1000mcg	
                    ">Multivitamin	Oral	Asam folat	Asam Folat 1000mcg	
                    </option>
                    <option value="Eklamsia	Injeksi	Otsu-MgSO4	MgSO4 40%
                    ">Eklamsia	Injeksi	Otsu-MgSO4	MgSO4 40%
                    </option>
                    <option value="Kulit	Topikal	Scabimite 30g	Permethrin 5%	
                    ">Kulit	Topikal	Scabimite 30g	Permethrin 5%	
                    </option>
                  </select>
                {{-- <label for="keterangan">Keterangan Resep</label> --}}
                <input type="text" class="form-control mt-2 mb-2" name="keterangan" id="keterangan" placeholder="Keterangan Resep">
            </div>
            <div class="form-group">
                <label for="edukasi">Edukasi</label>
                <input type="text" class="form-control mt-2 mb-2" name="edukasi" id="edukasi" placeholder="Edukasi">
              </div>
            {{-- <div class="form-group">
                <label for="paraf">Paraf</label>
                <input type="text" class="form-control mt-2 mb-2" name="paraf" id="paraf" placeholder="Paraf">
              </div> --}}
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>


@endsection
@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css">
@endpush
@push('script')
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
{{-- <script>
  $(document).ready(function () {
    // $('.soap_a').select2({
      // });
      $('#soap_a').select2({
        placeholder:'SOAP A',
        ajax:{
          url:'/get-diagnosa',
          delay:250,
          dataType:'json',
          processResults:function(data){
            return {
              results: $.map(data, function (item){
                  return {
                    id: item.id,
                    tex:item.title
                  }
              })
            };
        };
        cache: true
      }
    })
  })
</script> --}}
@endpush